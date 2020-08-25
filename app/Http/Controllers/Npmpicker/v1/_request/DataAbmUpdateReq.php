<?php

namespace App\Http\Controllers\Npmpicker\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class DataAbmUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer',
            'id_stat' => 'integer',
            'total_error' => 'integer',
            'total_pickup' => 'integer',
            'inspeccion' => 'integer',
            'ajuste'=>'integer'
        ];
    }

    public function attributes()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
