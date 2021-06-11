<?php
namespace IAServer\Http\Controllers\Aoicollector\Api\Planta5;

use IAServer\Events\PlantaConsumeApi;
use IAServer\Http\Controllers\Aoicollector\Api\CollectorClient\CollectorClientApi;
use IAServer\Http\Controllers\Aoicollector\Model\TransaccionWip;
use IAServer\Http\Requests;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Response;

set_time_limit(400);

/**
 * Webservice utilizado por Planta5 para verificar el estado de una placa
 * tiene un tiempo de respuesta de 400seg
 *
 * @package IAServer\Http\Controllers\Aoicollector\Api\Planta5
 */
class Planta5Api extends CollectorClientApi
{
    /**
     * Obtiene el estado de la placa, personalizado para Planta 5
     * @example code
     * <php>
     * $p5 = new Planta5Api();
     * $p5->estadoDePlaca('000012345','Puesto1');
     * </php>

     * @param string $barcode Codigo de la placa
     * @param string $stage Identificador del puesto que consulta el service, se usa para loguear
     * @return Response Response::multiple();
     */

    public function estadoDePlacaV1($barcode, $stage)
    {
        $request = request();

        $placa = (object)$this->verifyBarcodeV1($barcode,$stage);
        if(isset($placa->error))
        {
            $output = ['error'=>$placa->error];
            $request->debugPro->append("ERROR");
        } else {
            if(isset($placa->smt))
            {
                $output = [
                    'barcode' => $placa->barcode,
                    'op' => $placa->smt->op,
                    'modelo' => $placa->smt->modelo,
                    'lote' => $placa->smt->lote,
                    'panel' => $placa->smt->panel,
                    'semielaborado' => $placa->smt->semielaborado,
                    'controldeplacas' => true
                    //'controldeplacas' => $placa->declaracion->declarado
                ];

                $output['estado'] = $placa->revision;
                $output['mensaje'] = '';

                if($placa->revision=='NG') {
                    $output['mensaje'] = 'El inspector de AOI determino la placa como NG';
                    $request->debugPro->append("NG");
                } else {
                    $request->debugPro->append("OK");
                }

                if(isset($placa->cuarentena->isBlocked) && ($placa->cuarentena->isBlocked))
                {
                    $output['estado'] = 'NG';
                    $output['mensaje'] = 'En cuarentena: '.$placa->cuarentena->causa->motivo;
                    $request->debugPro->append("CUARENTENA");
                }

                // Define la ruta de la placa en Planta 5 Montaje
                $twip = TransaccionWip::where('barcode',$placa->barcode)->first();
                if($twip!=null) {
                    $twip->id_last_route = 6;
                    $twip->save();
                }
            }else
            {
                $output = ['error'=>'No se localizo el barcode en AOI'];
            }

        }

        $output['planta'] = 'P5';
        Event::fire(new PlantaConsumeApi($output));

        return Response::multiple($output);
    }

    public function estadoDePlaca($barcode, $stage)
    {
        $request = request();

        $placa = (object)$this->verifyBarcode($barcode,$stage);
        if(isset($placa->error))
        {
            $output = ['error'=>$placa->error];
            $request->debugPro->append("ERROR");
        } else {
            if(isset($placa->smt))
            {
                $output = [
                    'barcode' => $placa->barcode,
                    'op' => $placa->smt->op,
                    'modelo' => $placa->smt->modelo,
                    'lote' => $placa->smt->lote,
                    'panel' => $placa->smt->panel,
                    'semielaborado' => $placa->smt->semielaborado,
                    'controldeplacas' => $placa->declaracion->declarado
                ];

                $output['estado'] = $placa->revision;
                $output['mensaje'] = '';

                if($placa->revision=='NG') {
                    $output['mensaje'] = 'El inspector de AOI determino la placa como NG';
                    $request->debugPro->append("NG");
                } else {
                    $request->debugPro->append("OK");
                }

                if(isset($placa->cuarentena->isBlocked) && ($placa->cuarentena->isBlocked))
                {
                    $output['estado'] = 'NG';
                    $output['mensaje'] = 'En cuarentena: '.$placa->cuarentena->causa->motivo;
                    $request->debugPro->append("CUARENTENA");
                }

                // Define la ruta de la placa en Planta 5 Montaje
                $twip = TransaccionWip::where('barcode',$placa->barcode)->first();
                if($twip!=null) {
                    $twip->id_last_route = 6;
                    $twip->save();
                }
            }else
            {
                $output = ['error'=>'No se localizo el barcode en AOI'];
            }

        }

        $output['planta'] = 'P5';
        Event::fire(new PlantaConsumeApi($output));

        return Response::multiple($output);
    }
}
