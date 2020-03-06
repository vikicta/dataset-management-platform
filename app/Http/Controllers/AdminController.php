<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // allowed access functions just guest except logout and index function
        // not allowed for annotator guest
        $this->middleware('guest:annotator')->except(['logout', 'index']);
    }

    /**
     * Show dashboard admin or annotator view
     *
     * @return view
     */
    public function index()
    {
        Auth::check() ? $name = Auth::user()->name : $name = Auth::guard('annotator')->user()->name;

        return view('home', compact('name'));
    }

    /**
     * Show admin login form
     *
     * @return view
     */
    public function login()
    {
        return view('admin.login');
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

        // Sync user post with admin table in database
        // If admin is exist then admin set in session
        if(Auth::attempt(['username' => $username, 'password' => $password])) {
            return redirect()->route('admin.home');
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
        Auth::logout();

        return redirect('/');
    }
}
