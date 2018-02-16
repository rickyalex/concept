<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pesan extends MX_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	
	function __construct()
	{
		parent::__construct();
		
		// check if user logged in 
		if (!$this->ion_auth->logged_in())
	  	{
			redirect('auth/login');
	  	}
		
		$this->load->helper('url');
		$this->load->library('form_validation');
		//$this->load->model('pesan');
		$this->meta = array(
            //'activeMenu' => 'master',
            'activeTab' => 'Pesan'
        );	
	}
	
    public function index()
    {
		
		$data['view_users'] = $this->db->get('view_users');		
		$this->load->view('commons/header',$meta);		
        $this->load->view('pesan', $data);
        $this->load->view('commons/footer');
    }
	function add()
   {
            
                $this->form_validation->set_rules('penerima', 'Receive', 'required');    
                $this->form_validation->set_rules('subject', 'subject', 'required');    
                
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button>', '</div>');
           
		   if ($this->form_validation->run() == False)
            {
            	$data['view_users'] = $this->db->get('view_users');		
				$this->load->view('commons/header',$meta);		
				$this->load->view('pesan', $data);
				$this->load->view('commons/footer');
            }else{
			// $path = set_realpath('uploads/pdf/');
			// $this->email->attach($path . 'yourfile.pdf');
			$from =USER_NAME;
			$des ="deskription";
			$from_id =id;
			$today = date("Y-m-d H:i:s"); 
            $data = array(
            'message' =>$this->input->post('message'), 
            'to' =>$this->input->post('penerima'), 
			'subject' =>$this->input->post('subject')
            );
			$message =$this->input->post('message');
            $sql = "INSERT INTO message (`date`, `to`, `subject`, `from`, `from_id`, `message`,`description`,`image`,`document`,`remark`)
			VALUES ('".$today."', '".$this->input->post('penerima')."', '".$this->input->post('subject')."', '".$from."', '".$from_id."', '".$this->input->post('message')."','".$des."','','','')";
			$this->db->query($sql);
			// $str =$this->input->post('message');
								// $length = strlen($str);
								// if ($length < 200) {
									// $str .= str_repeat('&nbsp', 500 - $length);
								// } else {
									// $str = substr($str, 0,500);
								// }; 
			$DB1 = $this->load->database('default', TRUE); //ims
			//kepada
			$query =$DB1->query("select email AS kepada from users where id='".$this->input->post('penerima')."'"); //'".$kepada."'
					if ($query->num_rows() > 0)
						{
						$row = $query->row_array();		
						$kepada = $row['kepada'];							
						}	
			$query =$DB1->query("select email AS dari from users where id='".$from_id."'"); //'".$kepada."'
					if ($query->num_rows() > 0)
						{
						$row = $query->row_array();		
						$dari = $row['dari'];							
						}	
			
		
			$this->email->set_newline("\r\n");
			$this->email->set_crlf( "\r\n" );
			$this->email->from("$dari",'Quality Management System');
			$this->email->to($kepada); 
			$this->email->subject($this->input->post('subject')); //$subject
			
			$msg .= "$message"; //$str
			$msg .= " ";
			$msg .= " ";
			$msg .= " ";
			$msg .= "	
					
					<br>Quality Management System</br>
					<br>BCS Logistics </br> <br>Have been sent by : $from";
			$this->email->message($msg); 
			//$this->email->message('This is my message');
			$this->email->send(); 
			// echo $this->email->print_debugger();
			// die;
			
			redirect('pesan');
			}
   }
   }
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
