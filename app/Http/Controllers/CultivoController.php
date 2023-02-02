<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\Cultivo;

class CultivoController extends Controller
{
    public function postCultivos()
    {
        $CRUD = new CRUD('App\Models\Cultivo');
       return $CRUD->call(request()->fn, request()->ops);
    }

    public function postObtener()
   {
       $Cultivo = Cultivo::All();
       return $Cultivo;
   } 
}
