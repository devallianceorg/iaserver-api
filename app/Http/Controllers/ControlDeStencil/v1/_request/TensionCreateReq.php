<?php

namespace App\Http\Controllers\ControlDeStencil\v1\_request;

use Illuminate\Foundation\Http\FormRequest;

class TensionCreateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|string',
            'tension' => 'required|integer'
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
