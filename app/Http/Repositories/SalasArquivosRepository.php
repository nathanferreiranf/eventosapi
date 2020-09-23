<?php namespace App\Http\Repositories;

use App\Http\Models\SalasArquivos;
use Illuminate\Support\Str;

class SalasArquivosRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['id_sala'])) array_push($filtros, ['salas_arquivos.id_sala', '=', $dados['id_sala']]);
        
        return SalasArquivos::join('salas', 'salas_arquivos.id_sala', '=', 'salas.id')
        ->select(
            'salas_arquivos.*',
            'salas.nm_sala',
            'salas.slug_sala'
        )->where($filtros);
    }

    public function show($id){
        return SalasArquivos::join('salas', 'salas_arquivos.id_sala', '=', 'salas.id')
        ->select(
            'salas_arquivos.*',
            'salas.nm_sala',
            'salas.slug_sala'
        )->where('salas_arquivos.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();

        $arquivo = New SalasArquivos($dados);
        $data = Array(
            'success' => $arquivo->save(),
            'data' => $arquivo
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        $arquivo = SalasArquivos::where('id', $id)->first();
        $data = Array(
            'success' => $arquivo->update($dados),
            'data' => $arquivo
        );
        return $data;
    }

    public function delete($id){
        $arquivo = SalasArquivos::where('id', $id)->first();

        if($arquivo != null){
            return $arquivo->delete();
        }

        return false;
    }

}