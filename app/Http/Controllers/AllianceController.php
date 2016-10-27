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
}
