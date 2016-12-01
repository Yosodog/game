<?php

namespace App\Http\Controllers;

use App\Models\Alliance;
use App\Models\Flags;
use App\Models\Nation\Nations;
use Illuminate\Http\Request;
use Auth;

use App\Http\Requests;

class AllianceController extends Controller
{
    /**
     * Store the request for later use
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * AllianceController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Route to create the create an alliance page
     */
    public function create()
    {
        if (Auth::user()->nation->hasAlliance()) // Checking to make sure they don't already have an alliance
            return redirect("/alliance/".Auth::user()->nation->alliance->id);

        $flags = Flags::all();

        return view("alliance.create", [
            "flags" => $flags
        ]);
    }

    /**
     * POST: /alliance/create
     *
     * Creates an alliance
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createPOST()
    {
        if (Auth::user()->nation->hasAlliance()) // Checking to make sure they don't already have an alliance
            return redirect("/alliance/".Auth::user()->nation->alliance->id);

        $this->validate($this->request, [
            "name" => "required|unique:alliances|max:25",
            "forumURL" => "required|url|active_url",
            "irc" => "required",
            "description" => "required",
            'flag' => 'required|integer|exists:flags,id'
        ]);

        $alliance = Alliance::create([
            "name" => $this->request->name,
            "description" => $this->request->description,
            "forumURL" => $this->request->forumURL,
            "IRCChan" => $this->request->irc,
            "flagID" => $this->request->flag
        ]);

        // Set the user's alliance to this newly created one
        Auth::user()->nation->allianceID = $alliance->id;
        Auth::user()->nation->save();

        return redirect("/alliance/$alliance->id");
    }

    /**
     * GET: /alliance/{$alliance}
     *
     * Gets the alliance and displays the alliance page
     *
     * @param Alliance $alliance
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(Alliance $alliance)
    {
        // We could get the members by eager loading, but we want to paginate so gotta do it special
        $nations = Nations::where("allianceID", $alliance->id)->paginate(15);
        $nations->load("user");

        return view("alliance.view", [
            "alliance" => $alliance,
            "nations" => $nations
        ]);
    }

    /**
     * GET: /alliances
     *
     * Returns a view with all the alliances in the game with some info about them
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewAll()
    {
        $alliances = Alliance::paginate(25);
        $alliances->load("nations"); // Load this here so we don't have to query for every alliance to get their mem num

        return view("alliance.all", [
            "alliances" => $alliances
        ]);
    }
    
    /**
     * PATCH: /alliance/{$alliance}/leave
     *
     * Allows the user to leave an alliance.
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function leaveAlliance(Alliance $alliance)
    {
    	if (!Auth::user()->hasNation)
    		abort(403);
    	
    	$nation = Auth::user()->nation;
    	
    	if ($alliance->id == $nation->allianceID)
    	{
    		$nation->allianceID = null;
    		$nation->save();
    		$name = $alliance->name;
    		
    		if ($alliance->countMembers() == 0) $alliance->delete();
			
    		$this->request->session()->flash("alert-success", ["You have left your alliance, ".$name."!"]);
    		 
    		return redirect("/alliances");
    	}
    	else
    	{
    		$this->request->session()->flash("alert-warning", ["You are not a member of this alliance!"]);
    		return redirect("/alliances");
    	}
    	
    }
    
    /**
     * PATCH: /alliance/{$alliance}/join
     *
     * Allows the user to leave an alliance.
     *
     * @param Alliance $alliance
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function joinAlliance(Alliance $alliance)
    {
    	if (!Auth::user()->hasNation)
    		abort(403);
    		 
    		$nation = Auth::user()->nation;
    		
    		if ($nation->allianceID == $alliance->id)
    		{
    		 	$this->request->session()->flash("alert-warning", ["You are already a member of this alliance!"]);
    		}
    		elseif ($nation->allianceID != null)
    		{
    			$this->request->session()->flash("alert-warning", ["You are already a member of an alliance! Leave that one before joining this one!"]);
    		}
    		else
    		{
    			$nation->allianceID = $alliance->id;
    			$nation->save();
    			$this->request->session()->flash("alert-success", ["You have successfully joined ".$alliance->name."!"]);
    		}
    		
    		return redirect("/alliance/".$alliance->id);
    }
}
