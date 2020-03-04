<?php

namespace App\Http\Controllers\Npmpicker\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class NpmpickerStatAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'total_error' => 'required|integer',
            'total_pickup' => 'required|integer',
            'hora' => 'required|string',
            'count' => 'required|integer',
            'estado' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'total_error' => 'El campo total_error',
            'total_pickup' => 'El campo total_pickup',
            'hora' => 'El campo hora',
            'count' => 'El campo count',
            'estado' => 'El campo estado',
        ];
    }

    public function messages()
    {
        return [
            'total_error.required' => 'total_error es Requerido',
            'total_pickup.required' => 'total_pickup es Requerido',
            'hora.required' => 'hora es Requerido',
            'count.required' => 'count es Requerido',
            'estado.required' => 'estado es Requerido'
        ];
    }
}
