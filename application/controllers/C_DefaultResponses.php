<?php defined('BASEPATH') or exit('No direct script access allowed');

class C_DefaultResponses extends CI_Controller
{
    //buat pesan API, jika berjasil, true, false, dll
    public $api;
    public function index()
    {
        $this->api->print_json(array(
            'success' => true,
            'message' => 'Welcome to API.'
        ));
    }

    public function successServerRespond()
    {
        $this->api->print_json(array(
            'success' => true,
            'status' => 200,
            'message' => '200 OK'
        ));
    }

    public function routeNotFoundRespond()
    {
        $this->api->print_json(array(
            'success' => false,
            'status' => 404,
            'message' => '404 API Route Not Found'
        ));
    }

    public function internalServerErrorRespond()
    {
        $this->api->print_json(array(
            'success' => false,
            'status' => 500,
            'message' => '500 Internal Server Error'
        ));
    }
}
