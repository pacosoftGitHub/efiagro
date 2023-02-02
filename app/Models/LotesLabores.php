<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotesLabores extends Model
{
    use HasFactory;
    protected $table = 'lotes_labores';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'lote_id' => 'integer',
        'labor_id' => 'integer',
        'inicio' => 'integer',
        'frecuencia' => 'integer',
        'margen' => 'integer',

         ];
    
    public function columns()
    {
        $estado = [
            'Fincalizado' => 'Finalizado', 'Pendiente' => 'Pendiente', 'Asignado' => 'Asignado'
        ];
        
    
        $labores = \App\Models\Labor::all()->keyBy('id')->map( function($lb){
            return $lb['labor'];
        })->toArray();
        $lotes = \App\Models\Lote::all()->keyBy('id')->map( function($l){
            return $l['id'];
        })->toArray();
        

        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['lote_id',         'Lotes',             'select',   true,   false,  null, 50, ['options' => $lotes] ],
            ['labor_id',        'Labores',           'select',   true,   false,  null, 50, ['options' => $labores] ],
            ['inicio',          'Inicio',            'select',   true,   false,  null, 100, [ 'options' => $estado ]], 
            ['frecuencia',      'Frecuencia',        'select',   true,   false,  null, 100, [ 'options' => $estado ]], 
            ['margen',          'Margen',            'select',   true,   false,  null, 100, [ 'options' => $estado ]]  
        ];

    }
    public function scopeId($q, $id) {
        return $q->where('id', $id);
    }

    public function labor() {
        return $this->belongsTo('App\Models\Labor', 'labor_id');
    }

    public function lote() {
        return $this->belongsTo('App\Models\Lote', 'lote_id');
    }
}
