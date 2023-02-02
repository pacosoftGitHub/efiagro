<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lista extends Model
{ 
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'listas_indice';
    protected $guarded = ['id'];
    protected $appends = [];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['lista',            'lista',                   null, true, true, null, 100],
            ['autoincremental',  'autoincremental',     'bool', true, false, null, 100],
        ];
    }

    public function listadetalle (){
        return $this-> hasMany (ListaDetalle::class); //obtengo lista detalle
    }
}