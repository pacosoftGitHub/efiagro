<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;
    protected $table = 'zonas';
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
        //Name, Desc, Type, Required, Unique, Default, Width, Options linea_productiva_id
        return [
            ['descripcion',             'Descripcion:',                                     null, true,     false, null, 100],
            ['linea_productiva_id',     'Linea Productiva', 'select',                       true,   false,  null, 50, ['options' => $lineasproductivas] ],
            ['temperatura_min',         'Temperatura Min (C°):',                            null, false,    false, null, 100],
            ['temperatura_max',         'Temperatura Max (C°):',                            null, false,    false, null, 100],
            ['humedad_relativa_min',    'Humedad Relativa Min (%):',                        null, true,     false, null, 100],
            ['humedad_relativa_max',    'Humedad Relativa Max (%):',                        null, true,     false, null, 100],
            ['precipitacion_min',       'Precipitacion Min (Mm):',                          null, true,     false, null, 100],
            ['precipitacion_max',       'Precipitacion Max (Mm):',                          null, true,     false, null, 100],
            ['altimetria_min',          'Altimetria Minima (Mt):',                          null, false,    false, null, 100],
            ['altimetria_max',          'Altimetria Maxima (Mt):',                          null, true,     false, null, 100],
            ['brillo_solar_min',        'Brillo Solar Min (H):',                            null, true,     false, null, 100],
            ['brillo_solar_max',        'Brillo Solar Max (H):',                            null, true,     false, null, 100],
            ['pendiente_min',           'Pendiente Min (m):',                               null, true,     false, null, 100],
            ['pendiente_max',           'Pendiente Max (m):',                               null, true,     false, null, 100],

        ];
    }
    public function linea_productiva()
    {
        return $this->belongsTo('App\Models\LineaProductiva', 'linea_productiva_id');
    }
    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

    public function labores()
    {
        return $this->hasMany('App\Models\Labor', 'zona_id');
    }

}
