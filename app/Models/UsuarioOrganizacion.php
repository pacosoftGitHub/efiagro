<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioOrganizacion extends Model
{
    use HasFactory;
    protected $table = 'usuario_organizacion';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'usuario_id'      => 'integer',
        'organizacion_id' => 'integer'
    ];
    
    public function columns()
    {
        $usuarios = \App\Models\Usuario::all()->keyBy('id')->map( function($u){
            return $u['nombres'] . ' ' . $u['apellidos'];
        })->toArray();

        $organizaciones = \App\Models\Organizacion::all()->keyBy('id')->map( function($o){
            return $o['nombre'];
        })->toArray();

        //  Name,               Desc,           Type,       Required, Unique, Default, Width, Options
        return [
            ['usuario_id',      'Usuario',      'select',   true,   false,  null, 50, ['options' => $usuarios] ],
            ['organizacion_id', 'Organizacion', 'select',   true,   false,  null, 50, ['options' => $organizaciones] ],
        ];

    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    public function organizaciones()
    {
        return $this->belongsTo('App\Models\Organizacion', 'organizacion_id');
    }
}
