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
        $query = $this->DB->query("SELECT * from m_product order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getProduct($id) {
        $query = $this->DB->query("SELECT * from m_product where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getAllType() {
        $query = $this->DB->query("SELECT *,(SELECT category FROM m_kategori b WHERE b.id=a.id_category) AS category_name from m_type a order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getType($id) {
        $query = $this->DB->query("SELECT * from m_type where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getTypeID($product_id) {
        $query = $this->DB->query("SELECT id_type as result from m_product where id = '$product_id' or product_id='$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getTypeName($id_type) {
        $query = $this->DB->query("SELECT type as result from m_type where id = $id_type");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getAllCategory() {
        $query = $this->DB->query("SELECT * from m_kategori order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getCategory($id) {
        $query = $this->DB->query("SELECT * from m_kategori where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getCategoryID($id) {
        $query = $this->DB->query("SELECT id_category as result from m_type where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getCategoryName($id_category) {
        $query = $this->DB->query("SELECT category as result from m_kategori where id = $id_category");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getAllVendor() {
        $query = $this->DB->query("SELECT * from m_vendor order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getVendor($id_vendor) {
        $query = $this->DB->query("SELECT * from m_vendor where id = $id_vendor");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = '';

        return $res;
    }
    
    function getVendorName($id_vendor) {
        $query = $this->DB->query("SELECT vendor as result from m_vendor where id = '$id_vendor'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getAllUsers() {
        $query = $this->DB->query("SELECT * from users order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getMaxID($table){
        $query = $this->DB->query("SELECT max(id) as code_max FROM $table");
        if( $query->num_rows() > 0)
        {
            $code_max = explode("/",$query->row()->code_max);
            $code_max = $code_max[0] + 1;
        }
        else $code_max = "1";
        
        return $code_max;
    }
    
    function getMaxProductID($table){
        $query = $this->DB->query("SELECT max(product_id) as code_max FROM $table");
        if( $query->num_rows() > 0)
        {
            $code_max = explode("/",$query->row()->code_max);
            $code_max = $code_max[0] + 1;
        }
        else $code_max = "1";
        
        return $code_max;
    }
    
    function getAllPackage() {
        $query = $this->DB->query("SELECT * from m_package order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getPackage($id) {
        $query = $this->DB->query("SELECT id, package, floor(discount*100) as discount, date_created, created_by from m_package where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getDiscount($id) {
        $query = $this->DB->query("SELECT floor(discount*100) as result from m_package where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getDiscountHeader($order_no) {
        $query = $this->DB->query("SELECT floor(discount*100) as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getPackageDetail($id) {
        $query = $this->DB->query("SELECT * from mpd where id_header = $id");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getPackageDetailByID($id) {
        $query = $this->DB->query("SELECT * from mpd where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getPackageName($package_id) {
        $query = $this->DB->query("SELECT package as result from m_package where id = '$package_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getPackageProducts($package_id) {
        $query = $this->DB->query("SELECT b.id, b.product_id, b.qty from m_package a, mpd b where a.id = b.id_header and a.id = '$package_id'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getAllReceiveSlip() {
        $query = $this->DB->query("SELECT * from receive_slip order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getReceiveSlip($id) {
        $query = $this->DB->query("SELECT * from receive_slip where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getReceiveSlipDetail($id) {
        $query = $this->DB->query("SELECT * from rsd where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getReceiveSlipDetail2($id) {
        $query = $this->DB->query("SELECT * from rsd where id_header = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getProductName($product_id) {
        $query = $this->DB->query("SELECT description as result from m_product where product_id = $product_id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getMProductID($id) {
        $query = $this->DB->query("SELECT product_id as result from m_product where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getProductName2($id) {
        $query = $this->DB->query("SELECT description as result from m_product where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getProductOnHand($product_id) {
        $query = $this->DB->query("SELECT sum(qty_on_hand) as result from rsd where product_id = '$product_id' group by product_id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getDocumentNo($table,$id_header) {
        $query = $this->DB->query("SELECT document_no as result from $table where id = '$id_header'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getConfirmPass() {
        $query = $this->DB->query("SELECT confirmpass as result from confirm_pass order by id desc limit 1");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getAllHistory() {
        $query = $this->DB->query("SELECT * from history order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }

    function countMinStock() {
        $query = $this->DB->query("SELECT COUNT(a.id) AS res FROM inventory_on_hand a, m_product b WHERE a.product_id = b.id AND a.qty_on_hand <= b.min_stock");
        if ($query->num_rows() > 0) {
            $res = $query->row()->res;
        }
        else
            $res = 0;

        return $res;
    }

    function getMinStock($id) {
        $query = $this->DB->query("SELECT min_stock as res from m_product where id = $id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->res;
        }
        else
            $res = 0;

        return $res;
    }
    
    function getInventory() {
        $query = $this->DB->query("SELECT * from inventory_on_hand order by qty_on_hand");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getOpenBilledTransaction() {
        $query = $this->DB->query("SELECT * from order_header where `date` < NOW() + INTERVAL 30 DAY order by id desc");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getTransaction($id) {
        $query = $this->DB->query("SELECT *,floor(discount*100) as discount from order_header where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getTransactionDetail($id_header) {
        $query = $this->DB->query("SELECT * from order_detail where id_header = '$id_header'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getOrderDetail($id) {
        $query = $this->DB->query("SELECT * from order_detail where id = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }

    function getCheckoutStatus($order_no) {
        
        $query = $this->DB->query("SELECT flag_print as result from order_header where order_no = '$order_no'");
        $res = $query->row()->result;

        return $res;
    }
    
    function getTransactionDetailByOrderNo($order_no) {
        
        $query = $this->DB->query("SELECT b.* from order_header a, order_detail b where a.id = b.id_header and a.order_no = '$order_no'");
        $res = $query->result_array();

        return $res;
    }
    
    function getTransactionDetailByOrderNo2($order_no) {
        
        $query = $this->DB->query("SELECT b.tipe,b.`product_id`,SUM(b.qty) AS qty, b.price,SUM(b.subtotal) AS subtotal
                                    FROM order_header a, order_detail b 
                                    WHERE a.id = b.id_header AND a.order_no = '$order_no'
                                    GROUP BY b.tipe,b.`product_id`,b.price");
        $res = $query->result_array();

        return $res;
    }
    
    function getInventoryProduct() {
        $query = $this->DB->query("SELECT id, product_id, qty_on_hand as total FROM rsd");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getInventoryProduct2() {
        //$query = $this->DB->query("SELECT CONCAT('PR',a.id) AS id, b.`description`, qty_on_hand FROM rsd a, m_product b WHERE qty_on_hand > 0 AND a.`product_id` = b.`product_id` UNION SELECT CONCAT('PA',id) AS id, CONCAT('PACKAGE - ',package) AS description, 0 AS qty_on_hand FROM m_package");
        $query = $this->DB->query("SELECT product_id, SUM(qty_on_hand) AS total FROM rsd GROUP BY product_id");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getInventoryProduct3() {
        //$query = $this->DB->query("SELECT CONCAT('PR',a.id) AS id, b.`description`, qty_on_hand FROM rsd a, m_product b WHERE qty_on_hand > 0 AND a.`product_id` = b.`product_id` UNION SELECT CONCAT('PA',id) AS id, CONCAT('PACKAGE - ',package) AS description, 0 AS qty_on_hand FROM m_package");
        $query = $this->DB->query("SELECT CONCAT('NP',a.product_id) AS product_id, SUM(qty_on_hand) AS total, 'Non Package' AS tipe FROM rsd a LEFT JOIN m_product b ON a.product_id=b.product_id WHERE b.id_type <> '3' GROUP BY a.product_id
                                   UNION
                                   SELECT CONCAT('PA',id) AS product_id, 1 AS total, 'Package' AS tipe FROM m_package");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else
            $res = array();

        return $res;
    }
    
    function getProductPrice($receive_id) {
        $query = $this->DB->query("SELECT selling_price as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getAllPrice($receive_id) {
        $query = $this->DB->query("SELECT selling_price, receive_price from rsd where product_id = '$receive_id' order by date_created DESC limit 0,1");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        }
        else{
            $query = $this->DB->query("SELECT IFNULL(SUM(a.qty * receive_price),0) AS receive_price, IFNULL(SUM(a.qty * selling_price),0) AS selling_price
                                       FROM mpd a, rsd b
                                       WHERE a.id_header = $receive_id AND a.product_id=b.id");
            if ($query->num_rows() > 0) {
                $res = $query->result_array();
            }
            else $res = array('receive_price' => 0,'selling_price' => 0);

        }

        return $res;
    }
    
    function getAllPrice2($receive_id) {
        $tipe = substr($receive_id,0,2);
        $receive_id = substr($receive_id,2);
        if($tipe == 'NP'){
            $query = $this->DB->query("SELECT selling_price, receive_price from rsd where product_id = '$receive_id' order by date_created DESC limit 0,1");
            if ($query->num_rows() > 0) {
                $res = $query->result_array();
            }
            else 
                $res = array();

        }elseif($tipe == 'PA'){
            $query = $this->DB->query("SELECT SUM(a.qty *  (SELECT DISTINCT receive_price FROM rsd WHERE a.product_id=product_id limit 1)) AS receive_price,
                                        SUM(a.qty *  (SELECT DISTINCT selling_price FROM rsd WHERE a.product_id=product_id limit 1)) AS selling_price
                                        FROM mpd a,m_package c
                                        WHERE a.id_header = '$receive_id' AND a.id_header=c.id");
            if ($query->num_rows() > 0) {
                $res = $query->result_array();
            }
            else 
                $res = array();
        }
        

        return $res;
    }
    
    function getIDHeader($receive_id) {
        $query = $this->DB->query("SELECT id_header as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getIDHeader2($id_detail) {
        $query = $this->DB->query("SELECT id_header as result from order_detail WHERE id=$id_detail");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }

    function getIDHeaderByOrderNo($order_no) {
        $query = $this->DB->query("SELECT id as result from order_header WHERE order_no='$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getProductID($receive_id) {
        $query = $this->DB->query("SELECT product_id as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getSellingPrice($product_id) {
        $query = $this->DB->query("SELECT selling_price as result from rsd where id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = 0;

        return $res;
    }
    
    function getReceivePrice($product_id) {
        $query = $this->DB->query("SELECT receive_price as result from rsd where id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = 0;

        return $res;
    }
    
    function getSellingPrice2($product_id) {
        $query = $this->DB->query("SELECT selling_price as result from rsd where product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = 0;

        return $res;
    }
    
    function getReceivePrice2($product_id) {
        $query = $this->DB->query("SELECT receive_price as result from rsd where product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = 0;

        return $res;
    }
    
    function getOrderID($order_no) {
        $query = $this->DB->query("SELECT id as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getCash($order_no) {
        $query = $this->DB->query("SELECT payment as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getDP($order_no) {
        $query = $this->DB->query("SELECT down_payment as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getReturn($order_no) {
        $query = $this->DB->query("SELECT `return` as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getCustomer($order_no) {
        $query = $this->DB->query("SELECT `customer_name` as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getPhone($order_no) {
        $query = $this->DB->query("SELECT `customer_phone` as result from order_header where order_no = '$order_no'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getTotal($order_no) {
        
        $query = $this->DB->query("SELECT sum(b.subtotal) as result from order_header a, order_detail b where a.id = b.id_header and a.order_no = '$order_no' group by b.id_header");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getQtyOnHand($receive_id) {
        
        $query = $this->DB->query("SELECT qty_on_hand as result from rsd where id = '$receive_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getQtyOnHand2($receive_id) {
        
        $query = $this->DB->query("SELECT SUM(qty_on_hand) as result from rsd where product_id = '$receive_id' GROUP BY product_id");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }

    function getModal($product_id) {
        
        $query = $this->DB->query("SELECT receive_price as result from rsd where product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getLaba($product_id) {
        
        $query = $this->DB->query("SELECT selling_price-receive_price as result from rsd where product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function getLabaService($product_id) {
        
        $query = $this->DB->query("SELECT selling_price as result from rsd where product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    // function getQtyOnHand3($receive_id) {
        
    //     $query = $this->DB->query("SELECT SUM(qty_on_hand) as result from rsd where product_id = '$receive_id' GROUP BY product_id");
    //     if ($query->num_rows() > 0) {
    //         $res = $query->row()->result;
    //     }
    //     else{
    //         $query = $this->DB->query("SELECT SUM(qty_on_hand) as result from rsd where product_id = '$receive_id' GROUP BY product_id");
    //         if ($query->num_rows() > 0) {
    //             $res = $query->row()->result;
    //         }
    //         else
    //             $res = '';
    //     }

    //     return $res;
    // }
    
    function cekQtyOnHand($receive_id) {
        
        $query = $this->DB->query("SELECT qty_on_hand as result from rsd where product_id = '$receive_id' AND qty_on_hand > 0 ORDER BY id ASC LIMIT 0,1");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function cekProductById($id_header, $product_id) {
        
        $query = $this->DB->query("SELECT COUNT(*) as result FROM rsd WHERE id_header = '$id_header' AND product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function cekProductPackageById($id_header, $product_id) {
        
        $query = $this->DB->query("SELECT COUNT(*) as result FROM mpd WHERE id_header = '$id_header' AND product_id = '$product_id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function cekDetailPackage($id) {
        
        $query = $this->DB->query("SELECT COUNT(*) as result FROM mpd WHERE id_header = '$id'");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    function cekOrderDetailPackage($id) {
        
        $query = $this->DB->query("SELECT COUNT(*) AS result FROM order_detail WHERE product_id IN (SELECT id_header FROM mpd WHERE product_id = $id)");
        if ($query->num_rows() > 0) {
            $res = $query->row()->result;
        }
        else
            $res = '';

        return $res;
    }
    
    
    
    // function getAllEmployee() {
        // $query = $this->hris->query("SELECT * from m_karyawan order by id desc");
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

        // $query = $this->hris->query("SELECT nama_karyawan as result FROM m_karyawan where payroll_id = '".$payroll_id."'");
        // if ($query->num_rows() > 0) {
            // $res = $query->row_array();
            // $result = $res['result'];
        // }

        // return $result;
    // }
    
    // function getEmployeeAge($payroll_id) {
        // //get employee details

        // $query = $this->hris->query("SELECT FLOOR(datediff(now(),tgl_lahir) / 365.25) as result FROM m_karyawan where payroll_id = '".$payroll_id."'");
        // if ($query->num_rows() > 0) {
            // $res = $query->row_array();
            // $result = $res['result'];
        // }

        // return $result;
    // }
    
    function generateOrderNo() {
        //get employee details
        $num = mt_rand(0,1000);
        $now = Date('Ymd');
        $orderno = $now.$num;
        
        //$query = $this->DB->query("SELECT order_no FROM order_header where order_no='$num' and date=$now");
        $query = $this->DB->query("SELECT order_no FROM order_header where order_no='$orderno'");
        if ($query->num_rows() <= 0) {
            $result = $orderno;
        }
        else $this->generateOrderNo();

        return $result;
    }
    
    function getUserName($id){
        //get employee name
        
        $query = $this->DB->query("SELECT concat(first_name,' ',last_name) as full_name from users where id='$id'");
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $full_name = $row['full_name'];
        }
        else $full_name = "NOT FOUND";
        
        return $full_name;
    }
    
    function formatCurrency($value){
        return "Rp. ".number_format($value, 0);
    }

    //=============================== SET DATA ======================================//

    function submitTableData($table, $data) {
        $data['date_created'] = Date('Y-m-d G:i:s');
        $data['created_by'] = USER_ID;
        //die(print_r($table));
        $this->db->insert($table, $data);
    }    
    //=============================== REPORTS ======================================//
    
    function getDailyOrders($date) {
        $query = $this->DB->query("SELECT a.order_no, a.customer_name, a.date, a.down_payment, a.status, b.* from order_header a, order_detail b where a.id = b.id_header and a.date = '$date' order by a.customer_name");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReports($date) {
        $query = $this->DB->query("SELECT a.receive_date,b.product_id,b.tipe,b.qty,b.price,b.subtotal
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND a.receive_date='$date'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }
    
    // function getMonthlyIncome($datefrom,$dateto) {
        // $query = $this->DB->query("SELECT a.date,sum(a.total) as total
                                    // FROM order_header a
                                    // WHERE a.date BETWEEN '$datefrom' AND '$dateto' and a.status = 'CLOSED'
                                    // GROUP BY a.date");
        // if ($query->num_rows() > 0) {
            // $res = $query->result_array();
        // } else
            // $res = array();
        
        // return $res;
    // }
    function getDashboard($mon) {
        $query = $this->DB->query("SELECT a.date,a.closed_date,b.product_id,b.tipe,b.price,b.price*SUM(b.qty) as subtotal,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND MONTH(a.closed_date) = $mon AND YEAR(a.closed_date) = YEAR(now()) AND (a.status = 'CLOSED')
                                    GROUP BY date,product_id,tipe,a.status order by a.closed_date");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getMonthlyIncome($month) {
        $query = $this->DB->query("SELECT a.date,sum(a.total) as total
                                    FROM order_header a
                                    WHERE MONTH(a.date) = $month and YEAR(a.date) = YEAR(now()) AND a.status = 'CLOSED'
                                    GROUP BY a.date");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }
    
    function getOutstandingReport($datefrom,$dateto) {
        $query = $this->DB->query("SELECT a.id, a.order_no, a.date,a.customer_name,a.customer_phone,a.down_payment,(a.total-a.down_payment) as outstanding, a.total
                                    FROM order_header a
                                    WHERE a.date BETWEEN '$datefrom' AND '$dateto' and a.status = 'OPEN'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }
    
    function getCancelReport($datefrom,$dateto) {
        $query = $this->DB->query("SELECT a.id, a.order_no, a.date,a.cancel_date,a.customer_name,a.customer_phone,a.down_payment,a.total
                                    FROM order_header a
                                    WHERE a.cancel_date BETWEEN '$datefrom' AND '$dateto' and a.status = 'CANCEL'");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReportsAll() {
        $query = $this->DB->query("SELECT a.date,b.product_id,b.tipe,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND (a.status = 'CLOSED')
                                    GROUP BY DATE,product_id,tipe,a.status");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReportsAll2() {
        $query = $this->DB->query("SELECT a.date,b.product_id,b.tipe,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND (a.status = 'CANCEL')
                                    GROUP BY DATE,product_id,tipe,a.status");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReportsRange($datefrom,$dateto) {
        $query = $this->DB->query("SELECT a.date,a.closed_date,b.product_id,b.tipe,b.price,b.price*SUM(b.qty) as subtotal,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND a.closed_date BETWEEN '$datefrom' AND '$dateto' AND (a.status = 'CLOSED')
                                    GROUP BY date,product_id,tipe,a.status");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReportsRange2($datefrom,$dateto) {
        $query = $this->DB->query("SELECT a.date,b.product_id,b.tipe,b.price,b.price*SUM(b.qty) as subtotal,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND a.date BETWEEN '$datefrom' AND '$dateto' AND (a.status = 'CANCEL')
                                    GROUP BY date,product_id,tipe,a.status");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

    function getDailyReportsMonthly($month,$year) {
        $query = $this->DB->query("SELECT b.product_id,b.tipe,SUM(b.qty) AS qty,COUNT(*) AS total,a.status
                                    FROM order_header a, order_detail b 
                                    WHERE a.id=b.id_header AND MONTH(a.closed_date) = '$month' AND YEAR(a.closed_date) = '$year' AND (a.status = 'CLOSED' or a.status = 'CANCEL')
                                    GROUP BY product_id,tipe,a.status");
        if ($query->num_rows() > 0) {
            $res = $query->result_array();
        } else
            $res = array();
        
        return $res;
    }

}

?>
