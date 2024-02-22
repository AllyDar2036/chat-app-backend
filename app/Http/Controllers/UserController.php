<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with(['senderChats', 'receiverChats'])->get();

        return response()->json(['users' => $users, 201]);
    }

    public function getUser($id) 
    {
        $user = User::with(['senderChats', 'receiverChats'])->where('id',$id)->first();
        return response()->json($user);
    }
    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return response()->json(['user' => $user, 'message' => 'User created successfully'], 201);
    }

    /**
     * Authenticate user and return token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json(['user' => $user, 'token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}
