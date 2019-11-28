<?php

namespace App\Models;

use Framework\Model;

class FieldType extends Model
{
    public $tableName = 'field_types';

    public $fields = [
        'id',
        'type',
        'title',
        'updated_at',
        'created_at'
    ];
    public $fillable = [
        'type',
        'title',
    ];
}
