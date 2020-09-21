<?php namespace App\Http\Repositories;

use App\Http\Models\Palestrantes;
use Illuminate\Support\Str;

class PalestrantesRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['nm_palestrante'])) array_push($filtros, ['palestrantes.nm_palestrante', '=', $dados['nm_palestrante']]);
        if(isset($dados['fl_visivel'])) array_push($filtros, ['palestrantes.fl_visivel', '=', $dados['fl_visivel']]);
        if(isset($dados['fl_principal'])) array_push($filtros, ['palestrantes.fl_principal', '=', $dados['fl_principal']]);
        
        return Palestrantes::where($filtros);
    }

    public function show($id)
    {
        return Palestrantes::where('palestrantes.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_palestrante'])) $dados['slug_palestrante'] = Str::slug($dados['nm_palestrante'], '-');

        $palestrante = New Palestrantes($dados);
        $data = Array(
            'success' => $palestrante->save(),
            'data' => $palestrante
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_palestrante'])) $dados['slug_palestrante'] = Str::slug($dados['nm_palestrante'], '-');

        $palestrante = Palestrantes::where('id', $id)->first();
        $data = Array(
            'success' => $palestrante->update($dados),
            'data' => $palestrante
        );
        return $data;
    }

    public function delete($id)
    {
        $palestrante = Palestrantes::where('id', $id)->first();

        if($palestrante != null){
            return $palestrante->delete();
        }

        return false;
    }

}