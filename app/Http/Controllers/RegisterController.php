<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function create() {
        return view('register.create');
    }

    public function store() {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'password' => 'required|min:3',
            'email' => 'required|email|unique:App\Models\User'
        ]);
        User::create($attributes);
        return redirect('/')->with('success', 'Registration performs successfully!');
    }

}
