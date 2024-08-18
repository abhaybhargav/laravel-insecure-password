<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class UserController extends Controller
{
    private $users = [];
    private $secureMode;

    public function __construct()
    {
        $this->secureMode = Config::get('app.secure_mode', true);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $this->hashPassword($request->password),
        ];

        $this->users[] = $user;

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function listUsers()
    {
        return response()->json($this->users);
    }

    private function hashPassword($password)
    {
        if ($this->secureMode) {
            return Hash::make($password);
        } else {
            return sha1($password);
        }
    }
}