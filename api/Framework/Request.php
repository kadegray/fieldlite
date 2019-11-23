<?php

namespace Framework;

class Request {

    public $method = [];
    public $requestUri = [];
    public $modelsBasedOnRestUri = [];

    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->requestUri = data_get($_SERVER, 'REQUEST_URI');

        $this->modelsBasedOnRestUri = $this->generateResourceModelsFromIds();
    }

    protected function generateResourceIds()
    {
        $uriSegments = explode('/', $this->requestUri);
        $resourceIds = [];
        while(count($uriSegments) > 0) {
            $segment = array_pop($uriSegments);

            if (is_numeric($segment)) {
                $value = intval($segment);
                $key = array_pop($uriSegments);
                $resourceIds[$key] = $value;
            }
        }

        return array_reverse($resourceIds);
    }

    public function generateResourceModelsFromIds(): array
    {
        $resourceIds = $this->generateResourceIds();
        $models = [];
        foreach($resourceIds as $singularName => $modelId) {

            $className = Model::getModelClassWithSingularName($singularName);
            if (!$className) {
                continue;
            }

            // $models[] = $className::find($modelId);
        }

        return $models;
    }
}
