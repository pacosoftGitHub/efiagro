<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;
    protected $table = 'departamentos';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        
        'id_departamento' => 'integer'
         ]; 
    

    public function columns()
    { 
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['id_departamento',             'ID',                       null, true,         false, null, 100],
            ['departamento',                'Departamento',             null, true,         false, null, 100],
                     
        ];
        
    }
    public function organizacion()
    {
    	return $this->belongsTo('App\Models\Organizacion', 'id_departamento', 'id');
    }
}
