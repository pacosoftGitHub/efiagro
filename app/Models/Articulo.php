<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'linea_productiva_id' => 'integer',
        'usuario_id' => 'integer'
        //'objeto' => 'array'
    ];

    public function columns() 
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            [ 'titulo',                 'Titulo',          null,    true,  false, null,  100 ],
            [ 'linea_productiva_id',    'linea_prodecutiva_id',          null,    true,  false, null,  100 ],
            [ 'palabras_clave',         'Palabras Clave',  null,    false,  false, null, 100 ],
            [ 'estado',                 'Estado',          null,    true,  false, null,  100 ],
            [ 'usuario_id',             'usuario_id',      null,    true,  false, null,  100 ],
        ];
    }

    public function scopeActivos($q)
    {
    	return $q->where('estado', 'Activo');
    }

    public function scopeAccesibles($q)
    {
    	return $q;
    }

    public function secciones()
    {
    	return $this->hasMany('App\Models\ArticuloSeccion', 'articulo_id', 'id');
    }

    public function autor()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id', 'id');
    }

}
