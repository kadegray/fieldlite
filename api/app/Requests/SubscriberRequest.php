<?php

namespace App\Requests;

use Framework\Request;

class SubscriberRequest extends Request {

    public function rules()
    {
        if (in_array($this->method, ['post', 'put'])) {
            return [
                'email_address' => 'required|email|unique:subscribers,email_address',
                'first_name' => 'required|between:1,255',
                'last_name' => 'required|between:1,255',
                'state' => 'required|integer',
            ];
        }

        return [];
    }
}
