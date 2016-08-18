<?php

namespace App\Http\Controllers;

use App\Models\BuildingTypes;
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
     *
     * @param int
     */
    public function view(int $id)
    {
        $city = Cities::find($id);

        $buildings = BuildingTypes::all();

        $isOwner = $city->isOwner();

        return view("nation.cities.view", [
            "city" => $city,
            "buildings" => $buildings,
            "isOwner" => $isOwner
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

    public function buyLand(int $id)
    {
        // Get the city
        $city = Cities::find($id);
        // Check if the user owns the city
        if (!$city->isOwner())
            abort(403);

        // TODO calculate the cost of land

        $this->validate($this->request, [
            'amount' => 'required',
        ]);

        $city->land += $this->request->amount;
        $city->save();

        $this->request->session()->flash("alert-success", ["You've bought {$this->request->amount} sq mi of land!"]);

        return redirect("/cities/view/$id");
    }
}
