<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';
    protected $guarded = ['id'];
    protected $appends = [ 'seccion_slug', 'subseccion_slug' ];

    public function columns()
    { 
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['seccion',     'Seccion',      null, true, false, null, 100],
            ['subseccion',  'Subseccion',   null, true, false, null, 100],
            ['navegacion',  'navegacion',   null, true, false, null, 100],
        ];
        
    }

    public function obtenerSlug($string)
    {
        $string = Str::studly($string);
        $string = str_replace(['á','é','í','ó','u'], ['a','e','i','o','u'], $string);
        return $string;
    }

    public function getSeccionSlugAttribute()
    {
    	return $this->obtenerSlug($this->seccion);
    }

    public function getSubseccionSlugAttribute()
    {
        return $this->obtenerSlug($this->subseccion);
    }

}
