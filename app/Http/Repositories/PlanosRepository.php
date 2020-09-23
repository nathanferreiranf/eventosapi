<?php namespace App\Http\Repositories;

use App\Http\Models\Planos;
use Illuminate\Support\Str;

class PlanosRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['nm_plano'])) array_push($filtros, ['planos.nm_plano', '=', $dados['nm_plano']]);
        
        return Planos::select('planos.*')
        ->selectRaw('date_format(planos.dt_validade, "%d/%m/%Y %H:%i") as dt_validade_format')
        ->selectRaw('date_format(planos.dt_validade, "%H:%i") as hora_validade')
        ->where($filtros);
    }

    public function show($id)
    {
        return Planos::select('planos.*')
        ->selectRaw('date_format(planos.dt_validade, "%d/%m/%Y %H:%i") as dt_validade_format')
        ->selectRaw('date_format(planos.dt_validade, "%H:%i") as hora_validade')
        ->where('planos.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_plano'])) $dados['slug_plano'] = Str::slug($dados['nm_plano'], '-');

        $plano = New Planos($dados);
        $data = Array(
            'success' => $plano->save(),
            'data' => $plano
        );
        
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_plano'])) $dados['slug_plano'] = Str::slug($dados['nm_plano'], '-');

        $plano = Planos::where('id', $id)->first();
        $data = Array(
            'success' => $plano->update($dados),
            'data' => $plano
        );

        return $data;
    }

    public function delete($id)
    {
        $plano = Planos::where('id', $id)->first();

        if($plano != null){
            return $plano->delete();
        }

        return false;
    }

}