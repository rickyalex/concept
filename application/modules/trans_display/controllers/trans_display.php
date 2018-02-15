<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_display extends MX_Controller {
	
	public $mode;
	
    function __construct() {
        parent::__construct();

        // check if user logged in 
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
		
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('qms_model');
    }

    public function index() {
		$data['username'] = $this->qms_model->getUserName(USER_ID);
		
        $header['mode'] = $this->mode;
		
        $this->load->view('commons/header', $header);
        $this->load->view('trans_display',$data);
        $this->load->view('commons/footer');
    }
	
    public function getData() {
        $arr = $this->qms_model->getOpenBilledTransaction();
        foreach($arr as $key => $value){
            $arr[$key]['subtotal'] = $this->qms_model->getTotal($arr[$key]['order_no']);
            $arr[$key]['total'] = $arr[$key]['subtotal'] - ($arr[$key]['subtotal'] * $arr[$key]['discount']);
            
            // print_r($arr[$key]);
            //update header
            $this->db->where('id', $arr[$key]['id']);
            $query = $this->db->update('order_header' ,$arr[$key]);

            $arr[$key]['action'] = "<a class='remove' href='#'><i class='glyphicon glyphicon-remove'></a>";
        }
		
        echo json_encode($arr);
    }
	
    public function remove(){
        if ($this->uri->segment(3) !== FALSE){
            $id = $this->uri->segment(4);

            $res = $this->qms_model->getTransactionDetail($id);
            if($res!=null){
                //MENCEGAH ADA STOK HILANG, KALAU ADA DETAIL, TIDAK BISA DELETE
                die('Transaction still has items, delete items first');
            }
            else{
                //BISA DI DELETE
                
                $this->db->trans_start();

                $this->db->where('id', $id);
                $query = $this->db->delete('order_header');

                if($this->db->trans_status() === FALSE){// Check if transaction result successful
                    $this->db->trans_rollback();

                    $res = "Delete failed!";
                    die($res);
                }else{
                    $this->db->trans_complete();

                    $res = "Delete successfully!";
                    die($res);
                }
            }
        }
        else die('no parameter found !');
        
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
