<?php

namespace Framework\Validation;

use Framework\Database;
use Rakit\Validation\Rule;

class EmailDomainActiveRule extends Rule
{
    protected $message = ':attribute :value is not an active domain';

    protected $fillableParams = [];

    public function check($emailAddress): bool
    {
        $emailAddress = explode('@', $emailAddress);
        $domain = array_last($emailAddress);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $domain);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $active = !!curl_exec($ch);
        curl_close($ch);

        return $active;
    }
}
