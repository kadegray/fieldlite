<?php

namespace App\Models;

use Framework\Model;

class Field extends Model {

    public $tableName = 'fields';
    public $singular = 'field';

    public $fields = [
        'id',
        'title',
        'type',
        'updated_at',
        'created_at'
    ];
    public $fillable = [
        'title',
        'type',
    ];

}
