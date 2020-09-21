<?php namespace App\Http\Repositories;

use App\Http\Models\InscritosCampos;
use Illuminate\Support\Str;

class InscritosCamposRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['id_user'])) array_push($filtros, ['inscritos_campos.id_user', '=', $dados['id_user']]);
        if(isset($dados['campo'])) array_push($filtros, ['inscritos_campos.campo', '=', $dados['campo']]);
        
        return InscritosCampos::where($filtros);
    }

    public function show($id)
    {
        return InscritosCampos::where('inscritos_campos.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();
        
        $campo = New InscritosCampos($dados);
        $data = Array(
            'success' => $campo->save(),
            'data' => $campo
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        $campo = InscritosCampos::where('id', $id)->first();
        $data = Array(
            'success' => $campo->update($dados),
            'data' => $campo
        );
        return $data;
    }

    public function delete($id)
    {
        $campo = InscritosCampos::where('id', $id)->first();

        if($campo != null){
            return $campo->delete();
        }

        return false;
    }

}