<?php
namespace App\Http\Controllers\Trazabilidad;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Smtdatabase\v1\Smtdatabase;
use App\Http\Controllers\Trazabilidad\v1\Wip\Wip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class Trazabilidad extends Controller
{
  function __construct()
  {
    
  }

  /**
     * Muestra todas las OP activas o liberadas
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->wipInfo();
    }

    /**
     * Busca una OP
     *
     * @param $op
     * @return \Illuminate\View\View
     */
    public function findOp(Request $request,$op="")
    {
		$op = strtoupper( $op );
		if(empty($op))
		{
			$op = strtoupper( $request->input('op') );
		}	

        return $this->wipInfo($op);
    }

    

    public function wipInfo($op="")
    {
        $output = $this->wipInfoCtrl($op);

       // dd($output);

        return Response::multiple($output,'trazabilidad.index');
    }

    public function wipInfoCtrl($op="")
    {
        $objwip = new Wip();
        $controldeplacas = null;

        if(!empty($op))
        {
           
            /*$enIa = DB::connection('iaserver')->select(DB::raw("
        select
            hib.*
            from aoidata.inspeccion_panel ip
            left join aoidata.history_inspeccion_bloque hib on hib.id_panel_history = ip.last_history_inspeccion_panel
            where
            ip.inspected_op = '$op'
            "));
            $enWip = DB::connection('traza')->select(DB::raw("
        select REFERENCIA_1 as barcode from XXE_WIP_ITF_SERIE
        where NRO_OP = '$op'"));*/

            $enIa = [];
            $enWip = [];

            $wip = $objwip->findOp($op,true,true);
            $smt = Smtdatabase::findOp($op);
            SMTDatabase::syncSmtWithWip($smt,$wip);

            if(isset($smt->modelo)) {
                $smt->registros = Panel::where('inspected_op',$op)->count();
                $controldeplacas = (object) DatosController::salidaByOp($op);
            }

            $sinDeclarar = Panel::sinDeclarar($op);

           

//            $wipPeriod = collect($wip->period($op)->get());

            $manualWip = new WipSerie();
            $manualWiph = new WipSerieHistory();

            $manualWipSerie = $manualWip->transactionResume($op,true);
            $manualWipHistory = $manualWiph->transactionResume($op,true);

           // dd($manualWipHistory);
           

        }

        $output = compact('op','wip','smt','controldeplacas','manualWipSerie','manualWipHistory','enIa','enWip','sinDeclarar');

        

        return $output;
   }
}