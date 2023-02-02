<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizacion extends Model
{
    use HasFactory;
    
    protected $table = 'organizaciones';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'linea_productiva_id' => 'integer',
    ];

    public function columns()
    {
        $lineasproductivas= \App\Models\LineaProductiva::all()->keyBy('id')->map( function($lp){
            return $lp['nombre'];
        })->toArray();
        // $departamento = [
        // ];
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['nombre',                      'Nombre:',                       null, true,         false, null, 100],
            ['nit',                         'Nit:',                          null, true,         false, null, 100],
            ['sigla',                       'Sigla:',                        null, false,        false, null, 100],
            ['linea_productiva_id', 'Linea Productiva', 'select',   true,   false,  null, 50, ['options' => $lineasproductivas] ],
            ['latitud',                     'Latitud:',                      null, false,        false, null, 100],
            ['longitud',                    'Longitud:',                     null, false,        false, null, 100],
            ['direccion',                   'Dirección:',                    null, true,         false, null, 100],
            ['departamento',                'Departamento:',                 'select', true,         false, null, 100, [ 'options' => [] ]],
            ['municipio',                   'Municipio:',                    'select', true,         false, null, 100, [ 'options' => [] ]],
            ['telefono',                    'Teléfono:',                     null, true,         false, null, 100],
            ['correo',                      'Correo:',                       'email', true,      false, null, 100],
            ['total_asociados',             'Asociados:',                    'integer', true,    false, null, 100],
            ['fecha_constitucion',          'Fecha Constitución:',           'date', false,       false, null, 100],
            ['nombre_rl',                   'Representante Legal:',          null, false,      false, null, 100],
            ['documento_rl',                'Documento Rep. Legal:',          null, false,      false, null, 100],
        ];
    }

    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

    public function linea_productiva()
    {
        return $this->belongsTo('App\Models\LineaProductiva', 'linea_productiva_id');
    }
    
    public function departamento()
    {
        return $this->hasMany('App\Models\Departamento', 'id_departamento', 'id');
    }

    public function promedioproduccion()
    {
        return $this->hasOne('App\Models\Infpromedioproduccion', 'organizacion_id', 'id')->row();
    }

}
