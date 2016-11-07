<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class AccountController extends Controller
{
    public function view()
	{
		// Get the currently authenticated user
		$user = Auth::user();
		return view("account.view", [
			"user" => $user,
		]);
	}
}
