<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{ 
    use HasFactory;
    
    protected $table = 'perfiles';
    protected $guarded = ['id'];
    protected $appends = [];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['perfil', 'Perfil', null, true, false, null, 100],
        ];
        
    }

    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

    public function scopeSecciones($q, $id)
    {
        return $q->leftJoin('perfiles_secciones', 'id', '=', 'seccion_id');
    }
}
