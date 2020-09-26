<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventos extends Model
{
    use SoftDeletes;
    
    protected $table = 'eventos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nm_evento',
        'slug_evento',
        'url',
        'logo'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $incrementing = false;
}
