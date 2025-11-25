<?php

class Api
{
    public function print_json($value)
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode($value);
        die;
    }

    public function unsupportedFeatureException()
    {
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(array(
            'success' => false,
            'message' => 'this feature is currently not supported.'
        ));
    }

    public function checkNumericId($id)
    {
        if (!is_numeric($id)) {
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode(array(
                'success' => false,
                'message' => "the id must be integer only (your current request id is '$id')."
            ));
            die;
        }
    }
}
