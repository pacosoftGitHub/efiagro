<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    use HasFactory;
    protected $table = 'fincas';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'usuario_id' => 'integer',
        'departamento_id' => 'integer',
        'municipio_id' => 'integer',
        'zona_id' => 'integer'
    ]; 

    public function columns()
    { $usuarios = \App\Models\Usuario::all()->keyBy('id')->map(function($u){
        return $u['nombres'];
    })->toArray();
        $zonas = \App\Models\Zona::all()->keyBy('id')->map(function($z){
            return $z['descripcion'];
        })->toArray();
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['usuario_id',                     'Usuario',                       'select',   false,  false, null, 100, [ 'options' => $usuarios] ],
            ['nombre',                         'Finca',                         null,       true,   false, null, 100],
            ['direccion',                      'Dirección',                     null,       false,  false, null, 100],
            ['departamento_id',                'Departamento:',                 'select',   true,   false, null, 100, [ 'options' => [] ]],
            ['municipio_id',                   'Municipio:',                    'select',   true,   false, null, 100, [ 'options' => [] ]],
            ['area_total',                     'Área total',                    null,       false,  false, null, 100],
            ['tipo_cultivo',                   'Tipo de cultivo',               'select',   true,   false, null, 100, [ 'options' => [] ]],
            ['total_lotes',                    'Total Lotes',                   null,       false,  false, null, 100],
            ['tipo_suelo',                     'Tipo de suelo',                 'select',   false,   false, null, 100, [ 'options' => [] ]],
            ['zona_id',                        'Zona',                          'select',   false,  false, null, 100, [ 'options' => $zonas] ],
            ['latitud',                        'Latitud',                       null,       false,   false, null, 100],
            ['longitud',                       'Longitud',                      null,       false,   false, null, 100],
            ['hectareas',                      'Hectareas',                     null,       false,   false, null, 100],
            ['pendiente',                      'Pendiente',                     null,       false,   false, null, 100],
            ['sitios',                         'Sitios',                        null,       false,   false, null, 100],
            ['temperatura',                    'Temperatura (C°):',             null,       false,  false, null, 100],
            ['humedad_relativa',               'Humedad Relativa (%):',         null,       false,   false, null, 100],
            ['precipitacion',                  'Precipitacion (Mm):',           null,       false,   false, null, 100],
            ['altimetria',                     'Altimetria (Mt):',              null,       false,  false, null, 100],
            ['brillo_solar',                   'Brillo Solar (H):',             null,       false,   false, null, 100],
        ];

    }

    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

    public function scopeOrganizacion_id($q, $id)
    {
        return $q->where('organizacion_id', $id);
    }

    public function scopeOrganizacionUsuario($q, $id)
    {
        return $q->join("usuario_organizacion","fincas.usuario_id","=","usuario_organizacion.usuario_id")->where('usuario_organizacion.organizacion_id', $id);
    }

    public function scopeUsuario( $q, $usuario_id) {
        return $q->where('usuario_id', $usuario_id);
    }

    public function zonas()
    {
        return $this->belongsTo('App\Models\Zona', 'zona_id');
    }

    public function municipio()
    {
        return $this->belongsTo('App\Models\ListaDetalle', 'id');
    }
    
    public function usuarios()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    public function eventos()
    {
        return $this->hasMany('App\Models\FincaEvento','finca_id','id');
    }

    public function lotes()
    {
        return $this->hasMany('App\Models\Lote','finca_id','id');
    }
}
