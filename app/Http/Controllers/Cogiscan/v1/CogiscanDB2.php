<?php
namespace App\Http\Controllers\Cogiscan\v1;

ini_set("default_socket_timeout", 120);

use Carbon\Carbon;
use App\Http\Controllers\Node\RestDB2CGS;
use App\Http\Controllers\Node\RestDB2CGSDW;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class CogiscanDB2 extends Controller
{
    protected $nodeRestHost = '10.30.10.90';
    protected $nodeRestPort = 1337;

    /**
     * Ejecuta los metodos sin necesidad de definir las rutas
     *
     * @return mixed
     */
    protected function dynamicCommands(){
        $command = Request::segment(3);
        $attributes= Arr::except( Request::segments() , [0,1,2]);

        $output = "";
        if(method_exists($this,$command))
        {
            $attributes = $this->normalizeAttributes($attributes);
            $output = call_user_func_array(array($this, $command), $attributes);
        } else
        {
            $output = array('error'=>'El metodo no existe');
        }

        return Response::multiple($output);
    }

    private function normalizeAttributes($attributes)
    {
        foreach($attributes as $index => $att)
        {
            $attributes[$index] = urldecode($att);
        }

        return $attributes;
    }

    private function services()
    {
        $class = 'App\Http\Controllers\Cogiscan\v1\CogiscanDB2';

        $array1 = get_class_methods($class);
        if($parent_class = get_parent_class($class)){
            $array2 = get_class_methods($parent_class);
            $array3 = array_diff($array1, $array2);
        }else{
            $array3 = $array1;
        }

        $output = array();

        foreach($array3 as $method)
        {
            $r = new \ReflectionMethod($class, $method);
            $params = $r->getParameters();

            $modifier = head(\Reflection::getModifierNames($r->getModifiers()));

            if($modifier=='public')
            {
                $output[$method] = null;
                foreach ($params as $param) {
                    $output[$method][] = $param->getName() . (($param->isOptional() == true) ? ' (opcional) ' : '');
                }
            }
        }

        return $output;
    }
    /*
     *  Estos metodos usaban un warper creado en .Net para conectar al DB2
     *  ahora se usa un REST ejecutado en un servidor NodeJs
     *
    private function query($db, $query) {
        $debug = new Debug($this,false,'db2',false);

        $ip = Request::server('REMOTE_ADDR');
        $host = getHostByAddr(Request::server('REMOTE_ADDR'));

        $cmd =  '%cd%\bin\db2wrapper\DB2Wrapper.exe '.$db.' '.$query;
        $debug->put($cmd.' IP: '.$ip.' HOST: '.$host);

        $output = array();
        exec($cmd,$output);
        $output = implode("",$output);

        return self::toJson($output);
    }
    private function toJson($xml)
    {
        try {
            $arr_xml = (array) simplexml_load_string($xml);
            $string_json = json_encode($arr_xml);
            $json_normalized = str_replace('@','',$string_json);
            $arr_json = json_decode($json_normalized,true);

            return $arr_json;
        } catch(\Exception $ex )
        {
             dd($ex->getMessage(),$xml);
        }
    }
    */
    /////////////////////////////////////////////////////////////////////////////
    //                          COGISCAN NODE REST API
    /////////////////////////////////////////////////////////////////////////////
    private function query($query)
    {
        // Descomentar luego cuando se resuelva lo de Cogiscan

        // $rest = new RestDB2CGS();

        //$rows = Input::get('rows');
        //if($rows!=null) {
        //    return $rest->paginate($query,$rows);
        //} else {


            // return $rest->get($query);
        
        
        //}
    }


    private function queryDW($query)
    {
        // Descomentar luego cuando se resuelva lo de Cogiscan
        // $restDW = new RestDB2CGSDW();

        // return $restDW->get($query);
    }

    ////////////////////////////////////////////////////////////////////////////
    //                                                                        //
    ////////////////////////////////////////////////////////////////////////////

    public function materialLoadedAt($fecha_desde = "",$fecha_hasta = "")
    {
        // Si no defino hasta
        if(empty($fecha_hasta)) {
            // y no defino desde
            if (empty($fecha_desde)) {
                $fecha_hasta = Carbon::now()->toDateString();
            } else {
                $fecha_hasta = $fecha_desde;
            }
        }

        if(empty($fecha_desde)) {
            $fecha_desde = Carbon::now()->toDateString();
        }
        $query = "
        SELECT
        EVENT_TMST,
        ITEM_PN AS PART_NUMBER,
        ITEM_TYPE_NAME,
        ITEM_ID,
        VARCHAR_FORMAT(EVENT_TMST, 'YYYY-MM-DD HH24:MI:ss') AS LOAD_TMST,
        VARCHAR_FORMAT(EVENT_TMST, 'YYYY-MM-DD HH24') AS LOAD_TMST_hora,
        EVENT_TYPE,
        USER_ID AS LOAD_USER_ID,
        DEGREE,
        ITEM_KEY,
        CNTR_KEY,
        CNTR_TYPE_NAME,
        LOCATION_IN_CNTR,
        CNTR_ID as TOP_ITEM_ID

        FROM CGS.ITEM_HISTORY_ALL

        WHERE

        EVENT_TYPE = 'LOAD'
        AND USER_ID <> 'CAMX EVENT PROCESSOR'
        AND (ITEM_TYPE_NAME = 'REEL' OR ITEM_TYPE_NAME = 'TRAY')
        AND (CNTR_TYPE_NAME = 'COMPLEX TOOL')
        -- AND (CNTR_TYPE_NAME <> 'TRANSITO' AND CNTR_TYPE_NAME <> 'MSTORAGE' AND CNTR_TYPE_NAME <> 'INITSTORAGE')
        AND EVENT_DATE BETWEEN '$fecha_desde' AND '$fecha_hasta'
        --AND EVENT_DATE BETWEEN '2017-09-25 00:00:00' AND '2017-09-27 23:59:59'
        ORDER BY EVENT_TMST ;
        ";
        $cargas = self::queryDW($query);

        $arr = [];
        foreach($cargas as $carga)
        {
            if(isset($carga->PART_NUMBER))
            {
                $cargasObj = new \stdClass();
                $cargasObj->ITEM_TYPE_EVENT = 'CARGA';
                $cargasObj->PART_NUMBER = $carga->PART_NUMBER;
                $cargasObj->ITEM_TYPE_NAME = $carga->ITEM_TYPE_NAME;
                $cargasObj->ITEM_ID = $carga->ITEM_ID;
                $cargasObj->EVENT_TMST = $carga->EVENT_TMST;
                $cargasObj->LOAD_TMST = $carga->LOAD_TMST;
                $cargasObj->LOAD_TMST_HORA = $carga->LOAD_TMST_HORA;
                $cargasObj->LOAD_USER_ID = $carga->LOAD_USER_ID;
                $cargasObj->FEEDER_ITEM_ID = "";
                $cargasObj->TOP_ITEM_ID = self::checkCNTR($carga->TOP_ITEM_ID,$carga->EVENT_TMST,$fecha_desde,$fecha_hasta);
                $cargasObj->CURR_ITEM_ID = $carga->TOP_ITEM_ID;

                if ($cargasObj->TOP_ITEM_ID != "")
                {
                    array_push($arr,$cargasObj);
                }
            }
        }

        $empalmes = $this->materialSplicedAt($fecha_desde,$fecha_hasta);
        foreach($empalmes as $empalme)
        {
            $cntr_id = ($empalme->CNTR_ID == "" || $empalme->CNTR_ID == NULL) ? 'INDEFINIDO' : $empalme->CNTR_ID;
            $cargasObj = new \stdClass();
            $cargasObj->ITEM_TYPE_EVENT = 'EMPALME';
            $cargasObj->PART_NUMBER = $empalme->PART_NUMBER;
            $cargasObj->ITEM_TYPE_NAME = "REEL";
            $cargasObj->ITEM_ID = $empalme->ITEM_ID;
            $cargasObj->INITIAL_QUANTITY = "";
            $cargasObj->INIT_TMST = "";
            $cargasObj->LOAD_TMST = Carbon::parse($empalme->EVENT_TMST)->format('Y-m-d H:m:s');
            $cargasObj->UNLOAD_TMST = "";
            $cargasObj->INIT_TMST_HORA = "";
            $cargasObj->LOAD_TMST_HORA = Carbon::parse($empalme->EVENT_TMST)->format('Y-m-d H');
            $cargasObj->UNLOAD_TMST_HORA = "";
            $cargasObj->LOAD_USER_ID = $empalme->USER_ID;
            $cargasObj->FEEDER_ITEM_ID = "";
            $cargasObj->TOP_ITEM_ID = $cntr_id;
            $cargasObj->CURR_ITEM_ID = $cntr_id;
            array_push($arr,$cargasObj);

        }

//        dd($arr);
        return $arr;
    }

    public function materialSplicedAt($fecha_desde = "",$fecha_hasta = "")
    {
        $query = "
            SELECT  EHALL.EVENT_TMST,
            EHALL.EVENT_TYPE,
            EHALL.USER_ID,
            (SELECT ITEM_PN FROM CGS.ITEM_HISTORY_ALL ihall WHERE ihall.ITEM_KEY = ehall.ITEM_KEY FETCH FIRST 1 ROWS ONLY) AS PART_NUMBER,
            (SELECT ITEM_ID FROM CGS.ITEM_HISTORY_ALL ihall WHERE ihall.ITEM_KEY = ehall.ITEM_KEY FETCH FIRST 1 ROWS ONLY) AS ITEM_ID,
            SUBSTR(EHALL.DESCRIPTION,LOCATE(';',EHALL.DESCRIPTION)+1,10) AS ITEM_ID_SPLICED,
            (
                SELECT CNTR_ID FROM CGS.ITEM_HISTORY_ALL IHALL
                WHERE IHALL.ITEM_ID = SUBSTR(EHALL.DESCRIPTION,LOCATE(';',EHALL.DESCRIPTION)+1,10)
                AND IHALL.EVENT_TYPE = 'LOAD'
                AND (IHALL.ITEM_TYPE_NAME = 'REEL' OR IHALL.ITEM_TYPE_NAME = 'TRAY')
                AND IHALL.CNTR_TYPE_NAME = 'COMPLEX TOOL'
                ORDER BY IHALL.EVENT_TMST DESC FETCH FIRST 1 ROWS ONLY
            ) AS CNTR_ID
            FROM CGS.EVENT_HIST_ALL EHALL
            WHERE EHALL.EVENT_DATE BETWEEN '$fecha_desde' AND '$fecha_hasta'
            --WHERE EHALL.EVENT_DATE BETWEEN '2017-09-25 00:00:00' AND '2017-09-27 23:59:59'
            AND EHALL.EVENT_TYPE = 'SPLICED'
            AND EHALL.USER_ID <> 'Not Logged in'
            AND EHALL.USER_ID <> 'CAMX EVENT PROCESSOR'
            ORDER BY EHALL.EVENT_TMST;
        ";
        return self::queryDW($query);
    }

    private function checkCNTR($cntr_id,$timestamp,$fechaDesde,$fechaHasta)
    {
        $toReturn="";
        if(substr($cntr_id,0,1) == 'S')
        {
            $toReturn = $cntr_id;
        }
        else
        {
            $toReturn = "";
        }
        return $toReturn;
    }

    private function getSpliceCntr($lpn)
    {
        $query = "SELECT CNTR_ID FROM CGS.ITEM_HISTORY_ALL WHERE ITEM_ID='$lpn' AND EVENT_TYPE='LOAD' AND CNTR_TYPE_NAME = 'COMPLEX TOOL';";
        return self::queryDW($query);
    }

    public function materialLoadedByUserAt($fecha_desde = "",$fecha_hasta = "")
    {
        $respuesta = $this->materialLoadedAt($fecha_desde,$fecha_hasta);

        if(isset($respuesta["error"]))
        {
            return $respuesta;
        } else
        {
            $handle = collect($respuesta);
            return $handle->groupBy('LOAD_USER_ID');
        }
    }
    /////////////////////////////////////////////////////////////////////////////
    //                          COGISCAN WEBSERVICES
    /////////////////////////////////////////////////////////////////////////////
    public function itemInfoByKey($itemKey)
    {
        $query = "select * from CGS.ITEM_INFO where ITEM_KEY = $itemKey limit 1";

        return self::query($query);
    }

    public function itemInfoByToolKey($toolKey)
    {
        $query = "select b.BATCH_ID,p.* from CGSPCM.PRODUCT p inner join CGSPCM.PRODUCT_BATCH b on b.BATCH_KEY = p.BATCH_KEY where p.TOOL_KEY = $toolKey limit 1";
        return self::query($query);
    }

    public function itemInfoByComplex($itemId)
    {
        $query = "select b.BATCH_ID,p.PRODUCT_KEY,p.BATCH_KEY,p.STATUS,p.ROUTE_STEP_KEY,p.NEXT_ROUTE_STEP_KEY,p.TOOL_KEY,p.LANE from CGSPCM.PRODUCT p
                  inner join CGSPCM.PRODUCT_BATCH b on b.BATCH_KEY = p.BATCH_KEY
                  inner join CGS.ITEM i on i.ITEM_ID = '".$itemId."'
                  inner join CGS.PRODUCT
                  where p.TOOL_KEY = i.ITEM_KEY limit 1";
        return self::query($query);
    }

    public function itemInfoById($itemId)
    {
        $query = "select * from CGS.ITEM_INFO where CGS.ITEM_INFO.ITEM_ID = '$itemId' limit 1 ";

        return self::query($query);
    }

    public function itemInfoInQuarentine($quarentine='Y')
    {
        $query = "select * from CGS.ITEM_INFO where QUARANTINE_LOCKED = '$quarentine' ";

        return self::query($query);
    }

    public function partNumber($partNumber,$itemId)
    {
        $query = "select * from CGS.PART_NUMBER p left join CGS.ITEM i on i.ITEM_ID = '$itemId'  where p.PART_NUMBER = '$partNumber' ";

        return self::query($query);
    }

    public function posicionesPorUbicacion($partNumber,$itemId,$location="")
    {
        $query = "select ts.* from CGSLSC.TOOL_SETUP ts
                left join CGS.PART_NUMBER pn ON pn.PART_NUMBER_KEY = ts.PRODUCT_PN_KEY
                left join CGS.ITEM i ON i.ITEM_KEY = ts.TOOL_KEY
                where pn.PART_NUMBER = '$partNumber'
                and i.ITEM_ID = '$itemId';  ";
        if ($location != "")
        {
            $query = "$query AND LOCATION = '$location'";
        }

        return self::query($query);
    }

    public function quantityOfPositionsOfMachineAndProductPartNumber($productPartNumber,$itemId)
    {
        $query = "
                select SUM(ts.quantity)
                from CGSLSC.TOOL_SETUP ts
                left join CGS.PART_NUMBER pn ON pn.PART_NUMBER_KEY = ts.PRODUCT_PN_KEY
                left join CGS.ITEM i ON i.ITEM_KEY = ts.TOOL_KEY
                where
                pn.PART_NUMBER = '$productPartNumber'
                and i.ITEM_ID = '$itemId'; ";

        return self::query($query);
    }

    public function itemByComplex($itemId)
    {
        $query = "select * from CGS.ITEM where ITEM_ID = '$itemId'";

        return self::query($query);
    }

    public function toolSetup($PRODUCT_PN_KEY,$TOOL_KEY)
    {
        $query = "select * from CGSLSC.TOOL_SETUP where PRODUCT_PN_KEY = $PRODUCT_PN_KEY and TOOL_KEY = $TOOL_KEY";

        return self::query($query);
    }

    public function opByPartNumber($partNumber)
    {
        $query = "select * from CGSPCM.product_batch where product_pn_key = (select part_number_key from CGS.part_number where part_number = '$partNumber')";

        return self::query($query);
    }

    public function opByComplexTool($complexId)
    {
        if($complexId ==="all"){
            $query = "SELECT pb.BATCH_ID,ii.ITEM_ID FROM CGSPCM.PRODUCT p
                  LEFT JOIN cgs.ITEM_INFO ii ON ii.ITEM_KEY = p.TOOL_KEY
                  LEFT JOIN cgspcm.PRODUCT_BATCH pb ON pb.batch_key = p.batch_key
                  WHERE ii.ITEM_ID like 'SMT%' OR ii.ITEM_ID like 'L%'";
        }else{
            $query = "SELECT pb.BATCH_ID,ii.ITEM_ID FROM CGSPCM.PRODUCT p
                  LEFT JOIN cgs.ITEM_INFO ii ON ii.ITEM_KEY = p.TOOL_KEY
                  LEFT JOIN cgspcm.PRODUCT_BATCH pb ON pb.batch_key = p.batch_key
                  WHERE ii.ITEM_ID = 'SMT$complexId' OR ii.ITEM_ID like 'L$complexId-NPM-D%'
                  ORDER BY p.LAST_STATUS_CHANGE_TMST FETCH FIRST 1 ROWS ONLY";
        }

        return self::query($query);
    }

    public function getAllMachinesFromLane($lane)
    {
        $machines = "select ITEM_ID from CGS.ITEM i where CNTR_KEY = (select ITEM_KEY from CGS.ITEM where item_id = 'SMT".$lane."')";

        return self::query($machines);
    }

    public function productPartNumberFromDate($fecha,$batchId,$linea)
    {
        $query = "select * from CGSPCM.DAILY_PRODUCTION
                  where PRODUCTION_DATE = '$fecha'
                  and BATCH_ID like '$batchId%'
                  and PROD_LINE_NAME = 'L$linea'";
        return self::queryDW($query);
    }

    public function totalPositionsByProductPartNumber($fecha,$batchId,$lane)
    {
        $totalComponents = 0;
        //Obtengo el programa utilizado para una op en una fecha definida para una linea
        $result = $this->productPartNumberFromDate($fecha,$batchId,$lane);
        if (count($result) != 0)
        {
            //Obtengo la lista de maquinas de una liena
            $machines = $this->getAllMachinesFromLane($lane);
            if(count($machines) != 0)
            {
                foreach ($machines as $key=>$machine)
                {
                    $components = $this->quantityOfPositionsOfMachineAndProductPartNumber($result[0]->PRODUCT_PN,$machine->ITEM_ID);
                    if(count($components) != 0)
                    {
                        $counter[] = collect($components[0])->first();
                    }
                    else
                    {
                        $counter[] = 0;
                    }
                }

                foreach($counter as $component)
                {
                    $totalComponents = $totalComponents + $component;
                }
            }
            else
            {
                $totalComponents = 0;
            }
        }
        return $totalComponents;
    }

    public function getUserInfo($barcode)
    {
        //formateo el código de usuario y lo convierto a minúsculas antes de realizar la consulta a la DB
//        $barcode = strtolower(substr($barcode,2,(strlen($barcode)-3)));
        $query = "SELECT u.USER_KEY,u.USER_ID,u.BADGE_BARCODE,u.FIRST_NAME,u.LAST_NAME,u.E_MAIL, p.PASSWORD FROM CGS.USER u
                    LEFT JOIN CGS.USER_PASSWORD p
                    ON p.USER_KEY=u.USER_KEY
                    WHERE u.USER_ID='$barcode'";
        $result = self::query($query);
        return $result;
    }
}
