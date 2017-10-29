<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Splash extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
    }

    public function index() {
        $meta = $this->meta;
        $this->load->view('splash', $data);
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
