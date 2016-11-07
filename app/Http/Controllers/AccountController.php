<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class AccountController extends Controller
{
	/**
	 * Holds our request for easy use later
	 *
	 * @var Request
	 */
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function view()
	{
		// Get the currently authenticated user
		$user = Auth::user();
		return view("account.view", [
			"user" => $user,
		]);
	}

	public function editUsername()
	{
		// Verify that the username isn't taken
		$this->validate($this->request, [
			"username" => "required|unique:users,name|max:255"
		]);

		// Validations passes, update the username
		Auth::user()->name = $this->request->username;
		Auth::user()->save();

		return redirect("/account")->with("alert-success", ["Username changed successfully"]);
	}
}
