<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opcion extends Model
{
    use HasFactory;

    protected $table = 'opciones';
    protected $guarded = ['id'];
    protected $appends = [];
    protected $casts = [
        'organizacion_id' => 'integer',
    ];

    public function columns()
    {
        //Name, Desc, Type, Required, Unique, Default, Width, Options
        return [
            ['organizacion_id', 'Organización', null, true, true, null, 100],
            ['opcion',          'Opción',       null, true, false, null, 100],
            ['tipo',            'Tipo',         null, true, false, null, 100],
            ['valor',           'Valor',        null, true, false, null, 100],
        ];
    }
}