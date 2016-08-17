<?php

namespace App\Http\Controllers;

use App\Models\Nation\Cities;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Store the request for later use
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * CityController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Displays a user's city overview page
     */
    public function overview()
    {
        return view("nation.cities.overview");
    }

    /**
     * Displays a city's page
     */
    public function view($id)
    {
        $city = Cities::find($id);

        return view("nation.cities.view", [
            "city" => $city
        ]);
    }

    /**
     * Creates a city
     */
    public function create()
    {
        $this->validate($this->request, [
            'name' => 'required|max:25'
        ]);

        Cities::create([
            'nation_id' => Auth::user()->nation->id,
            'name' => $this->request->name,
        ]);

        $this->request->session()->flash("alert-success", ["{$this->request->name} has been created!"]);

        return redirect("/cities/");
    }
}
