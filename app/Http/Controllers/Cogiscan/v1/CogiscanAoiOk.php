<?php
namespace App\Http\Controllers\Cogiscan\v1;

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class CogiscanAoiOk extends Controller
{

    /////////////////////////////////////////////////////////////////////////////
    //                          COGISCAN WEBSERVICES AOI
    /////////////////////////////////////////////////////////////////////////////


    public function endOperation($productId, $operationName, $toolId="")
    {
        if(!empty($toolId)) {
            $toolId = '<Parameter name="toolId">'.$toolId.'</Parameter>';
        }
        $param = [
            'endOperation',
            '<Parameters>
                <Parameter name="productId">'.$productId.'</Parameter>
                <Parameter name="operationName">'.$operationName.'</Parameter>
                '.$toolId.'
            </Parameters>
        '];
        $cmd = new CogiscanCommand($param);

        return response()->json($cmd->result());
    }

}
