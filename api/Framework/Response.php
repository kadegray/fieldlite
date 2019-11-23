<?php

class Response {

    protected $contentType = 'application/json';

    public function __construct(
        $responseData,
        $reponseCode = 200
    ) {
        header('Content-type: ' . $this->contentType);
        http_response_code($reponseCode);
        echo json_encode($responseData);
        exit();
    }
}
