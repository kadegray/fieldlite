<?php

namespace Framework;

class Model
{
    public $plural;
    public $singular;
    public $tableName;
    public $fillable = [];

    public function __construct()
    {
        if (!$this->plural) {
            $this->plural = $this->tableName;
        }
    }

    public function fill()
    {
        // foreach($this->fillable as $fillableFieldName) {

        // }
    }

    public static function find()
    {

    }

    public static function getModelClassWithSingularName($singularName)
    {
        foreach (get_declared_classes() as $class) {
            if (
                $class instanceof Model
                && (new $class)->singular == $singularName
            ) {
                return;
            }
        }
    }

}
