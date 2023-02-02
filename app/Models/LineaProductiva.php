<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineaProductiva extends Model
{ 
    use HasFactory, SoftDeletes;

    protected $table = 'lineas_productivas';
    protected $guarded = ['id'];
    protected $appends = [];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            [ 'nombre',          'Descripcion',    null, true,  false, null, 100 ],
            [ 'palabras_clave',  'Palabras Clave', null, false, false, null, 100 ],
        ];
    }

    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

    public function getPalabrasClaveAttribute($valor)
    {
        return explode(',', $valor);
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function($model){
            if(!is_string($model->attributes['palabras_clave']) AND !is_null($model->attributes['palabras_clave'])) 
                $model->attributes['palabras_clave'] = implode(',', $model->attributes['palabras_clave']);
        });
    }
    public function labores()
    {
        return $this->hasMany('App\Models\Labor', 'linea_productiva_id');
    }
}
