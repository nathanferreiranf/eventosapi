<?php namespace App\Http\Repositories;

use App\Http\Models\Patrocinadores;
use Illuminate\Support\Str;

class PatrocinadoresRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['id_evento'])) array_push($filtros, ['patrocinadores.id_evento', '=', $dados['id_evento']]);
        if(isset($dados['fl_visivel'])) array_push($filtros, ['patrocinadores.fl_visivel', '=', $dados['fl_visivel']]);
        
        return Patrocinadores::where($filtros);
    }

    public function show($id)
    {
        return Patrocinadores::where('patrocinadores.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        if(isset($dados['nm_patrocinador'])) $dados['slug_patrocinador'] = Str::slug($dados['nm_patrocinador'], '-');

        $patrocinadores = New Patrocinadores($dados);
        $data = Array(
            'success' => $patrocinadores->save(),
            'data' => $patrocinadores
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        if(isset($dados['nm_patrocinador'])) $dados['slug_patrocinadores'] = Str::slug($dados['nm_patrocinador'], '-');

        $patrocinadores = Patrocinadores::where('id', $id)->first();
        $data = Array(
            'success' => $patrocinadores->update($dados),
            'data' => $patrocinadores
        );
        return $data;
    }

    public function delete($id)
    {
        $patrocinadores = Patrocinadores::where('id', $id)->first();

        if($patrocinadores != null){
            return $patrocinadores->delete();
        }

        return false;
    }

}