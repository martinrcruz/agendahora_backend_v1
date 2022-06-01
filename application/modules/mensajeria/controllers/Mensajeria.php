<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mensajeria extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mensajeria_model');
        $this->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');
    }

    public function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } else {

            $data['datalibrary'] = array(
                'titulo' => "Mensajeria",
                'vista' => array('index', 'modals'),
                'libjs' => array('libjs'),
                'active' => 'mensajeria'
            );
            $this->load->view('estructura/body', $data);
        }
    }

}
