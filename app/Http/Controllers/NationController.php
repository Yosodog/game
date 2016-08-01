<?php

namespace App\Http\Controllers;

use App\Models\Nation\Nations;
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

        return view("nation.create");
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
        ]);

        // If it's valid, create the nation
        $nation = Nations::create([
            'user_id' => Auth::user()->id,
            'name' => $this->request->name,
        ]);

        // TODO display errors on the page if something is invalid

        // Update user model to say that they now have a nation
        Auth::user()->hasNation = true;
        Auth::user()->save();

        $this->request->session()->flash("alert-success", ["Congrats, you've created your nation!"]);

        return redirect("/nation/view");
    }
}