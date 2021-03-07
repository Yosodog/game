<?php

namespace App\Http\Controllers;

use App\Models\BuildingTypes;
use App\Models\Nation\Building;
use App\Models\Nation\BuildingQueue;
use App\Models\Nation\Cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Store the request for later use.
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
     * Displays a user's city overview page.
     */
    public function overview()
    {
        return view('nation.cities.overview');
    }

    /**
     * Displays a city's page.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(int $id)
    {
        $city = Cities::find($id);

        $city->loadFullCity();
        $city->calcStats();

        $buildingTypes = BuildingTypes::all();

        $isOwner = $city->isOwner();

        /*
         * In order to avoid having to query the buildings table a thousand times on the city view page
         * we'll use one query to get all the buildings in a city and then store them in an array like:
         * "building_id" => "quantity"
         * Then to get the quantity on the view just do $quantity[$building_id]
         */
        $quantity = [];
        foreach ($city->buildings as $building)
            $quantity[$building->building_id] = $building->quantity;

        return view('nation.cities.view', [
            'city' => $city,
            'buildingTypes' => $buildingTypes,
            'isOwner' => $isOwner,
            'quantity' => $quantity,
        ]);
    }

    /**
     * Creates a city.
     */
    public function create()
    {
        $this->validate($this->request, [
            'name' => 'required|max:25',
        ]);

        Cities::create([
            'nation_id' => Auth::user()->nation->id,
            'name' => $this->request->name,
            'land' => 20,
        ]);

        $this->request->session()->flash('alert-success', ["{$this->request->name} has been created!"]);

        return redirect('/cities/');
    }

    /**
     * Buys land for a city.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function buyLand(int $id)
    {
        // Get the city
        $city = Cities::find($id);
        // Check if the user owns the city
        if (! $city->isOwner())
            abort(403);

        // TODO calculate the cost of land

        $this->validate($this->request, [
            'amount' => 'required',
        ]);

        $city->land += $this->request->amount;
        $city->save();

        $this->request->session()->flash('alert-success', ["You've bought {$this->request->amount} sq mi of land!"]);

        return redirect("/cities/view/$id");
    }

    /**
     * Sets up the job to construct a building for a city.
     *
     * @param Cities $cities
     * @param BuildingTypes $buildingtypes
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function buyBuilding(Cities $cities, BuildingTypes $buildingtypes)
    {
        // Check if they own the city
        if (! $cities->isOwner())
            abort(403);

        // Verify that the nation has the correct amount of money
        $resources = Auth::user()->nation->resources;
        if ($resources->money < $buildingtypes->baseCost)
        {
            $this->request->session()->flash('alert-danger', ["You don't have enough money to buy a $buildingtypes->name"]);

            return redirect("/cities/view/$cities->id");
        }

        // Now subtract the money from the nation
        $resources->money -= $buildingtypes->baseCost;
        Auth::user()->nation->resources()->save($resources);

        // Setup BuildingQueue
        $buildingQueue = new BuildingQueue();
        $buildingQueue->cityID = $cities->id;
        $buildingQueue->buildingID = $buildingtypes->id; // We'll save at the later
        $buildingQueue->save(); // Must do this here otherwise this will return a 404 lol

        // Determine if the request should be active or queued
        if ($cities->countActiveJobs() - 1 === 0) // If nothing is currently being built, dispatch the queue. We minus 1 because the current job just created is included in this count
            $buildingQueue->start(); // Instance of BuildingQueue gets saved in this method

        $this->request->session()->flash('alert-success', ["You've added a $buildingtypes->name to your queue"]);

        return redirect("/cities/view/$cities->id");
    }

    /**
     * Destroys a building.
     *
     * @param Cities $cities
     * @param BuildingTypes $buildingtypes
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sellBuilding(Cities $cities, BuildingTypes $buildingtypes)
    {
        // Check if they own the city
        if (! $cities->isOwner())
            abort(403);

        // TODO refund the user some amount of cash

        // Sell a building
        try
        {
            $building = Building::where([
                ['city_id', $cities->id],
                ['building_id', $buildingtypes->id],
            ])->firstOrFail();

            // if the building is the last one in the city, it will be caught here and the row deleted
            if ($building->quantity == 1)
            {
                $building->delete();
                $this->request->session()->flash('alert-success', ["You've sold a $buildingtypes->name!"]);
            }

            else
            {
                $building->quantity -= 1;
                $building->save();
                $this->request->session()->flash('alert-success', ["You've sold a $buildingtypes->name!"]);
            }
        }

        // If an exception is thrown, the row doesn't exist meaning the building does not exist in the city
        catch (\Exception $e)
        {
            $this->request->session()->flash('alert-danger', ["You don't have a $buildingtypes->name!"]);
        }

        return redirect("/cities/view/$cities->id");
    }

    /**
     * Will rename a city.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function renameCity(int $id)
    {
        // Get the city
        $city = Cities::find($id);
        // Check if the user owns the city
        if (! $city->isOwner())
            abort(403);

        $city->name = $this->request->name;
        $city->save();

        $this->request->session()->flash('alert-success', ["You've renamed this city!"]);

        return redirect("/cities/view/$id");
    }

    /**
     * Cancels a job.
     *
     * @param Cities $cities
     * @param BuildingQueue $buildingQueue
     * @return mixed
     */
    public function cancelJob(Cities $cities, BuildingQueue $buildingQueue)
    {
        // Verify that the owner is cancelling the job
        if (Auth::user()->nation->id != $buildingQueue->city->nation->id)
        {
            $this->request->session()->flash('alert-danger', ["You don't own that job!"]);

            return redirect("/cities/view/$cities->id");
        }

        $buildingQueue->cancel();
        $this->request->session()->flash('alert-success', ['That job has been cancelled']);

        return redirect("/cities/view/$cities->id");
    }
}
