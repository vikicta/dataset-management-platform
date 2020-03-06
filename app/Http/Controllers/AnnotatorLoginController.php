<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnotatorLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:annotator')->except('logout');
    }

    /**
     * Show admin login form
     *
     * @return view
     */
    public function login()
    {
        return view('annotator.login');
    }

    /**
     * Login admin process
     *
     * @param Request $request
     * @return route with toast function
     */
    public function loginPost(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;

        // Sync user post with annotator table in database
        // If annotator is exist then annotator set in session
        if(Auth::guard('annotator')->attempt(['username' => $username, 'password' => $password], null)) {
            return redirect()->intended(route('annotator.index'));
        }

        toast('Username and Password not valid','error'); // Show pop-up notification

        return redirect()->back()->withInput($request->all());
    }

    /**
     * Logout admin process
     *
     * @return route
     */
    public function logout()
    {
        Auth::guard('annotator')->logout();
        return redirect('/');
    }
}
