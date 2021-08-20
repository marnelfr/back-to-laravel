<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function create() {
        return view('session.create');
    }

    public function store() {
        $attributes = request()->validate([
            'email' => 'required|email',
            'password' => 'required|min:3'
        ]);

        if (auth()->attempt($attributes)) {
            return redirect('/')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'No way to get you logged'
        ])->withInput();
    }

    public function destroy() {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successfully');
    }

}
