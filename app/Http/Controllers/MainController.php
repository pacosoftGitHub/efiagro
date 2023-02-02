<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Seccion;
use App\Models\PerfilSeccion;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\EstadisticasExportar;

use Image;
use File;
//use Excel;
use Input;
use App\Functions\Helper;

class MainController extends Controller
{
    public function postObtenerSecciones()
    {
        $usuario = Helper::getUsuario();

    	$SeccionesPerfil = PerfilSeccion::where('perfil_id', $usuario->perfil_id)
            ->whereIn('nivel', array(10, 20, 30, 40, 50))
            ->get();
        
    	$Secciones = Seccion::whereIn('id', $SeccionesPerfil->pluck('seccion_id'))
            ->get()
            ->groupBy('seccion_slug');
    	return $Secciones;
    }

    public function cargarSeccion($seccion)
    {
    	return "<h1>$seccion</h1>";
    }

    public function cargarSubseccion($seccion, $subseccion)
    {
    	$nombre_vista = $seccion.".".$subseccion;
        if(view()->exists($nombre_vista)){
            return view($nombre_vista);
        }else{
            return "<h2>$nombre_vista no existe...</h2>";
        }
    }

    public function cargarFragmento($vista)
    {
        return view($vista);
    }

    public function postUploadImg()
    {
        extract(request()->all()); //Path, Quality

        //dd(Input::file('file'));
        $image = Image::make(request('file')->getRealPath());
        
        $Ruta = dirname($Path);
        if(!File::exists($Ruta)) File::makeDirectory($Ruta, 0775, true, true);

        //return $image->response('jpg', 70);

        if(!$image->save($Path, $Quality)){
            return response()->json(['Msg' => 'No se pudo guardar la imagen'], 512);
        }else{
            return response()->json(['Msg' => $Path ], 200);
        };
    }

    public function postUploadImagen()
    {
        extract(request()->all()); //Path, Quality, Alto, Ancho

        //dd(Input::file('file'));
        $image = Image::make(request('file')->getRealPath());
        
        $Ruta = dirname($Path);
        if(!File::exists($Ruta)) File::makeDirectory($Ruta, 0775, true, true);

        // $image->resize($Ancho, $Alto, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        //return $image->response('jpg', 70);

        if(!$image->save($Path, $Quality)){
            return response()->json(['Msg' => 'No se pudo guardar la imagen'], 512);
        }else{
            return response()->json(['Msg' => $Path ], 200);
        };
    }



    public function postObtenerLista()
    {
        extract(request()->all()); //Lista, Op1
        $Lista = \App\Models\Lista::where('lista', $Lista)->first();
        $Lista->detalles = \App\Models\ListaDetalle::where('lista_id', $Lista->id)->get();
        return $Lista;
    }


    public function postHacerExcel(Request $request)
    {
        $E = $request->input("E");//$this->req->Input('E');

        // if(!array_key_exists('ext', $E)) $E['ext'] = 'xls';
        // if(!array_key_exists('filename', $E)) $E['filename'] = 'Archivo';

        return Excel::download(new EstadisticasExportar($E["sheets"][0]["rows"]), $E["filename"].'.xlsx');

        /*
        Excel::create($E['filename'], function($excel) use($E) {
            foreach ($E['sheets'] as $k => $S) {

                if(!array_key_exists('name', $S)) $S['name'] = 'Hoja'.($k+1);

                $excel->sheet($S['name'], function($sheet) use ($E, $S) {
                    $sheet->row(1, $S['headers']);
                    $sheet->row(1, function($row) {
                        $row->setFontWeight('bold');
                        $row->setFontSize(12);
                    });
                    $sheet->rows($S['rows']);
                    $sheet->freezeFirstRow();
                    $sheet->setAutoFilter();
                });
            }
        })->export($E['ext']);
        */
    }


}
