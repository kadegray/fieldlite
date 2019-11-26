<?php

namespace App\Models;

use Framework\Model;

class Subscriber extends Model {

    public $tableName = 'subscribers';
    public $singular = 'subscriber';

    public const STATE_ACTIVE = 1;
    public const STATE_UNSUBSCRIBED = 2;
    public const STATE_JUNK = 3;
    public const STATE_BOUNCED = 4;
    public const STATE_UNCONFIRMED = 5;

    public $fields = [
        'id',
        'email_address',
        'first_name',
        'last_name',
        'state',
        'updated_at',
        'created_at'
    ];
    public $fillable = [
        'email_address',
        'first_name',
        'last_name',
        'state'
    ];

}
