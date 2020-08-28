<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class ObservacionesCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string',
            'texto' => 'required|string',
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
