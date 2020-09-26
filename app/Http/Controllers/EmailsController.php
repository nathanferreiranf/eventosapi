<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        Mail::to($email)->send(new ResetPassword($inscrito));
    }
}
