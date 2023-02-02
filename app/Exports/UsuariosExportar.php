<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExportar implements FromCollection,WithHeadings
{

    protected $id;

    function __construct($id){
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Usuario::select("documento","nombres","apellidos","edad","sexo","celular","correo","departamento.descripcion as nombreDepartamento","municipio.descripcion as nombreMunicipio","vereda","finca")
                        ->leftJoin("usuario_organizacion","usuario_organizacion.usuario_id","=","usuarios.id")
                        ->leftJoin('listas_detalle as municipio','municipio.codigo','=','usuarios.municipio')
                        ->leftJoin('listas_detalle as departamento','departamento.codigo','=','usuarios.departamento')
                        ->where('usuario_organizacion.organizacion_id',$this->id)
                        ->where('perfil_id',4)
                        ->get();
    }

    public function headings():array{
        return ["Documento","Nombres","Apellidos","Edad","Género","Teléfono / Celular","Correo","Departamento","Municipio","Vereda","Finca"];
    }
}
