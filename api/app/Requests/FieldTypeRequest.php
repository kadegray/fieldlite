<?php

namespace App\Requests;

use Framework\Request;

class FieldTypeRequest extends Request
{
    public function rules()
    {
        $rules = [];

        if ($this->method === 'get') {
            return $rules;
        }

        if (in_array($this->method, ['post', 'put'])) {
            $rules = [
                'title' => 'required|email|unique:users,email_address',
                'type' => 'required|between:1,255',
            ];
        }

        return $rules;
    }
}
