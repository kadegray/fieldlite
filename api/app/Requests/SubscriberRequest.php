<?php

namespace App\Requests;

use Framework\Request;

class SubscriberRequest extends Request {

    public function rules()
    {
        $rules = [];

        if ($this->method === 'get') {
            return $rules;
        }

        if (in_array($this->method, ['post', 'put'])) {
            $rules = [
                'email_address' => 'required|email',
                'first_name' => 'required|between:1,255',
                'last_name' => 'required|between:1,255',
                'state' => 'required|integer',
            ];
        }

        if ($this->method === 'post') {
            $emailAddressRule = data_get($rules, 'email_address');
            data_set($rules, 'email_address', $emailAddressRule . '|unique:subscribers,email_address');
        }

        if ($this->method === 'put') {
            data_set($rules, 'id', 'required|integer');
        }

        return $rules;
    }
}
