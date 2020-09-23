<?php namespace App\Http\Repositories;

use App\Http\Models\SalasVisitas;
use Illuminate\Support\Str;

class SalasVisitasRepository {

    public function find($dados = null){
        $filtros = [];
        $termos = [];
        
        if(isset($dados['id_sala'])) array_push($filtros, ['salas_visitas.id_sala', '=', $dados['id_sala']]);
        if(isset($dados['name'])) array_push($filtros, ['salas_visitas.name', '=', $dados['name']]);
        if(isset($dados['email'])) array_push($filtros, ['users.email', '=', $dados['email']]);
        if(isset($dados['dia'])) array_push($filtros, ['salas_visitas.created_at', 'like', $dados['dia'].'%']);

        if(isset($dados['search'])){
            array_push($termos, ['users.name', 'like', '%'.$dados['search'].'%']);
            array_push($termos, ['users.email', 'like', '%'.$dados['search'].'%']);
        }
        
        return SalasVisitas::join('users', 'salas_visitas.id_user', '=', 'users.id')
        ->join('salas', 'salas_visitas.id_sala', '=', 'salas.id')
        ->select(
            'salas_visitas.*',
            'users.name as nm_visitante',
            'users.email',
            'salas.nm_sala',
            'salas.slug_sala'
        )->where(function ($query) use ($termos){
            foreach($termos as $filtro){
                $query->orWhere($filtro[0], $filtro[1], $filtro[2]);
            }
            return $query;
        })->where($filtros);
    }

    public function show($id){
        return SalasVisitas::join('users', 'salas_visitas.id_user', '=', 'users.id')
        ->join('salas', 'salas_visitas.id_sala', '=', 'salas.id')
        ->select(
            'salas_visitas.*',
            'users.name as nm_visitante',
            'users.email',
            'salas.nm_sala',
            'salas.slug_sala'
        )->where('salas_visitas.id', $id)->first();
    }

    public function create($dados)
    {   
        $dados['id'] = Str::uuid();

        $inscrito = New SalasVisitas($dados);
        $data = Array(
            'success' => $inscrito->save(),
            'data' => $inscrito
        );
        return $data;
    }

    public function update($id, $dados)
    {   
        $inscrito = SalasVisitas::where('id', $id)->first();
        $data = Array(
            'success' => $inscrito->update($dados),
            'data' => $inscrito
        );
        return $data;
    }

    public function delete($id)
    {
        $inscrito = SalasVisitas::where('id', $id)->first();

        if($inscrito != null){
            return $inscrito->delete();
        }

        return false;
    }

}