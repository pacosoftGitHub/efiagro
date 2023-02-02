<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Functions\CRUD;
use App\Models\FichasTecnicasComerciales;
use App\Functions\Helper;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class FichasTecnicasComercialesController extends Controller
{
   

    public function fichasOrganizacion(Request $request){
        $ficha[0] = array(
            "Producto" => "Prueba del Producto",
            "Calidad" => "Primeras",
            "Precio" => "2000000"
        );
        
        return json_encode($ficha);
    }
}
