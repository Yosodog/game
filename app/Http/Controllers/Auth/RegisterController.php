<?php

namespace App\Http\Controllers\Auth;

use App\Models\DevCodes;
use Validator;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/nation/view';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|unique:users,name|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'dev-code' => 'required|exists:dev_codes,code', // To make it easy, we'll later check if the code has already been used
        ], [
            'dev-code.exists' => 'That dev code is invalid. Please contact Yosodog if you would like to participate in the closed development'
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     * @throws \Exception
     */
    protected function create(array $data)
    {
        // Get the dev code here so we save a query
        $code = DevCodes::where("code", $data['dev-code'])->first();

        // To make it easy we're going to validate the dev code here
        if (! $this->validateDevCode($code)) // If it's already been used
        {
            header('Location: https://teletubbies.com/', true, '302');
            die(); // Always kill after a redirect
        }
        
        // Now that we're all good, mark the code as used
        $code->useCode($data['name']);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Validate if the dev code was used or not
     *
     * @param DevCodes $code
     * @return bool
     */
    protected function validateDevCode(DevCodes $code) : bool
    {
        // Now validate it
        if ($code->validateCode())
            return true;

        return false;
    }
}
