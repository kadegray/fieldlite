<?php

namespace App\Requests;

use Framework\Request;

class FieldRequest extends Request {

    public function rules()
    {
        if (in_array($this->method, ['post', 'put'])) {
            return [
                'id' => 'integer',
                'title' => 'required|email|unique:users,email_address',
                'type' => 'required|between:1,255',
            ];
        }

        return [];
    }
}
