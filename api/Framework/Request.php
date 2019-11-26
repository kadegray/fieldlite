<?php

namespace Framework;

class Request
{
    public $method = [];
    public $requestUri = [];
    public $requestData = [];
    public $modelsBasedOnRestUri = [];

    public function __construct()
    {
        $this->requestUri = data_get($_SERVER, 'REQUEST_URI');
        $this->requestData = $_REQUEST;
        $this->correctPutRequestMethodIssue();
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->modelsBasedOnRestUri = $this->generateResourceModelsFromIds();
    }

    protected function correctPutRequestMethodIssue()
    {
        if (!in_array(data_get($_SERVER, 'REQUEST_METHOD'), [
            'PUT',
            'DELETE'
        ])) {
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
            $className = Model::getModelClassWithSingularName($singularName);
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

}
