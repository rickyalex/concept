<?php

//===============STANDARDIZE MODEL FUNCTIONS===============//
//TO IMPLEMENT BETTER PROGRAMMING APPROACH IN BCS//
//=========================================================//

class Qms_model extends CI_Model {

    protected $primary_key = null;
    protected $table_name = null;
    protected $relation = array();
    protected $relation_n_n = array();
    protected $primary_keys = array();
    private $DB = null;

    function __construct() {
        parent::__construct();

        $this->DB = $this->load->database('default', TRUE); //qms
    }

    //=============================== GET DATA ======================================//

    function getAllProduct() {
        $query = $this->DB->query("select * from m_product order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getProduct($id) {
        $query = $this->DB->query("select * from m_product where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getAllType() {
        $query = $this->DB->query("select * from m_type order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getType($id) {
        $query = $this->DB->query("select * from m_type where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getTypeName($id_type) {
        $query = $this->DB->query("select type as result from m_type where id = $id_type");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getAllCategory() {
        $query = $this->DB->query("select * from m_kategori order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getCategory($id) {
        $query = $this->DB->query("select * from m_kategori where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getCategoryName($id_category) {
        $query = $this->DB->query("select category as result from m_kategori where id = $id_category");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getAllVendor() {
        $query = $this->DB->query("select * from m_vendor order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getVendor($id_vendor) {
        $query = $this->DB->query("select * from m_vendor where id = $id_vendor");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = '';

        return $res;
    }
	
	function getVendorName($id_vendor) {
        $query = $this->DB->query("select vendor as result from m_vendor where id = '$id_vendor'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getAllUsers() {
        $query = $this->DB->query("select * from users order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getMaxID($table){
		$query = $this->DB->query("select max(id) as code_max FROM $table");
		if( $query->num_rows() > 0)
		{
			$code_max = explode("/",$query->row()->code_max);
			$code_max = $code_max[0] + 1;
		}
		else $code_max = "1";
		
		return $code_max;
	}
	
	function getAllPackage() {
        $query = $this->DB->query("select * from m_package order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getPackage($id) {
        $query = $this->DB->query("select id, package, floor(discount*100) as discount, date_created, created_by from m_package where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getPackageName($package_id) {
        $query = $this->DB->query("select package as result from m_package where id = '$package_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getPackageProducts($package_id) {
        $query = $this->DB->query("select b.id, b.product_id, b.qty from m_package a, mpd b where a.id = b.id_header and a.id = '$package_id'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getAllReceiveSlip() {
        $query = $this->DB->query("select * from receive_slip order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getReceiveSlip($id) {
        $query = $this->DB->query("select * from receive_slip where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getReceiveSlipDetail($id) {
        $query = $this->DB->query("select * from rsd where id_header = '".$id."'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getProductName($product_id) {
        $query = $this->DB->query("select description as result from m_product where product_id = $product_id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getProductOnHand($product_id) {
        $query = $this->DB->query("select sum(qty_on_hand) as result from rsd where product_id = '$product_id' group by product_id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getDocumentNo($table,$id_header) {
        $query = $this->DB->query("select document_no as result from $table where id = '$id_header'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getAllHistory() {
        $query = $this->DB->query("select * from history order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getInventory() {
        $query = $this->DB->query("select * from inventory_on_hand order by product_id");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getOpenBilledTransaction() {
        $query = $this->DB->query("select * from order_header where status = 'open' order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getTransaction($id) {
        $query = $this->DB->query("select * from order_header where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getTransactionDetail($id_header) {
        $query = $this->DB->query("select * from order_detail where id_header = '$id_header'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getTransactionDetailByOrderNo($order_no) {
		
        $query = $this->DB->query("select b.* from order_header a, order_detail b where a.id = b.id_header and a.order_no = '$order_no'");
		$res = $query->result_array();

        return $res;
    }
	
	function getInventoryProduct() {
        //$query = $this->DB->query("SELECT CONCAT('PR',a.id) AS id, b.`description`, qty_on_hand FROM rsd a, m_product b WHERE qty_on_hand > 0 AND a.`product_id` = b.`product_id` UNION SELECT CONCAT('PA',id) AS id, CONCAT('PACKAGE - ',package) AS description, 0 AS qty_on_hand FROM m_package");
		$query = $this->DB->query("SELECT id, product_id, qty_on_hand as total FROM rsd");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
	
	function getProductPrice($receive_id) {
        $query = $this->DB->query("select selling_price as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getProductID($receive_id) {
        $query = $this->DB->query("select product_id as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getOrderID($order_no) {
        $query = $this->DB->query("select id as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getTotal($order_no) {
        
		$query = $this->DB->query("select sum(b.subtotal) as result from order_header a, order_detail b where a.id = b.id_header and a.order_no = '$order_no' group by b.id_header");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
	
	function getQtyOnHand($receive_id) {
		
        $query = $this->DB->query("select qty_on_hand as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    // function getAllEmployee() {
        // $query = $this->hris->query("select * from m_karyawan order by id desc");
        // if ($query->num_rows() > 0) {
            // $res = $query->result_array();
        // }

        // //$this->fb->log($res);
        // else
            // $res = array();

        // return $res;
    // }

    // function getEmployeeName($payroll_id) {
        // //get employee details

        // $query = $this->hris->query("select nama_karyawan as result FROM m_karyawan where payroll_id = '".$payroll_id."'");
        // if ($query->num_rows() > 0) {
            // $res = $query->row_array();
            // $result = $res['result'];
        // }

        // return $result;
    // }
    
    // function getEmployeeAge($payroll_id) {
        // //get employee details

        // $query = $this->hris->query("select FLOOR(datediff(now(),tgl_lahir) / 365.25) as result FROM m_karyawan where payroll_id = '".$payroll_id."'");
        // if ($query->num_rows() > 0) {
            // $res = $query->row_array();
            // $result = $res['result'];
        // }

        // return $result;
    // }
    
    function generateOrderNo() {
        //get employee details
		$num = mt_rand(0,1000);
		$now = Date('Y-m-d');
		
        $query = $this->DB->query("select order_no FROM order_header where order_no='$num' and date=$now");
        if ($query->num_rows() <= 0) {
            $result = $num;
        }
		else $this->generateOrderNo();

        return $result;
    }
    
    function getUserName($id){
        //get employee name
        
        $query = $this->DB->query("select concat(first_name,' ',last_name) as full_name from users where id='$id'");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $full_name = $row['full_name'];
        }
        else $full_name = "NOT FOUND";
        
        return $full_name;
    }

    //=============================== SET DATA ======================================//

    function submitTableData($table, $data) {
        $data['date_created'] = Date('Y-m-d G:i:s');
        $data['created_by'] = USER_ID;
		//die(print_r($table));
        $this->db->insert($table, $data);
    }

}

?>
