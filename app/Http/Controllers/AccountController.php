<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Holds our request for easy use later.
     *
     * @var Request
     */
    protected $request;

    /**
     * AccountController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * GET: /account.
     *
     * Basically the page to edit your account. Maybe it should be /account/edit? lmao
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        return view('account.view', [
            'user' => $user,
        ]);
    }

    /**
     * PATCH: /account/edit/username.
     *
     * Edits a username
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUsername()
    {
        // Verify that the username isn't taken
        $this->validate($this->request, [
            'username' => 'required|unique:users,name|max:255',
        ]);

        // Validations passes, update the username
        Auth::user()->name = $this->request->username;
        Auth::user()->save();

        return redirect('/account')->with('alert-success', ['Username changed successfully']);
    }

    /**
     * PATCH: /account/edit/email.
     *
     * Edits a user's email address
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editEmail()
    {
        // Verify the email
        $this->validate($this->request, [
            'email' => 'required|email|unique:users,email|max:255',
        ]);

        // Validation is over, update the user
        Auth::user()->email = $this->request->email;
        Auth::user()->save();

        // TODO send email to old email address and new informing of change

        return redirect('/account')->with('alert-success', ['Email changed successfully']);
    }

    /**
     * PATCH: /account/edit/password.
     *
     * Updates a user's password
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPassword()
    {
        // Make sure the password given is correct
        if (! Hash::check($this->request->oldPass, Auth::user()->password)) // Passwords don't match, redirect with an error
            return redirect('/account')->with('alert-danger', ['That password is incorrect']);

        // Validate the request
        $this->validate($this->request, [
            'password' => 'required|min:6|confirmed',
        ]);

        // Validation passes, update their password
        Auth::user()->password = Hash::make($this->request->password);
        Auth::user()->save();

        return redirect('/account')->with('alert-success', ["You've changed your password"]);
    }

    /**
     * DELETE: /account/delete.
     *
     * Deletes the user account :(
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAccount()
    {
        // Make sure the password given is correct
        if (! Hash::check($this->request->password, Auth::user()->password)) // Passwords don't match, redirect with an error
            return redirect('/account')->with('alert-danger', ['That password is incorrect']);

        // Go through and delete everything associated with the account
        foreach (Auth::user()->nation->cities as $city)
        {
            // Delete the city's buildings
            foreach ($city->buildings as $building)
                $building->delete();

            // Delete all jobs for the city
            foreach ($city->jobs as $job)
                $job->delete();

            // Now actually delete the city
            $city->delete();
        }

        // Deletes all resources for the nation
        Auth::user()->nation->resources()->delete();
        // Delete the nation
        Auth::user()->nation()->delete();
        // Delete the account
        Auth::user()->delete();

        return redirect('/')->with('alert-info', ["You've deleted your account :("]);
    }
}
