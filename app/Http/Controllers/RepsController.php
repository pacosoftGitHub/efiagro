<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RepInforme;

class RepsController extends Controller
{
    public function getIndex()
    {
        $Infs = RepInforme::orderBy('Order', 'ASC')->get();
        return $Infs;
    }

    public function postGet()
    {
        $I = request()->all();
        $Inf = RepInforme::where('id', $I['id'])->first();
        $Inf->getFilters();
        $Inf->getSections();
        return $Inf;
    }
}
