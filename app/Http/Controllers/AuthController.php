<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message'=>'E-mail e/ou senha inválidos.'], 401);
        }

        $user = auth()->user();

        //$accessToken = auth()->user()->createToken('authToken')->accessToken;
        $token = $user->createToken('authToken', ['server:update']);

        return response([
            'user' => $user,
            'access_token' => $token->plainTextToken
        ]);
    }
    
    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $validatedData['password'] = bcrypt($request->input('password'));
        
        $user = User::create($validatedData);

        //$accessToken = $user->createToken('authToken')->accessToken;
        $token = $user->createToken('authToken');

        return response([
            'user' => $user, 
            'access_token' => $token->plainTextToken
        ]);
    }
}