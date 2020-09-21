<?php namespace App\Http\Repositories;

use App\Http\Models\Salas;
use Illuminate\Support\Str;

class SalasRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['nm_sala'])) array_push($filtros, ['salas.nm_sala', '=', $dados['nm_sala']]);
        if(isset($dados['slug_sala'])) array_push($filtros, ['salas.slug_sala', '=', $dados['slug_sala']]);
        if(isset($dados['fl_visivel'])) array_push($filtros, ['salas.fl_visivel', '=', $dados['fl_visivel']]);
        
        return Salas::select('salas.*')
        ->selectRaw('date_format(salas.dt_inicio, "%H:%i") as hora_inicio')
        ->selectRaw('date_format(salas.dt_fim, "%H:%i") as hora_fim')
        ->selectRaw('date_format(salas.dt_inicio, "%d/%m/%Y %H:%i") as dt_inicio_format')
        ->selectRaw('date_format(salas.dt_fim, "%d/%m/%Y %H:%i") as dt_fim_format')
        ->where($filtros);
    }

    public function show($id)
    {
        return Salas::select('salas.*')
        ->selectRaw('date_format(salas.dt_inicio, "%H:%i") as hora_inicio')
        ->selectRaw('date_format(salas.dt_fim, "%H:%i") as hora_fim')
        ->selectRaw('date_format(salas.dt_inicio, "%d/%m/%Y %H:%i") as dt_inicio_format')
        ->selectRaw('date_format(salas.dt_fim, "%d/%m/%Y %H:%i") as dt_fim_format')
        ->where('salas.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_sala'])) $dados['slug_sala'] = Str::slug($dados['nm_sala'], '-');

        $sala = New Salas($dados);
        $data = Array(
            'success' => $sala->save(),
            'data' => $sala
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_sala'])) $dados['slug_sala'] = Str::slug($dados['nm_sala'], '-');

        $sala = Salas::where('id', $id)->first();

        $data = Array(
            'success' => $sala->update($dados),
            'data' => $sala
        );

        return $data;
    }

    public function delete($id)
    {
        $sala = Salas::where('id', $id)->first();

        if($sala != null){
            return $sala->delete();
        }

        return false;
    }

}