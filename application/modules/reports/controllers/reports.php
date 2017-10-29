<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports extends MX_Controller {

    /**
     * @author entol
     * @see more  http://www.entol.net
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();

        // check if user logged in 
        // if (!$this->ion_auth->logged_in())
        // {
        // redirect('auth/login');
        // }
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
    }

    public function index() {
        $this->load->view('commons/header', $meta);
        $this->load->view('reports', $data);
        $this->load->view('commons/footer');
    }

    public function daily_reports() {

        $this->load->view('commons/header', $meta);
        $this->load->view('daily_reports', $data);
        $this->load->view('commons/footer');
    }

    public function getDailyReports() {
        foreach ($_POST as $key => $value) {
            $result[$key] = $this->input->post($key);
        }
        $date = $result['date'];

        $reports = $this->qms_model->getDailyReports($date);
        foreach ($reports as $key => $value) {
            if ($reports[$key]['tipe'] == 'NP'){
                $reports[$key]['product'] = $this->qms_model->getProductName($reports[$key]['product_id']);
            }
            elseif ($reports[$key]['tipe'] == 'PA')
                $reports[$key]['product'] = $this->qms_model->getPackageName($reports[$key]['product_id']);
        }
        
        echo json_encode($reports);
    }
    
    public function viewDailyReports(){
        $this->load->view('commons/header', $meta);
        $this->load->view('view_daily_reports', $data);
        $this->load->view('commons/footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
