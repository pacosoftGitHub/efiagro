<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labor extends Model
{
    use HasFactory;

    protected $table = 'labores';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'zona_id' => 'integer',
        'linea_productiva_id' => 'integer'
         ];



    public function columns()
    { 
        $zonas = \App\Models\Zona::all()->keyBy('id')->map(function($z){
            return $z['descripcion'];
        })->toArray();
        $linea_productiva = \App\Models\LineaProductiva::all()->keyBy('id')->map(function($lp){
            return $lp['nombre'];
        })->toArray();
        // dd($zonas);
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['labor',               'Labor:',                                          null, true, false, null, 100],
            ['zona_id',             'Zona:',                                            'select', false, false, null, 255, [ 'options' => $zonas] ],
            ['linea_productiva_id', 'Linea productiva:',                               'select', false, false, null, 255, [ 'options' => $linea_productiva] ],
            ['frecuencia',          'Frecuencia:',                                      null, true, false, null, 100],
            ['inicio',       'Semana de inicio:',                                       null, false, false, null, 100],
            ['margen',              'Margen:',                                          null, false, false, null, 100],   
        ];
    }

    public function scopeLazona($q, $zona_id){
       return $q->where('zona_id', $zona_id);
    }

    public function scopeLalineaproductiva($q, $linea_productiva_id){
        return $q->where('linea_productiva_id', $linea_productiva_id);
     }

    public function linea_productiva()
    {
        return $this->belongsTo('App\Models\LineaProductiva',  'linea_productiva_id');
    }
    public function zona()
    {
        return $this->belongsTo('App\Models\Zona',  'zona_id');
    }
}
