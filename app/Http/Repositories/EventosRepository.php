<?php namespace App\Http\Repositories;

use App\Models\Eventos;
use Illuminate\Support\Str;

class EventosRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['nm_evento'])) array_push($filtros, ['eventos.nm_evento', '=', $dados['nm_evento']]);
        
        return Eventos::select(
            'eventos.*'
        )->where($filtros);
    }

    public function show($id)
    {
        return Eventos::select(
            'eventos.*'
        )->where('eventos.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_evento'])) $dados['slug_evento'] = Str::slug($dados['nm_evento'], '-');

        $evento = New Eventos($dados);
        $data = Array(
            'success' => $evento->save(),
            'data' => $evento
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_evento'])) $dados['slug_evento'] = Str::slug($dados['nm_evento'], '-');
        
        $evento = Eventos::where('id', $id)->first();
        $data = Array(
            'success' => $evento->update($dados),
            'data' => $evento
        );
        return $data;
    }

    public function delete($id)
    {
        $evento = Eventos::where('id', $id)->first();

        if($evento != null){
            return $evento->delete();
        }

        return false;
    }

}