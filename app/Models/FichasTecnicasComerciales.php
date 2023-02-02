<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichasTecnicasComerciales extends Model
{
    use HasFactory;
    
    protected $table = 'fichas_tecnicas_comerciales';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'id_linea_productiva' => 'integer',
    ];

}
