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
//write message
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
			$my_action = $this->input->post('submit');
				if ($my_action == 'add') {
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
					$sql = "INSERT INTO message (`date`, `to`, `subject`, `from`, `from_id`, `message`,`description`,`image`,`document`,`remark`,`status_pesan`)
					VALUES ('".$today."', '".$this->input->post('penerima')."', '".$this->input->post('subject')."', '".$from."', '".$from_id."', '".$this->input->post('message')."','".$des."','','','','sent')";
					$this->db->query($sql);
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
					$msg .= "";
					$msg .= "";
					$msg .= "";
					$msg .= "	
							
							<p><em>Jl. Raya Merak KM. 115, Cilegon,  </em>
							<br /><em><strong>Banten,</strong>&ndash;<strong>  Indonesia - 42436 &nbsp;</strong> </em>
							<br /><em>Telepon.+62 254 570 555&nbsp; /7e71a11e </em><br />
							<em>Fax.&nbsp; +62 254 570 666 &nbsp; </em><br /><em>email: 
								itc@bcs-logistics.co.id </em><br /><em>From : $from</a></em></p>";
					$this->email->message($msg); 
					//$this->email->message('This is my message');
					$this->email->send(); 
					// echo $this->email->print_debugger();
					 //die;
					
					redirect('pesan');
					die;
				}
					elseif ($my_action == 'discard') {
					redirect('inbox/');
				}
			else 
				{
					$from =USER_NAME;
					$des ="-";
					$from_id =id;
					$today = date("Y-m-d H:i:s"); 
					$data = array(
					'message' =>$this->input->post('message'), 
					'to' =>$this->input->post('penerima'), 
					'subject' =>$this->input->post('subject')
					);
					$message =$this->input->post('message');
					$sql = "INSERT INTO message (`date`, `to`, `subject`, `from`, `from_id`, `message`,`description`,`image`,`document`,`remark`,`status_pesan`)
					VALUES ('".$today."', '".$this->input->post('penerima')."', '".$this->input->post('subject')."', '".$from."', '".$from_id."', '".$this->input->post('message')."','".$des."','','','','draft')";
					$this->db->query($sql);
				
					redirect('pesan');
				}
			}
   }
 // repply message

 //by draft 
   	function draft()
   {
		$id= $_GET['dari'];
		$this->load->library('lib_pagination');                         //Load the "lib_pagination" library
        $pg_config['sql']      = "SELECT * FROM message WHERE id='".$id."'";              //your SQL, don't add ";" in your SQL query
        $pg_config['per_page'] = 1;                                     //Display items per page
        $data = $this->lib_pagination->create_pagination($pg_config);   //Load function in "lib_pagination" libraryfor create pagination. 
	    $this->load->view('commons/header',$data);		
        $this->load->view('draft',$data);
        $this->load->view('commons/footer');
   
   }
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
