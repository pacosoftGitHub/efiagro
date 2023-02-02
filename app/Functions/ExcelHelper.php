<?php 

namespace App\Functions;

class ExcelHelper
{
	
    public static function makeFile($Array, $StartCell = 'A1')
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($Array, NULL, $StartCell);

        return $spreadsheet;
    }

    public static function getData($fileName, $modelo, $Campos, $startIn = 1)
    {
        $Bag = [];
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($fileName);
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($fileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $Rows = $worksheet->getHighestRow();

        for ($i=$startIn; $i <= $Rows; $i++) { 

            $newObj = app($modelo);

            foreach ($Campos as $F) {
                $value = $worksheet->getCell($F[1].$i)->getValue();
                $value = trim($value);
                $newObj[$F[0]] = $value;
            }

            $Bag[] = $newObj;
        }

        return $Bag;
    }



    public static function checkChanges($Objs, $newObjs, $Campos, $DeleteMode = true)
    {
        $Validators = $Campos->filter(function($C){ return $C[2] == 'true'; })->map(function($C){ return $C[0]; });

        $filteredObjs = collect([]);

        foreach ($newObjs as $O) {
            
            //Determinar la accion
            $O['_import_action'] = 'Crear';
            $import_errors = [];

            //Verificar si cumple con los requeridos
            foreach ($Validators as $Validator) {
                if(!$O[$Validator]){
                    $import_errors[] = "'$Validator' requerido";
                }    
            }

            if(empty($import_errors)){
                //Verificar existente
                $O['_import_current'] = $Objs->first(function ($Obj) use ($Validators, $O){
                    
                    if($Obj['_import_found']) return false;

                    $found = false;
                    foreach ($Validators as $Validator) {
                        $found = ( $Obj[$Validator] == $O[$Validator] );
                    };

                    $Obj['_import_found'] = $found;
                    return $found;
                });

                //Si existe verificar si hay cambios
                if(!is_null($O['_import_current'])){

                    $changed = false;
                    foreach ($Campos as $C) {
                        if($O[ $C[0] ] != $O['_import_current'][ $C[0] ]){
                            $changed = true;
                        }
                    }

                    $O['_import_action'] = $changed ? 'Actualizar' : 'Sin Cambios';
                }
            };

            if(!empty($import_errors)){
                $O['_import_action'] = 'Errores';
                $O['_import_errors'] = $import_errors;
            };

            if(!in_array($O['_import_action'], ['Sin Cambios'])){
                $filteredObjs[] = $O;
            }
        }

        if($DeleteMode){
            foreach ($Objs as $Obj) {

                if(!$Obj['_import_found']){

                    $filteredObjs[] = [
                        '_import_action'  => 'Eliminar',
                        '_import_current' => $Obj 
                    ];
                }

            }
        }

        return $filteredObjs;
    }



    public static function doSync($ModelName, $ImportData, $id = 'id')
    {
        $Model = app($ModelName);

        foreach ($ImportData as $Obj) {
            if($Obj['_import_action'] == 'Crear'){
                $DaObj = $Model->create($Obj);
                $DaObj->save();
            };

            if($Obj['_import_action'] == 'Actualizar'){
                $DaObj = $Model->where($id, $Obj['_import_current'][$id])->first();
                $DaObj->fill($Obj);
                $DaObj->save();
            };

            if($Obj['_import_action'] == 'Eliminar'){
                $DaObj = $Model->where($id, $Obj['_import_current'][$id])->first();
                $DaObj->delete();
            };
        }
    }


}