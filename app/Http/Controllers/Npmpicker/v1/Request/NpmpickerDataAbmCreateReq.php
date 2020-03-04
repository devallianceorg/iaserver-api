<?php

namespace App\Http\Controllers\Npmpicker\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class NpmpickerDataAbmCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_stat' => 'required|integer',
            'total_error' => 'required|integer',
            'total_pickup' => 'required|integer',
            'hora' => 'required|datetime',
            'inspeccion' => 'required|integer',
            'ajuste'=>'required|integer'
        ];
    }

    public function attributes()
    {
        return [
            'id_stat' => 'El campo id_stat',
            'total_error' => 'El campo total_error',
            'total_pickup' => 'El campo total_pickup',
            'hora' => 'El campo hora',
            'inspeccion' => 'El campo inspeccion',
            'ajuste' => 'El campo ajuste'
        ];
    }

    public function messages()
    {
        return [
            'id_stat.required' => 'id_stat es Requerido',
            'total_error.required' => 'total_error es Requerido',
            'total_pickup.required' => 'total_pickup es Requerido',
            'hora.required' => 'hora es Requerido',
            'inspeccion.required' => 'inspeccion es Requerido',
            'ajuste.required' => 'ajuste es Requerido'
        ];
    }
}
