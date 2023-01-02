<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class Login extends Controller
{
    public function showLoginForm(Request $request)
    {
        // if (!$request->session()->has('url.intended')) {
        //     $targetPageTitle = url()->previous();
        //     $request->session()->put('url.intended', $targetPageTitle);
        // } else {
        //     $targetPageTitle = '';
        // }

        $targetPageTitle = $request->session()->pull('url.intended');
        // dump($targetPageTitle);

        $data = array(
            'targetPageTitle' => $targetPageTitle
        );

        return view('login', $data);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // if (!$request->session()->has('url.intended')) {
            //     // $targetPageTitle = url()->previous();
            //     // $request->session()->put('url.intended', $targetPageTitle);
            // } else {
            //     $targetPageTitle = '';
            // }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Request
     */
    public function authenticateWithValidation(Request $request)
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:3' // password has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::route('login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $credentials = array(
                'mail' => $request->input('email'),
                'password' => $request->input('password')
            );

            // remember me
            $remember = $request->input('remember', false);

            // attempt to do the login
            // if (Auth::attempt($credentials, $remember)) {
            if (Auth::guard('web')->attempt($credentials, $remember)) {

                // $user = Auth::guard('user')->attempt($credentials, $remember);
                // $admin = Auth::guard('admin')->attempt($credentials, $remember);

                $targetPageTitle = $request->session()->pull('url.intended');
                // dump($targetPageTitle);

                $request->session()->regenerate();
// dump($user);
// dump($admin);
// dd();

// $targetPageTitle = $request->session()->pull('url.intended');
// dd($targetPageTitle);


                $intendedPage = $request->input('targetPageTitle');

                // return redirect()->intended('/');
                return redirect()->intended($intendedPage);
            } else {

                // validation not successful, send back to form
                return Redirect::route('login')
                    ->withInput($request->except('password')); // send back the input (not the password) so that we can repopulate the form            }
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
    }

    public function cancel(Request $request)
    {
        return view('loginCancel');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return view('logout');
    }
}
