<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FincaEvento extends Model
{
    use HasFactory;
    protected $table = 'finca_eventos';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'finca_id' => 'integer',
        'evento_id' => 'integer'
         ];
    
    public function columns()
    {
        $gravedad = [
            'Alta' => 'Alta', 'Media' => 'Media', 'Baja' => 'Baja'
        ]; 
        
    
        $fincas = \App\Models\Finca::all()->keyBy('id')->map( function($f){
            return $f['nombre'];
        })->toArray();
        $eventos = \App\Models\Evento::all()->keyBy('id')->map( function($e){
            return $e['evento'];
        })->toArray();

        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
           
            ['finca_id',            'Finca',                'select',   true,   false,  null, 50, ['options' => $fincas] ],
            ['evento_id',           'Selecionar Evento',    'select',   true,   false,  null, 50, ['options' => $eventos] ],
            ['fecha',               'Fecha',                'date',     false,   false,  null, 100],
            ['observacion',         'Observacion',           null,      false,   false,  null, 100],
            ['gravedad',            'Gravedad',             'select',   false,   false,  null, 100, [ 'options' => $gravedad ]],   
        ];

    }
    public function finca()
    {
        return $this->belongsTo('App\Models\Finca', 'finca_id');
    }
    public function evento()
    {
        return $this->belongsTo('App\Models\Evento', 'evento_id');
    }


   
}

