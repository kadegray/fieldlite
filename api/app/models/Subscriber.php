<?php

namespace App\Models;

use Framework\Database;
use Framework\Model;
use Framework\Response;

class Subscriber extends Model {

    public $tableName = 'subscribers';

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

    public function getAttributeFields()
    {
        $query = "SELECT
            field_subscriber.id,
            field_types.title,
            field_types.type,
            field_subscriber.data
        FROM field_subscriber
        LEFT JOIN field_types ON field_types.id = field_subscriber.field_type_id
        WHERE field_subscriber.subscriber_id = $this->id";

        return Database::query($query);
    }

}
