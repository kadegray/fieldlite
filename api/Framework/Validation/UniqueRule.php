<?php

namespace Framework\Validation;

use Framework\Database;
use Rakit\Validation\Rule;

class UniqueRule extends Rule
{
    protected $message = ':attribute :value has been used';

    protected $fillableParams = ['table', 'column', 'except'];

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);

        $column = $this->parameter('column');
        $table = $this->parameter('table');
        $except = $this->parameter('except');

        if ($except and $except == $value) {
            return true;
        }

        $query = "SELECT count(*) AS count FROM `{$table}` WHERE `{$column}` = \"{$value}\"";

        $response = Database::query($query);
        $response = data_get($response, '0.count', 0);

        // true for valid, false for invalid
        return intval($response) === 0;
    }
}
