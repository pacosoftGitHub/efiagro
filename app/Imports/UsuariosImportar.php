<?php

namespace App\Imports;

use App\Usuarios;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsuariosImportar implements FromCollection, WithHeadingRow
{
    public function collection()
    {
        return Usuarios::all();
    }
}