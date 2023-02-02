<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    protected $table = 'eventos';
    protected $guarded = ['id'];
    protected $appends = [];
    
    public function columns()
    { 
    
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
           
            ['evento',         'Evento',      null,       true,     false,  null,       100],
            
        ];

    }
    public function scopeId($q, $id)
    {
        return $q->where('id', $id);
    }

   
}

