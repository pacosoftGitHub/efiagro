<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PerfilSeccion extends Model
{
    use HasFactory;

    protected $table = 'perfiles_secciones';
    protected $guarded = ['id'];
    protected $appends = [ ];
    protected $casts = [
        'perfil_id' => 'integer',
        'seccion_id' => 'integer'
         ];

    public function columns()
    { 
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['perfil_id',     'perfil_id',      null, true, false, null, 100],
            ['seccion_id',  'seccion_id',   null, true, false, null, 100],
            ['nivel',  'nivel',   null, true, false, null, 100],
        ];
        
    }

    public function scopePerfil($q, $perfil_id)
    {
    	return $q->where('perfil_id', $perfil_id);
    }

    public function scopeSeccion($q, $seccion_id)
    {
    	return $q->where('seccion_id', $seccion_id);
    }

}
