<?php

namespace Framework;

use Illuminate\Support\Str;
use JsonSerializable;

class Model implements JsonSerializable
{
    public $tableName;
    public $plural;
    public $singular;

    public $fields = [];
    public $fillable = [];

    protected $_fieldData = [];
    protected $_fieldsChanged = [];

    public function __construct($fieldDataArray = [])
    {
        $this->plural = Str::plural($this->tableName);
        $this->singular = Str::singular($this->tableName);

        if ($fieldDataArray) {
            $this->fillAll($fieldDataArray);
        }
    }

    public function jsonSerialize()
    {
        $attributes = [];
        $classMethods = get_class_methods($this);
        foreach ($classMethods as $classMethod) {
            if (Str::startsWith($classMethod, 'getAttribute')) {
                $atributeName = Str::replaceFirst('getAttribute', '', $classMethod);
                $atributeName = Str::snake($atributeName);

                $attributes[$atributeName] = $this->$classMethod();
            }
        }

        return array_merge($this->_fieldData, $attributes);
    }

    public static $modelClasses = [];

    public static function addModelClass($class)
    {
        if (in_array($class, self::$modelClasses)) {
            return;
        }

        self::$modelClasses[] = $class;
    }

    public function fillAll(array $array)
    {
        foreach ($array as $fieldName => $newFieldValue) {
            data_set($this, '_' . $fieldName, $newFieldValue);
        }
    }

    public function fill($array)
    {
        foreach ($array as $fieldName => $newFieldValue) {
            // is it fillable?
            if (!in_array($fieldName, $this->fillable)) {
                continue;
            }

            $this->$fieldName = $newFieldValue;
        }
    }

    public function __get(string $name)
    {
        if (!in_array($name, $this->fields)) {
            return;
        }

        return data_get($this->_fieldData, $name);
    }

    public function __set(string $name, $value)
    {
        if (in_array($name, [
            'id',
            'updated_at',
            'created_at'
        ])) {
            return;
        }

        $isBackground = Str::startsWith($name, '_');
        if ($isBackground) {
            $name = Str::replaceFirst('_', '', $name);
        }

        if (!in_array($name, $this->fields)) {
            return;
        }

        $currentFieldValue = data_get($name, $this->_fieldData);
        if ($currentFieldValue === $value) {
            return;
        }

        data_set($this->_fieldData, $name, $value);

        if ($isBackground) {
            return;
        }

        if (in_array($name, $this->_fieldsChanged)) {
            return;
        }

        $this->_fieldsChanged[] = $name;
    }

    public function save()
    {
        if (!count($this->_fieldsChanged)) {
            return false;
        }

        $query = null;
        if ($this->id) {
            $query = $this->getUpdateQuery();
        } else {
            $query = $this->getInsertQuery();
        }

        if (!$query) {
            return;
        }

        $response = Database::query($query);

        return $response;
    }

    public function delete()
    {
        if (!$this->id) {
            return;
        }

        $query = "DELETE FROM $this->tableName ";
        $query .= "WHERE id = $this->id;";

        $response = Database::query($query);

        return $response;
    }

    protected function getInsertQuery()
    {
        $query = "INSERT INTO $this->tableName ";
        $query .= '(' . implode(', ', $this->_fieldsChanged) . ') ';
        $values = [];
        foreach ($this->_fieldsChanged as $changedField) {
            $values[] = $this->$changedField;
        }
        $query .= 'VALUES ("' . implode('", "', $values) . '");';

        return $query;
    }

    protected function getUpdateQuery()
    {
        $query = "UPDATE $this->tableName ";
        $query .= 'SET ';
        $updates = [];
        foreach ($this->_fieldsChanged as $changedFieldName) {
            $updates[] = $changedFieldName . ' = "' . $this->$changedFieldName . '"';
        }
        $query .= implode(', ', $updates) . ' ';
        $query .= 'WHERE id = ' . $this->id . ';';

        return $query;
    }

    protected static function getInstance()
    {
        $className = get_called_class();
        $model = (new $className);

        return $model;
    }

    public static function all()
    {
        $modelInstance = self::getInstance();
        $query = "SELECT * FROM $modelInstance->tableName;";
        $all = Database::query($query);

        $modelClass = self::getModelClassByModelName($modelInstance->singular);
        $response = [];
        foreach ($all as $row) {
            $response[] = new $modelClass($row);
        }

        return $response;
    }

    public static function find(int $id)
    {
        $modelInstance = self::getInstance();
        $query = "SELECT * FROM $modelInstance->tableName WHERE id = $id;";

        $found = Database::query($query);
        if (!count($found)) {
            return;
        }

        $found = array_first($found);
        $modelInstance->fillAll($found);

        return $modelInstance;
    }

    public static function getModelClassByModelName($name)
    {
        $modelClassNames = self::getModelClassesFromModelFiles();

        foreach ($modelClassNames as $modelClassName) {
            $modelName = Str::replaceFirst('App\Models\\', '', $modelClassName);
            $modelName = Str::studly($modelName);
            $modelName = Str::singular($modelName);

            $name = Str::studly($name);
            $name = Str::singular($name);

            if ($modelName === $name) {
                return $modelClassName;
            }
        }
    }

    protected static function getModelClassesFromModelFiles()
    {
        $modelFiles = scandir(__DIR__ . '/../app/Models');
        $modelClassNames = [];

        foreach ($modelFiles as $fileName) {
            if (!Str::endsWith($fileName, '.php')) {
                continue;
            }

            $modelName = Str::replaceLast('.php', '', $fileName);
            $modelClassNames[] = 'App\\Models\\' . $modelName;
        }

        return $modelClassNames;
    }
}
