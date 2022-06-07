<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Ion_auth
 */
class Utilities
{
    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Utilities_model');
        $this->CI->load->library(['ion_auth', 'form_validation']);

        date_default_timezone_set('America/Santiago');

    }


}
