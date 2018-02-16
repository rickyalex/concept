<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Car extends MX_Controller
{

     /**
	 * @author entol
	 * @see more  http://www.entol.net
	 * @email fudel.07@gmail.com 
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
		//$this->load->model('dn_model');
		$this->meta = array(
            //'activeMenu' => 'master',
            'activeTab' => 'news'
        );	
	}
	
    public function index()
    {
		//if(USER_ID==74){
			$this->load->helper('xcrud');
			$xcrud = xcrud_get_instance();
			$xcrud->table('car');
			$xcrud->unset_title();
			$xcrud->default_tab('Title');
			// $xcrud->columns('dept_id,periode,year,Open Ncr,lead_auditor,auditor,date_created,created_by');
			// $xcrud->change_type('periode','select','',array('values'=>array('-- Silahkan pilih --','JANUARI','FEBRUARI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER')));
			$xcrud->label('to','Report To');
			if(access_group=="D_18"){
				$xcrud->fields('created_by,date_created,updated_by,last_updated',true);
			}
			else{
				$xcrud->fields('status,created_by,date_created,updated_by,last_updated',true);
			}
			
			$xcrud->relation('to','view_dept','dept_code','dept_name');
			// $xcrud->relation('lead_auditor','view_auditor','id','nama');
			// $xcrud->relation('auditor','view_auditor','id','nama');
			// $xcrud->relation('dept_id','view_dept','dept_code','dept_name');
			// $xcrud->subselect('Open Ncr', "SELECT IFNULL(b.total_open,0)
											// FROM audit_internal a 
											// LEFT JOIN (SELECT audit_id, COUNT(id) AS total_open FROM ncr WHERE action_recommendation = 'OPEN' GROUP BY audit_id) b ON a.id = b.audit_id 
											// WHERE a.id = {id}");
			// $xcrud->order_by('id','desc');
					
			// $xcrud->unset_view();
			$xcrud->set_attr('reporter',array('id'=>'reporter'));
			$xcrud->set_attr('reporter',array('readOnly'=>'True'));
			$xcrud->pass_var('created_by', USER_NAME, 'create');
			$xcrud->pass_var('created_by', USER_NAME, 'create');
			$xcrud->pass_var('date_created', date('Y-m-d H:i:s'), 'create');
			$xcrud->pass_var('updated_by', USER_NAME, 'edit');			
			$xcrud->pass_var('last_updated', date('Y-m-d H:i:s'), 'edit');
					
			$checklist = $xcrud->nested_table('Car','id','car_detail','car_id'); //  sub_table begin
			$checklist->connection('root','c1l3g0nbcs321','qms'); //ENABLE IN LOCAL ONLY
			$checklist->unset_title();
			$checklist->columns('description,action,target,pic,result,created_by,date_created,updated_by,last_updated');
			$checklist->fields('id,car_id,created_by,date_created,updated_by,last_updated',true);
			
			// $checklist->change_type('attachment','image');
			// $checklist->pass_var('created_by', USER_NAME, 'create');
			// $checklist->pass_var('date_created', date('Y-m-d H:i:s'), 'create');
			// $checklist->pass_var('updated_by', USER_NAME, 'edit');			
			// $checklist->pass_var('last_updated', date('Y-m-d H:i:s'), 'edit');
					
			$data['content'] = $xcrud->render();
		//}
		//else{
		//	die('This module is under construction');
		//}
		
		$meta = $this->meta;			
		$this->load->view('commons/header',$meta);			
        $this->load->view('car', $data);
        $this->load->view('commons/footer');
    }
	
	function print_ncr(){
		$ncr_id= $_GET['ncr_id'];
		$b= "http://10.2.2.32:8080/jasperserver/";
		header("Location: ".$b."flow.html?_flowId=viewReportFlow&standAlone=true&_flowId=viewReportFlow&ParentFolderUri=%2Freports&reportUnit=%2Freports%2Fncr&id=".$ncr_id."&output=pdf");
		
	}
	
	function check_deadline(){
		
		$id = $this->input->post('id');
		
		$DB1 = $this->load->database('default', TRUE); //ims

		$query = $DB1->query("SELECT IF(EXISTS(SELECT * FROM ncr WHERE action_deadline < DATE(NOW()) AND id =".$id."), 1, 0) AS result");
			
		if ($query->num_rows() > 0) {
			$row = $query->row_array(); //running number
				
			//running number formatting
			$result = $row['result'];
			
			if($result==1){
				if(access_group=="D_18" && access=="admin") $result = 0;
				else $result = $result;
			}
		}
		else $result = 0;

		echo $result;
	}
	
	function get_frame(){
			
		//$DB1 = $this->load->database('default', TRUE); //ims
		//$DB2 = $this->load->database('db2', TRUE); 	//bcsuprchase_2015
		$data = $this->input->post('youtube_url');
		IF ($data != NULL);
		{
					$a='<div class="embed-responsive embed-responsive-16by9">  &lt;iframe class="embed-responsive-item" src="'.$data.'" frameborder="0" allowfullscreen&gt;&lt;/iframe></div>';
					
					echo htmlspecialchars_decode($a);
		}
	}	
		function get_icon(){
			
		$DB1 = $this->load->database('default', TRUE); //ims
		//$DB2 = $this->load->database('db2', TRUE); 	//bcsuprchase_2015
		$data = $this->input->post('youtube_url');
		IF ($data != NULL);
		{
					echo "fa fa-video-camera bg-maroon";
		}
	}
		function edit_post($edit_post){
				$this->load->helper('xcrud');
				$xcrud = xcrud_get_instance();
				$xcrud->table('news_event');
				$xcrud->table_name(' Add News & Event');
				$xcrud->default_tab('Title');
				
				$xcrud->unset_title();
				$xcrud->columns('id,judul,periode,artikel,gambar,tanggal,entry_by');
				$xcrud->fields('judul,periode,artikel,gambar,status,youtube_url,icon,frame,entry_by');
				$xcrud->fields('schedule,schedule2,schedule3,des_schedule', false, 'Schedule');
				$xcrud->fields('pelaksanaan,des_pelaksanaan', false, 'Pelaksanaan');
				$xcrud->fields('sp_audit,des_sp_audit', false, 'Pemberitahuan Audit');
				$xcrud->fields('ceklis,des_ceklis', false, 'Ceklis');
				$xcrud->fields('ncr,des_ncr,ncr2,des_ncr2,ncr3,des_ncr3,
								ncr4,des_ncr4,ncr5,des_ncr5,ncr6,des_ncr6,ncr7,des_ncr7,ncr8,des_ncr8,
								ncr9,des_ncr9,ncr10,des_ncr10,ncr11,des_ncr11', false, 'NCR');
				$xcrud->fields('rangkuman,rangkuman2,rangkuman3,rangkuman4,des_rangkuman', false, 'Rangkuman');
				
				$xcrud->button('http://10.2.2.32/qms/read/baca_artikel?news_id={id}', 'Preview', 'glyphicon glyphicon-zoom-in');
				//$xcrud->fields('description,image,document,remark', false, 'Attachment');
				//$xcrud->change_type('artikel', 'textarea'); hi, great work so far! image upload and table linking are “killer features” for your app.
				//$xcrud->change_type('gambar','image');
				$xcrud->change_type('gambar', 'image');
				$xcrud->change_type('schedule', 'image');
				$xcrud->change_type('schedule', 'image');
				$xcrud->change_type('schedule2', 'image');
				$xcrud->change_type('schedule3', 'image');
				$xcrud->change_type('pelaksanaan', 'image');
			    $xcrud->change_type('sp_audit', 'image');
				$xcrud->change_type('ceklis', 'image');
			    $xcrud->change_type('ncr', 'image');
			    $xcrud->change_type('ncr2', 'image');
			    $xcrud->change_type('ncr3', 'image');
			    $xcrud->change_type('ncr4', 'image');
			    $xcrud->change_type('ncr5', 'image');
			    $xcrud->change_type('ncr6', 'image');
			    $xcrud->change_type('ncr7', 'image');
			    $xcrud->change_type('ncr8', 'image');
			    $xcrud->change_type('ncr9', 'image');
			    $xcrud->change_type('ncr10', 'image');
			    $xcrud->change_type('ncr11', 'image');
				
			    $xcrud->change_type('rangkuman', 'image');
			    $xcrud->change_type('rangkuman2', 'image');
			    $xcrud->change_type('rangkuman3', 'image');
			    $xcrud->change_type('rangkuman4', 'image');
				$xcrud->order_by('id','desc');
				 $xcrud->benchmark();
				$xcrud->pass_var('entry_by',USER_NAME,'create');
				$xcrud->pass_var('entry_id',id,'create');
				 $hari= date ('w');
					 $tgl= date ('d');
					 $bln= date ('m');
					 $thn= date ('y');
						  switch($hari){
						   case 0 :{
								 $hari='Minggu';
								 } break;
						   case 1 :{
								 $hari='Senin';
								 } break;
						   case 2 :{
								 $hari='Selasa';
								 } break;
						   case 3 :{
								 $hari='Rabu';
								 } break;
							
						   case 4 :{
								 $hari='Kamis';
								 } break;
						   case 5 :{
								$hari='Jumat';
								 } break;
						   case 6 :{
								 $hari='Sabtu';
								 } break;
						 default:{
								$hari='Unknown';
								
								 }break;
						   
						    }
					 switch($bln){
						 
						   case 1 :{
								 $bln='Januari';
								 } break;
						   case 2 :{
								 $bln='Februari';
								 } break;
						   case 3 :{
								 $bln='Maret';
								 } break;
								
						   case 4 :{
								 $bln='April';
								 } break;
						   case 5 :{
								 $bln='Mei';
								 } break;
						  case 6 :{
								 $bln='Juni';
								} break;
						  case 7 :{
							 $bln='Juli';
								 } break;
						  case 8 :{
								 $bln='Agustus';
								 } break;
						  case 9 :{
								 $bln='September';
								 } break;
								
						  case 10 :{
								$bln='Oktober';
								 } break;
						   case 11 :{
								 $bln='November';
								 } break;
						  case 12 :{
								 $bln='Desember';
								 } break;
						 default:{
								 $bln='Unknown';
								
								 }break;
						   
						    }
				$tgl_bahasaindo =($hari. ", " .$tgl." " .$bln." "."20".$thn);
				$xcrud->pass_var('tanggal',$tgl_bahasaindo,'create');
				// echo USER_NAME ;
				//$xcrud->unset_limit();
				
				 $xcrud->set_attr('entry_by',array('ReadOnly'=>'True'));
				 $xcrud->set_attr('icon',array('ReadOnly'=>'True','id'=>'icon'));
				 $xcrud->set_attr('frame',array('ReadOnly'=>'True','id'=>'frame'));
				 $xcrud->set_attr('youtube_url',array('id'=>'youtube_url'));
				//echo id;
        $data['content'] = $xcrud->render('edit',$edit_post);
		
		
				$meta = $this->meta;			
				$this->load->view('commons/header',$meta);	
				
        $this->load->view('audit_internal', $data);
        $this->load->view('commons/footer');	
		$DB1 = $this->load->database('default', TRUE); 
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
