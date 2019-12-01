<?php

namespace Framework;

use Framework\Validation\EmailDomainActiveRule;
use Framework\Validation\UniqueRule;
use Rakit\Validation\Validator;

class Request
{
    public $method = [];
    public $requestUri = [];
    public $requestData = [];
    public $modelsBasedOnRestUri = [];

    public $validator;
    public $validation = [];

    public function __construct()
    {
        $this->requestUri = data_get($_SERVER, 'REQUEST_URI');
        $this->requestData = $_REQUEST;
        if (!$this->requestData) {
            $this->requestData = json_decode(file_get_contents('php://input'), true);
        }
        $this->correctPutRequestMethodIssue();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->modelsBasedOnRestUri = $this->generateResourceModelsFromIds();

        $this->validator = new Validator;
        $this->validator->addValidator('unique', new UniqueRule());
        $this->validator->addValidator('email_domain_active', new EmailDomainActiveRule());
        $this->validate();
    }

    public function rules()
    {
        return [];
    }

    public function validate()
    {
        $rules = $this->rules();

        if (!count(array_keys($rules))) {
            return;
        }

        $validation = $this->validator->make($this->requestData, $rules);
        $validation->validate();

        if (!$validation->fails()) {
            return true;
        }

        $errors = $validation->errors();
        new Response($errors->firstOfAll(), 406);
    }

    protected function correctPutRequestMethodIssue()
    {
        if (data_get($_SERVER, 'REQUEST_METHOD') === 'POST') {
            $lastSegment = explode('/', $this->requestUri);
            $lastSegment = array_last($lastSegment);
            if (is_numeric($lastSegment)) {
                data_set($_SERVER, 'REQUEST_METHOD', 'PUT');
            }
        }
    }

    protected function generateResourceIds()
    {
        $uriSegments = explode('/', $this->requestUri);
        $resourceIds = [];
        while (count($uriSegments) > 0) {
            $segment = array_pop($uriSegments);

            if (is_numeric($segment)) {
                $value = intval($segment);
                $key = array_pop($uriSegments);

                if (!$key) {
                    continue;
                }

                $resourceIds[$key] = $value;
            }
        }

        return array_reverse($resourceIds);
    }

    public function generateResourceModelsFromIds(): array
    {
        $resourceIds = $this->generateResourceIds();
        $models = [];
        foreach ($resourceIds as $singularName => $modelId) {
            $className = Model::getModelClassByModelName($singularName);
            if (!$className) {
                continue;
            }

            $models[] = $className::find($modelId);
        }

        return $models;
    }

    public function data()
    {
        return $this->requestData;
    }

    public static function getRequestClassByModel($modelName)
    {
        $modelClass = Model::getModelClassByModelName($modelName);

        $modelName = explode('\\', $modelClass);
        $modelName = array_last($modelName);

        return 'App\\Requests\\' . $modelName . 'Request';
    }
}
