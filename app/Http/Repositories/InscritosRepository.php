<?php namespace App\Http\Repositories;

use App\User;
use Illuminate\Support\Str;

class InscritosRepository {

    public function find($dados = null){
        $filtros = [];
        
        if(isset($dados['name'])) array_push($filtros, ['users.name', '=', $dados['name']]);
        if(isset($dados['email'])) array_push($filtros, ['users.email', '=', $dados['email']]);
        if(isset($dados['dia'])) array_push($filtros, ['users.created_at', 'like', $dados['dia'].'%']);
        
        return User::select('users.*')
        ->selectRaw('date_format(users.created_at, "%d/%m/%Y %H:%i") as dt_inscricao')
        ->where($filtros);
    }

    public function show($id)
    {
        return User::where('users.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();

        $inscrito = New User($dados);
        $data = Array(
            'success' => $inscrito->save(),
            'data' => $inscrito
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        $inscrito = User::where('id', $id)->first();
        $data = Array(
            'success' => $inscrito->update($dados),
            'data' => $inscrito
        );
        return $data;
    }

    public function delete($id)
    {
        $inscrito = User::where('id', $id)->first();

        if($inscrito != null){
            return $inscrito->delete();
        }

        return false;
    }

}