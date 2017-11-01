<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Flags;
use Illuminate\View\View;
use App\Models\Properties;
use Illuminate\Http\Request;
use App\Models\Nation\Cities;
use App\Models\Nation\Nations;
use App\Models\Nation\Resources;

class NationController extends Controller
{
    /**
     * Store the request for later use.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * NationController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * View nation.
     *
     * @param int|null $id
     * @return \Illuminate\Contracts\View\View
     */
    public function view(int $id = null) : \Illuminate\Contracts\View\View
    {
        // Store the ID in a variable. If it's null, store the user's nation ID
        $nID = $id ?? Auth::user()->nation->id;

        // Get the nation model
        try
        {
            $nation = Nations::getNationByID($nID);
        }
        catch (\Exception $e)
        {
            return view("errors.general")
                ->with('error', 'That nation doesn\'t exist');
        }

        $nation->loadFullNation();
        // Get properties so we don't have to query it for every city
        $properties = Properties::all();

        // Setup city stuff
        foreach ($nation->cities as $city)
        {
            $city->setupProperties($properties);
            $city->calcStats();
        }

        $nation->calcStats();

        // TODO check if nation doesn't exist

        return view('nation.view', [
            'nation' => $nation,
        ]);
    }

    /**
     * Controller for displaying the create nation page.
     * Should only be viewed if they're logged in and don't have a nation.
     *
     * @return mixed
     */
    public function create()
    {
        // Check if they have a nation. If they do, then redirect them to it
        if (Auth::user()->hasNation)
            return redirect('/nation/view');

        // Get all flags
        $flags = Flags::all();

        return view('nation.create', [
            'flags' => $flags,
        ]);
    }

    /**
     * Create a nation.
     *
     * @return mixed
     */
    public function createPOST()
    {
        // Check if they have a nation. If they do, then redirect them to it
        if (Auth::user()->hasNation)
            return redirect('/nation/view');

        // Validate the request
        $this->validate($this->request, [
            'name' => 'required|unique:nations|max:25',
            'capital' => 'required|max:25',
            'flag' => 'required|integer|exists:flags,id',
        ]);

        // If it's valid, create the nation
        $this->createNation();

        // TODO display errors on the page if something is invalid

        // Update user model to say that they now have a nation
        Auth::user()->hasNation = true;
        Auth::user()->save();

        $this->request->session()->flash('alert-success', ["Congrats, you've created your nation!"]);

        return redirect('/nation/view');
    }

    /**
     * Creates a nation.
     */
    protected function createNation()
    {
        $nation = Nations::create([
            'user_id' => Auth::user()->id,
            'name' => $this->request->name,
            'flagID' => $this->request->flag,
        ]);

        // Create their capital city
        Cities::create([
            'nation_id' => $nation->id,
            'name' => $this->request->capital,
            'land' => 20,
        ]);

        Resources::create([
            'nationID' => $nation->id,
            'money' => 50000000,
            'coal' => 100,
            'iron' => 100,
            'clay' => 100,
            'cement' => 100,
            'timber' => 100,
            'wheat' => 100,
            'water' => 100,
        ]);
    }

    /**
     * Display all nations page with some info about them.
     *
     * @return View
     */
    public function allNations()
    {
        $nations = Nations::paginate(25);

        $nations->load('user'); // Load user info here so we don't have to query a billion times in the view
        $nations->load('alliance'); // Load alliance info here so we don't have to query a billion times in the view

        return view('nation.all', [
            'nations' => $nations,
        ]);
    }

    public function postSearch(Request $request)
    {
        return redirect("/nations/$request->category/$request->search");
    }

    public function search($category, $search)
    {
        switch ($category)
        {
            case 'nName':
                $nations = Nations::where('name', 'like', '%'.$search.'%')->paginate(25);
                break;
            case 'nLeader':
                //search users with search term, add to array, do WhereIn array to get nations
                $userIDs = [];
                $users = User::where('name', 'like', '%'.$search.'%')->get();
                foreach ($users as $user)
                {
                    array_push($userIDs, $user->id);
                }
                $nations = Nations::whereIn('user_id', $userIDs)->paginate(25);
                break;
            case 'aName':
                //search alliances with search term, add to array, do WhereIn array to get nations
                $allianceIDs = [];
                $alliances = Alliance::where('name', 'like', '%'.$search.'%')->get();
                foreach ($alliances as $alliance)
                {
                    array_push($userIDs, $alliance->id);
                }
                $nations = Nations::whereIn('allianceID', $allianceIDs)->paginate(25);
                break;
            default:
                //combine every form of search
                $allianceIDs = [];
                $userIDs = [];

                $alliances = Alliance::where('name', 'like', '%'.$search.'%')->get();
                $users = User::where('name', 'like', '%'.$search.'%')->get();

                foreach ($alliances as $alliance)
                {
                    array_push($allianceIDs, $alliance->id);
                }
                foreach ($users as $user)
                {
                    array_push($userIDs, $user->id);
                }

                $nations = Nations::whereIn('allianceID', $allianceIDs)
                    ->orWhereIn('user_id', $userIDs)
                    ->orWhere('name', 'like', '%'.$search.'%')->paginate(25);
        }
        $nations->load('user'); // Load user info here so we don't have to query a billion times in the view
        $nations->load('alliance'); // Load alliance info here so we don't have to query a billion times in the view

        return view('nation.all', [
            'nations' => $nations,
            'search' => $search,
        ]);
    }

    /**
     * Display edit nation page.
     *
     * @return View
     */
    public function edit()
    {
        $nation = Auth::user()->nation;
        $flags = Flags::all();

        return view('nation.edit', [
                'nation' => $nation,
                'flags' => $flags,
        ]);
    }

    /**
     * PATCH: /nation/edit/renameNation.
     *
     * Changes the name of a nation
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function renameNation()
    {
        // get user nation
        $nation = Auth::user()->nation;
        // validate nation name change, make sure it is unique
        $this->validate($this->request, [
                'name' => 'required|unique:nations,name|max:255',
        ]);

        // actually change the name
        $nation->name = $this->request->name;
        $nation->save();

        return redirect('/nation/edit')->with('alert-success', ['Nation name changed successfully!']);
    }

    /**
     * PATCH: /nation/edit/changeMotto.
     *
     * Changes the motto of a nation
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeMotto()
    {
        // get user nation
        $nation = Auth::user()->nation;

        // actually change the motto
        $nation->motto = '"'.$this->request->motto.'"';
        $nation->save();

        return redirect('/nation/edit')->with('alert-success', ['Nation motto changed successfully!']);
    }

    /**
     * PATCH: /nation/edit/changeFlag.
     *
     * Changes the flag of a nation
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function changeFlag()
    {
        // get user nation
        $nation = Auth::user()->nation;

        // confirm the flag exists
        $this->validate($this->request, [
                'flag' => 'required|integer|exists:flags,id',
        ]);

        // actually change the motto
        $nation->flagID = $this->request->flag;
        $nation->save();

        return redirect('/nation/edit')->with('alert-success', ['Nation flag changed successfully!']);
    }
}
