<?php

namespace App\Http\Controllers\Aoicollector\v1\Cuarentena;

use App\Http\Controllers\Aoicollector\Model\Cuarentena;
use App\Http\Controllers\SMTDatabase\v1\SMTDatabase;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;


class CuarentenaAbm extends CuarentenaController
{
    public function __construct()
    {
       $this->middleware('role:cuarentena_admin');
    }

    //List
    public function index()
    {
        $cuarentenas = Cuarentena::from('cuarentena AS c')
            ->select(db::raw(
            'id,
            id_user_calidad,
            motivo,
            tipo,
            id_maquina,
            op,
            created_at,
            updated_at,
            released_at,
            (select count(*) from aoidata.cuarentena_detalle where id_cuarentena = c.id and released_at is null) as "enCuarentena"
            '))->orderBy('enCuarentena','desc')->get();
        $output = compact('cuarentenas');
        return Response::multiple($output,'aoicollector.cuarentena.abm.index');
    }

    //Create
    public function create()
    {
        $output = [];
        return Response::multiple($output,'aoicollector.cuarentena.abm.create');
    }

    /*
    public function store()
    {
        $regex = '/([0-9]+)/';

        $tipo = Input::get('tipo');
        if(!isset($tipo))
        {
            $tipo = 'CODE';
        }

        $inputBarcodes = Input::get('barcodes');
        preg_match_all($regex, $inputBarcodes, $matches);
        $barcodes = $matches[0];

        foreach ($barcodes as $barcode) {
            $find = new FindInspection();
            $find->onlyLast = true;
            $find->withCuarentena = true;
            $inspeccion = (object) $find->barcode($barcode);
        }

        $rules = array(
            'op' => 'required',
            'puesto' => 'required',
            'regex' => 'required',
            'qty_etiquetas' => 'required',
            'qty_bloques' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return redirect('aoicollector/prod/routeop/create')
                ->withErrors($validator)
                ->withInput(Input::except('password'))
                ->with(['op'=>Input::get('op')]);
        } else {
            // store
            $store = new RouteOp();

            $store->op = Input::get('op');
            $store->name = strtoupper(Input::get('puesto'));
            $store->declare = (Input::get('declare') == 'on') ? 1 : 0;
            $store->regex = Input::get('regex');
            $store->qty_etiquetas = Input::get('qty_etiquetas');
            $store->qty_bloques = Input::get('qty_bloques');
            $store->cogiscan_partnumber = strtoupper(Input::get('cogiscan_partnumber'));

            $store->save();

            return redirect('aoicollector/prod/routeop?op='.Input::get('op'))->with('message','Ruta creada con exito!');
        }
    }
*/

    //Update
    public function edit($id)
    {
        $cuarentena = Cuarentena::find($id);

        $detailExpanded = $this->detailJoinedWithBlocks($cuarentena);
        $opGroup = collect($detailExpanded)->groupBy('inspected_op');
        $opList = [];

        foreach($opGroup as $op => $detail)
        {
            $add = new \stdClass();
            $add->smt = SMTDatabase::findOp($op);
            $add->total = $detail->count();
            $add->cuarentena = $detail->where('estado','cuarentena')->count();
            $add->released = $detail->where('estado','released')->count();
            $add->items = $detail;

            $opList[$op] = $add;
        }

        $output = compact('cuarentena','detailExpanded','opList');
        return Response::multiple($output,'aoicollector.cuarentena.abm.edit');
    }

    public function update($id)
    {

        $cuarentena = Cuarentena::find($id);

        if($cuarentena) {
            $cuarentena->motivo = Input::get('motivo');
            $cuarentena->save();
        } else {
            $output = 'La cuarentena no existe!';
        }

        return redirect(route('aoicollector.cuarentena.edit',$id))->with('message',"Motivo actualizado con exito!");
    }


    //Delete
    public function destroy($id)
    {
        $message = 'Cuarentena eliminada con exito!';
        $el = Cuarentena::find($id);
        if($el) {
            // SI HAY OP EN PRODUCCION DEBERIA ELIMINAR CONFIGURACION
            $el->delete();
        } else {
            $message = 'La cuarentena no existe!';
        }

        return redirect('aoicollector/cuarentena')->with('message',$message);
    }
}
