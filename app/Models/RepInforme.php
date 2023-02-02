<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepInforme extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'reps__informes';

    public function getFilters()
    {
        $Filters = $this->hasMany('App\Models\RepFilter', 'Informe_id', 'id')->get();
        $this->filters = $Filters;
    }

    public function getSections()
    {
        $Sections = $this->hasMany('App\Models\RepSection', 'Informe_id', 'id')->orderBy('Order')->get();
        $this->sections = $Sections;
    }
}
