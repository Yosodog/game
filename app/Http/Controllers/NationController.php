<?php

namespace App\Http\Controllers;

use App\Models\Flags;
use App\Models\Nation\Cities;
use App\Models\Nation\Nations;
use App\Models\Properties;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\View\View;

class NationController extends Controller
{
    /**
     * Store the request for later use
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * View nation
     *
     * @param int|null $id
     * @return \Illuminate\Contracts\View\View
     */
    public function view(int $id = null) : \Illuminate\Contracts\View\View
    {
        // Store the ID in a variable. If it's null, store the user's nation ID
        $nID = $id ?? Auth::user()->nation->id;

        // Get the nation model
        $nation = Nations::getNationByID($nID);
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

        return view("nation.view", [
            "nation" => $nation
        ]);
    }

    /**
     * Controller for displaying the create nation page.
     * Should only be viewed if they're logged in and don't have a nation
     *
     * @return mixed
     */
    public function create()
    {
        // Check if they have a nation. If they do, then redirect them to it
        if (Auth::user()->hasNation)
            return redirect("/nation/view");

        // Get all flags
        $flags = Flags::all();

        return view("nation.create", [
            "flags" => $flags
        ]);
    }

    /**
     * Create a nation
     *
     * @param Request $request
     * @return mixed
     */
    public function createPOST()
    {
        // Check if they have a nation. If they do, then redirect them to it
        if (Auth::user()->hasNation)
            return redirect("/nation/view");

        // Validate the request
        $this->validate($this->request, [
            'name' => 'required|unique:nations|max:25',
            'capital' => 'required|max:25',
            'flag' => 'required|integer|exists:flags,id'
        ]);

        // If it's valid, create the nation
        $nation = Nations::create([
            'user_id' => Auth::user()->id,
            'name' => $this->request->name,
            'flagID' => $this->request->flag
        ]);

        // Create their capital city
        Cities::create([
            'nation_id' => $nation->id,
            'name' => $this->request->capital,
        ]);

        // TODO display errors on the page if something is invalid

        // Update user model to say that they now have a nation
        Auth::user()->hasNation = true;
        Auth::user()->save();

        $this->request->session()->flash("alert-success", ["Congrats, you've created your nation!"]);

        return redirect("/nation/view");
    }

    public function allNations()
    {
        $nations = Nations::paginate(25);

        $nations->load("alliance"); // Load alliance info here so we don't have to query a billion times in the view

        return view ("nation.all", [
            "nations" => $nations
        ]);
    }
}
