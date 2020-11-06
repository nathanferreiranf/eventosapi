<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Repositories\EventosRepository;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     */
    private $eventosRepository;

    public function __construct(
        EventosRepository $eventosRepo
    ){
        $this->eventosRepository = $eventosRepo;
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_evento' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('id_evento', 'email', 'password');

        if (!Auth::attempt($credentials)) {
            return response(['message'=>'E-mail e/ou senha inválidos.'], 401);
        }
        
        $user = User::where('id', auth()->user()->id)->first();
        $user->update([
            'ultimo_acesso' => date('Y-m-d H:i:s')
        ]);

        //$token = $user->createToken('authToken');

        return response([
            'user' => $user,
            //'access_token' => $token->plainTextToken
        ]);
    }
    
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'id_evento' => 'required',
            'name' => 'required|string',
            'email' => ['required', 'string', 'email', function ($attribute, $value, $fail) use ($request){
                $inscrito = User::where([
                    ['users.id_evento', '=', $request->id_evento],
                    ['users.email', '=', $value],
                ])->first();

                if ($inscrito != null) {
                    $fail('Este e-mail já está sendo utilizado.');
                }
            }],
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

    public function verifyLogin($id_user){
        $user = User::where('id', $id_user)->first();

        return response()->json(['ultimo_acesso' => $user->ultimo_acesso]);
    }

    public function verifyPasswordSet(Request $request){
        $validator = Validator::make($request->all(), [
            'id_evento' => ['required', function ($attribute, $value, $fail) use ($request){
                $evento = $this->eventosRepository->show($request->id_evento);

                if ($evento == null) {
                    $fail('Evento não encontrado.');
                }
            }],
            'email' => ['required', 'string', 'email', function ($attribute, $value, $fail) use ($request){
                $user = User::where([
                    ['id_evento', '=', $request->id_evento],
                    ['email', '=', $request->email]
                ])->first();

                if ($user == null) {
                    $fail('Usuário não cadastrado.');
                }
            }]
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where([
            ['id_evento', '=', $request->id_evento],
            ['email', '=', $request->email]
        ])->first();

        return response()->json(['user' => $user]);
    }

    public function setPassword($email, Request $request){
        $validator = Validator::make($request->all(), [
            'id_evento' => ['required', function ($attribute, $value, $fail) use ($request){
                $evento = $this->eventosRepository->show($request->id_evento);

                if ($evento == null) {
                    $fail('Evento não encontrado.');
                }
            }],
            'password' => 'required|string|min:8',
            'password_confirmation' => ['required', function ($attribute, $value, $fail) use ($request){
                if ($value != $request->password) {
                    $fail('O campo senha de confirmação não confere.');
                }
            }],
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = User::where([
            ['id_evento', '=', $request->id_evento],
            ['email', '=', $request->email]
        ])->first();

        if($user == null){
            return response()->json('Usuário não encontrado', 400);
        }

        $request->merge([
            'password' => Hash::make($request->input('password')),
            'fl_password_set' => 1
        ]);

        $data = Array(
            'success' => $user->update($request->input()),
            'user' => $user
        );

        return response()->json($data);
    }
}