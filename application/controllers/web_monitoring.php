<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Web_monitoring extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_Web');
    }

    public function index()
    {
        $data['title'] = "Monitoring GPS";
        $data['data_monitoring'] = $this->M_Web->getAllData();

        $this->load->view('V_index', $data);
    }
}
