<?php

namespace App\Http\Controllers;

use App\Http\Services\HttpResponseService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
        ]);
        return HttpResponseService::success('register ok', $user);
    }

    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = $req->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            $resp = response()->json([
                'acces_token' => $token,
                'token_type' => 'Bearer'
            ]);
            return HttpResponseService::success('login ok', $resp->original);
        };
        return HttpResponseService::unauthorized('unauthorized');
    }

    public function logout(Request $req)
    {
        Auth::logout();
        return HttpResponseService::success('logout ok', []);
    }
}
