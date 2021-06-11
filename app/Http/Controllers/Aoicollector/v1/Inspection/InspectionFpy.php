<?php

namespace IAServer\Http\Controllers\Aoicollector\Inspection;

use IAServer\Http\Requests;
use IAServer\Http\Controllers\Controller;

class InspectionFpy extends Controller
{
    private $inspectionList;

    public $inspecciones;
    public $total_real;
    public $total_falso;
    public $ng_aoi;
    public $ok_aoi;
    public $ng_ins;
    public $ok_ins;

    public function __construct(InspectionList $inspectionList)
    {
        $this->inspectionList = $inspectionList;

        $this->inspecciones = count($this->inspectionList->inspecciones);

        $this->total_falso = $this->inspectionList->inspecciones->sum('falsos');
        $this->total_real = $this->inspectionList->inspecciones->sum('reales');

        $this->ng_aoi = $this->inspectionList->inspecciones->where('revision_aoi','NG')->count();
        $this->ok_aoi = $this->inspectionList->inspecciones->where('revision_aoi','OK')->count();

        $this->ng_ins = $this->inspectionList->inspecciones->where('revision_ins','NG')->count();
        $this->ok_ins = $this->inspectionList->inspecciones->where('revision_ins','OK')->count();
    }
}