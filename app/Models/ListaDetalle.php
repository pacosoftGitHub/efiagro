<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaDetalle extends Model
{ 
    use HasFactory;
    //use SoftDeletes;

    protected $table = 'listas_detalle';
    protected $guarded = ['id'];
    protected $appends = [];
}