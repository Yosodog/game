<?php

namespace App\Http\Controllers;

use App\Models\Nations;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Illuminate\View\View;

class NationController extends Controller
{
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
}
