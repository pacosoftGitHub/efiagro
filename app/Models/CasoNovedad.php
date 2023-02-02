<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasoNovedad extends Model
{
    use HasFactory;

    protected $table = 'casos_novedades';
    protected $guarded = ['id'];
    protected $casts = [
        'usuario_id' => 'integer',
        'caso_id' => 'integer'
         ]; 
    // protected $appends = ['novedad'];  // Crea conflicto para mostrar el campo NOVEDAD en la vista SOLICITUDES

    public function columns()
    { 
        //      Name,       Desc,       Type,   Required, Unique, Default, Width, Options
        return [
            [ 'usuario_id', 'usuario_id',   null,   true,  false, null, 11 ],
            [ 'caso_id',    'caso_id',      null,   true,  false, null, 11 ],
            [ 'tipo',  	    'tipo',         null,   false, false, null, 100 ],
            [ 'novedad',    'novedad',      null,   true,  false, null, 1000 ],
            [ 'solucion',   'solucion',     null,   true,  false, null, 10 ]
        ];
    }

    public function caso()
    {
    	return $this->belongsTo('App\Models\caso', 'caso_id', 'id');
    }

    public function scopeElcaso($q, $id_caso)
    {
    	return $q->where('caso_id', $id_caso);
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!is_string($model->attributes['novedad']) AND !is_null($model->attributes['novedad'])) 
                $model->attributes['novedad'] = json_encode($model->attributes['novedad']);
        });
    }

    public function getNovedadAttribute($novedad)
    {
        if($this->tipo == 'Tabla') return json_decode($novedad);
        return $novedad;
    }

    public function autor()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

    public function usuarios()
    {
        return $this->belongsTo('App\Models\Usuario', 'usuario_id');
    }

}
