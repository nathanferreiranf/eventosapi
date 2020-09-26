<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\Confirmation;
use App\Mail\ResetPassword;
use App\Http\Repositories\EventosRepository;
use App\Http\Repositories\InscritosRepository;
use DateTime;

class EmailsController extends Controller
{
    private $eventosRepository;
    private $inscritosRepository;

    public function __construct(
        EventosRepository $eventosRepo,
        InscritosRepository $inscritosRepo
    ){
        $this->eventosRepository = $eventosRepo;
        $this->inscritosRepository = $inscritosRepo;
    }

    public function sendConfirmation(Request $request){
        Mail::to($request->email)->send(new Confirmation());
    }

    public function sendResetPassword($email, Request $request){
        $inscrito = $this->inscritosRepository->find([
            'email' => $email
        ])->first();

        if($inscrito == null){
            return response()->json(['email' => [
                'E-mail não encontrado.'
            ]], 400);
        }

        Mail::to($email)->send(new ResetPassword($inscrito));

        if (Mail::failures()) {
            return response()->json('Houve um erro ao enviar o link. Tente novamente', 400);
        }

        return response()->json('Link enviado com sucesso. Verifique sua caixa de entrada.');
    }

    public function resetPassword($id_user, Request $request){
        $inscrito = $this->inscritosRepository->update($id_user, [
            'password' => Hash::make($request->password)
        ]);

        if(!$inscrito['success']){
            return response()->json('Houve um erro ao alterar a senha.', 400);
        }

        Auth::loginUsingId($id_user);

        $user = Auth::user();

        $token = $user->createToken('authToken');

        return response([
            'user' => $user,
            'access_token' => $token->plainTextToken
        ]);
    }
}
