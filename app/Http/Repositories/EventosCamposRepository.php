<?php namespace App\Http\Repositories;

use App\Http\Models\EventosCampos;
use Illuminate\Support\Str;

class EventosCamposRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['id_evento'])) array_push($filtros, ['eventos_campos.id_evento', '=', $dados['id_evento']]);
        if(isset($dados['nm_campo'])) array_push($filtros, ['eventos_campos.nm_campo', '=', $dados['nm_campo']]);
        
        return EventosCampos::where($filtros);
    }

    public function show($id)
    {
        return EventosCampos::where('eventos_campos.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_campo'])) $dados['slug_campo'] = Str::slug($dados['nm_campo'], '_');

        $campo = New EventosCampos($dados);
        $data = Array(
            'success' => $campo->save(),
            'data' => $campo
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_campo'])) $dados['slug_campo'] = Str::slug($dados['nm_campo'], '_');
        
        $campo = EventosCampos::where('id', $id)->first();
        $data = Array(
            'success' => $campo->update($dados),
            'data' => $campo
        );
        return $data;
    }

    public function delete($id)
    {
        $campo = EventosCampos::where('id', $id)->first();

        if($campo != null){
            return $campo->delete();
        }

        return false;
    }

}