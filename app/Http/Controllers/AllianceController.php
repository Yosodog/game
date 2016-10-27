<?php

namespace App\Http\Controllers;

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
        if (Auth::user()->nation->hasAlliance())
            return redirect("/alliance/".Auth::user()->nation->alliance->id);

        $flags = Flags::all();

        return view("alliances.create", [
            "flags" => $flags
        ]);
    }
}
