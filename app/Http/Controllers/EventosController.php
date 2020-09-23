<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\EventosRepository;
use DateTime;

class EventosController extends Controller
{
    private $eventosRepository;

    public function __construct(
        EventosRepository $eventosRepo
    ){
        $this->eventosRepository = $eventosRepo;
    }

    public function index(Request $request){
        $eventos = $this->eventosRepository->find($request->input())->paginate();

        return response()->json($eventos);
    }

    public function show($id){
        $evento = $this->eventosRepository->show($id);

        return response()->json($evento);
    }

    public function store(Request $request){
        $request->validate([
            'nm_evento' => 'required|unique:eventos|max:255',
        ]);

        $evento = $this->eventosRepository->create($request->input());

        return response()->json($evento);
    }

    public function update($id, Request $request){
        $evento = $this->eventosRepository->update($id, $request->input());

        return response()->json($evento);
    }
}
