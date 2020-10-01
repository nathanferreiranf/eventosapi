<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

        $token = $user->createToken('authToken');

        return response([
            'user' => $user,
            'access_token' => $token->plainTextToken
        ]);
    }
    
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'id_evento' => 'required',
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => ['required', function ($attribute, $value, $fail) use ($request){
                if ($value != $request->password) {
                    $fail('O campo senha de confirmação não confere.');
                }
            }],
            'google_recaptcha' => 'required'
        ],[
            'google_recaptcha.required' => 'Você precisa informar que não é um robô.'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $request->merge([
            'id' => Str::uuid()->toString(),
            'password' => Hash::make($request->input('password'))
        ]);

        $user = User::create($request->input());

        $token = $user->createToken('authToken');

        return response()->json([
            'user' => $user, 
            'access_token' => $token->plainTextToken
        ]);
    }
}