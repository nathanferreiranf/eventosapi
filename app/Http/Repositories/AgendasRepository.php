<?php namespace App\Http\Repositories;

use App\Http\Models\Agendas;
use Illuminate\Support\Str;

class AgendasRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['nm_agenda'])) array_push($filtros, ['agendas.nm_agenda', '=', $dados['nm_agenda']]);
        
        return Agendas::select('agendas.*')
        ->selectRaw('date_format(agendas.dt_inicio, "%d/%m/%Y %H:%i") as dt_inicio_format')
        ->selectRaw('date_format(agendas.dt_inicio, "%H:%i") as hora_inicio')
        ->where($filtros);
    }

    public function show($id)
    {
        return Agendas::select('agendas.*')
        ->selectRaw('date_format(agendas.dt_inicio, "%d/%m/%Y %H:%i") as dt_inicio_format')
        ->selectRaw('date_format(agendas.dt_inicio, "%H:%i") as hora_inicio')
        ->where('agendas.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();

        if(isset($dados['nm_agenda'])) $dados['slug_agenda'] = Str::slug($dados['nm_agenda'], '-');
        
        $agenda = New Agendas($dados);
        $data = Array(
            'success' => $agenda->save(),
            'data' => $agenda
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        $agenda = Agendas::where('id', $id)->first();

        if(isset($dados['nm_agenda'])) $dados['slug_agenda'] = Str::slug($dados['nm_agenda'], '-');

        $data = Array(
            'success' => $agenda->update($dados),
            'data' => $agenda
        );
        return $data;
    }

    public function delete($id)
    {
        $agenda = Agendas::where('id', $id)->first();

        if($agenda != null){
            return $agenda->delete();
        }

        return false;
    }

}