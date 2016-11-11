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

        return view("alliances.create", [
            "flags" => $flags
        ]);
    }

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
}
