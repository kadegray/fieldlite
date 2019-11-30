<?php

namespace App\Models;

use Framework\Model;

class FieldSubscriber extends Model
{
    public $tableName = 'field_subscriber';

    public $fields = [
        'id',
        'field_type_id',
        'subscriber_id',
        'data',
        'updated_at',
        'created_at'
    ];
    public $fillable = [
        'field_type_id',
        'subscriber_id',
        'data',
    ];
}
