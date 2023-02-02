<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteLabores extends Model
{
    use HasFactory;
    protected $table = 'lote_labores';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'lote_id' => 'integer',
        'labores_id' => 'integer'
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
            ['labores_id',   'Labores',     'select',   true,   false,  null, 50, ['options' => $labores] ],
            ['estado',       'Estado',      'select',   true,   false,  null, 100, [ 'options' => $estado ]], 
            ['lote_id',      'Lote',        'select',   true,   false,  null, 100, [ 'options' => $estado ]]
        ];

    }
    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }
    public function labor()
    {
        return $this->belongsTo('App\Models\Labor', 'labores_id');
    }
    public function lote()
    {
        return $this->belongsTo('App\Models\Lote', 'lote_id');
    }


}
