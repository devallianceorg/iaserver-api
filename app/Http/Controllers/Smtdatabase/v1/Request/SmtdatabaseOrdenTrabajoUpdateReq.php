<?php

namespace App\Http\Controllers\Smtdatabase\v1\Request;

use Illuminate\Foundation\Http\FormRequest;

class SmtdatabaseOrdenTrabajoUpdateReq extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'op' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'op' => 'El campo op'
        ];
    }

    public function messages()
    {
        return [
            'op.required' => 'op es Requerido'
        ];
    }
}
