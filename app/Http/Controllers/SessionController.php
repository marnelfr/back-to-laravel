<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            session()->regenerate();
            if (auth()->user()->username === 'marnel') {
                return redirect()->route('dashboard')->with('success', 'Welcome back!');
            }
            return redirect('/')->with('success', 'Welcome back!');
        }

        throw ValidationException::withMessages([
            'email' => 'No way to log you in'
        ]);
    }

    public function destroy() {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successfully');
    }

}
