<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Confirmation360;
use App\Http\Repositories\EventosRepository;
use DateTime;

class EmailsController extends Controller
{
    private $eventosRepository;

    public function __construct(
        EventosRepository $eventosRepo
    ){
        $this->eventosRepository = $eventosRepo;
    }

    public function sendEmail(Request $request){
        Mail::to($request->email)->send(new Confirmation360());
    }
}
