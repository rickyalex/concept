<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_sio extends MX_Controller
{
    	
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->helper('url');
		$this->load->helper('array');
		$this->load->library('form_validation');
	}
	
	function index()
	{

		$this->load->library('email');
		$this->email->set_newline("\r\n");
		
		//$db_dms = $this->load->database('default', TRUE); //dms
		$db_dms = $this->load->database('db2', TRUE); //dms
		//Nur Haryadi 01 February 2017 change database default(dms) to db2(master) to send mail sio
		//SIO ALREADY EXPIRED
		$sql = "SELECT
					sio_operator.sio_no,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.payroll_id) AS nama_operator,
					sio_operator.tipe,
					work_location.loc_name AS work_location,
					sio_operator.issued_by,
					sio_operator.signed_date,
					sio_operator.expire_date,
					(CASE WHEN (progress = False) THEN 'Expired' END) AS status_progress,
					(SELECT DATEDIFF(expire_date,NOW()) ) AS remaining_day,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.pic) AS pic
				FROM sio_operator LEFT JOIN work_location ON work_location.loc_code = sio_operator.work_location
				WHERE ((SELECT DATEDIFF(expire_date,NOW()) )  < 0) AND (sio_operator.renewal ='1')";    
		$res = $db_dms->query($sql);
		
		//SIO WILL EXPIRE IN 30 DAYS
		$sql2 = "SELECT
					sio_operator.sio_no,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.payroll_id) AS nama_operator,
					sio_operator.tipe,
					work_location.loc_name AS work_location,
					sio_operator.issued_by,
					sio_operator.signed_date,
					sio_operator.expire_date,
					(SELECT DATEDIFF(expire_date,NOW()) ) AS remaining_day,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.pic) AS pic
				FROM sio_operator LEFT JOIN work_location ON work_location.loc_code = sio_operator.work_location
				WHERE ((SELECT DATEDIFF(expire_date,NOW()) )  >=0 AND  (SELECT DATEDIFF(expire_date,NOW()) )<=30) AND (sio_operator.renewal ='1') AND progress = FALSE ORDER BY remaining_day";    
		$res2 = $db_dms->query($sql2);//AND progress = FALSE	
		
		//SIO ON PROGRESS
		$sql3 = "SELECT
					sio_operator.sio_no,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.payroll_id) AS nama_operator,
					sio_operator.tipe,
					work_location.loc_name AS work_location,
					sio_operator.issued_by,
					sio_operator.signed_date,
					sio_operator.expire_date,
					(CASE WHEN (progress = TRUE) THEN 'Progress' END) AS status_progress,
					(SELECT nama_karyawan FROM hris.m_karyawan WHERE hris.m_karyawan.payroll_id = sio_operator.pic) AS pic
				FROM sio_operator LEFT JOIN work_location ON work_location.loc_code = sio_operator.work_location
				WHERE progress = TRUE";    
		$res3 = $db_dms->query($sql3);	
		 
		$x=1;
		$array = array();
		$docs = "";
		$docs2 = ""; 

		$this->email->from('Document Management System', 'DMS');
		//seluruh pihak yang akan di kirim
		//$list = array('jemian@bcs-logistics.co.id','bagas.surya@bcs-logistics.co.id','ardiyana@bcs-logistics.co.id','supervisor.bcs@bluescopesteel.com','seni@bcs-logistics.co.id','fajarudin.bcs@gmail.com','zulkarnain@bcs-logistics.co.id','irwansyah@bcs-logistics.co.id','admin.crm@bcs-logistics.co.id','misri@bcs-logistics.co.id');	
		//$this->email->to($list);   
		$this->email->to('nur.haryadi@bcs-logistics.co.id'); 

		//$list2 = array('anggi.wijaya@bcs-logistics.co.id','bayu@bcs-logistics.co.id','bayu.herlambang@bcs-logistics.co.id','holili@bcs-logistics.co.id','ricky.alexander@bcs-logistics.co.id','nur.haryadi@bcs-logistics.co.id');
		//$this->email->cc($list2); 
		
		// if ($res->num_rows() > 0) {
			// //cc ke top management
			  
		// }
			
		$this->email->subject('[SIO Operator] - Document(s) Require Your Attention');
		$msg = "Dear All <br>";
		
		if ($res2->num_rows() > 0) {			
				//WILL BE EXPIRED
				foreach($res2->result_array() as $item2){		//$item2['status_progress'] change to $item2['remaining_day'] on line 140 Nur Haryadi 03 Februari 2017
					$docs2 .= "
					<tr>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['nama_operator']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['sio_no']."</td>
						<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['tipe']."</td>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['work_location']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['issued_by']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['signed_date']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['expire_date']."</td>
						<td width='5%'style='text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['remaining_day']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['pic']."</td>
					</tr>"; 
				}		
				$msg .= "<br><span style='font-size: 24px;'>SIO OPERATOR</span><br>";
				$msg .= "<br>This Document(s) below <b>will be expire less than 30 days </b>and require updating : <br><br>";
				$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
					<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Remaining Day(s)</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
				</tr>";
				$msg .= $docs2."</table><br>";
			
			if ($res->num_rows() > 0) {
			//expired SIO
			$msg .= "<br>This Document(s) below are <b> EXPIRED </b> and need to be followed up immediately : <br><br>";
			foreach($res->result_array() as $item){		
				$docs .= "
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['nama_operator']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['sio_no']."</td>
					<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['tipe']."</td>
					<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['work_location']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['issued_by']."</td>
					<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['signed_date']."</td>
					<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['expire_date']."</td>
					<td width='5%'style='color:red;text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['status_progress']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item['pic']."</td>
				</tr>"; //$item['remaining_day'] change to EXPIRED
			}	
			$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
			<tr>
				<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
				<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
				<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Remaining Day(s)</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
			</tr>";
			$msg .= $docs."</table><br>";
			}
			
			if ($res3->num_rows() > 0) {
				
				$msg .= "Also for your information, the list below contains SIO that are ON PROGRESS <br><br>";	
				
				//ON PROGRESS
				foreach($res3->result_array() as $item3){
					$docs3 .= "
					<tr>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['nama_operator']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['sio_no']."</td>
						<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['tipe']."</td>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['work_location']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['issued_by']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['signed_date']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['expire_date']."</td>
						<td width='5%'style='color:red;text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['status_progress']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['pic']."</td>
					</tr>"; 
				}			
				$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
					<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Status</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
				</tr>";
				$msg .= $docs3."</table><br>";
				
			}
			
			$msg .= "Please update the current status of the documents in the Document Management System (DMS) link below: <a href='http://10.2.2.32/dms'>http://10.2.2.32/dms</a>.<br>";
			$msg .= "If the message contents are incorrect, please further contact Legal Department. <br><br><br><br>";
			
			
		}elseif($res2->num_rows() > 0){
			$msg .= "<br>This Document(s) below <b>will be expire less than 30 days </b>and require updating : <br><br>";			
				
			//WILL BE EXPIRED
			foreach($res2->result_array() as $item2){
				$docs2 .= "
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['nama_operator']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['sio_no']."</td>
					<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['tipe']."</td>
					<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['work_location']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['issued_by']."</td>
					<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['signed_date']."</td>
					<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['expire_date']."</td>
					<td width='5%'style='color:red;text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['status_progress']."</td>
					<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item2['pic']."</td>
				</tr>"; 
			}			
			$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
			<tr>
				<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
				<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
				<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
				<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Status</b></td>
				<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
			</tr>";
			$msg .= $docs2."</table><br>";
			
			if ($res3->num_rows() > 0) {
				
				$msg .= "Also for your information, the list below contains SIO that are ON PROGRESS <br><br>";	
				
				//ON PROGRESS
				foreach($res3->result_array() as $item3){
					$docs3 .= "
					<tr>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['nama_operator']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['sio_no']."</td>
						<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['tipe']."</td>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['work_location']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['issued_by']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['signed_date']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['expire_date']."</td>
						<td width='5%'style='color:red;text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['status_progress']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['pic']."</td>
					</tr>"; 
				}			
				$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
					<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Status</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
				</tr>";
				$msg .= $docs3."</table><br>";
				
				$msg .= "Please update the current status of the documents in the Document Management System (DMS) link below: <a href='http://10.2.2.32/dms'>http://10.2.2.32/dms</a>.<br>";
				$msg .= "If the message contents are incorrect, please further contact Legal Department. <br><br><br><br>";
			}
		}
		elseif ($res3->num_rows() > 0) {
				
				$msg .= "For your information, the list below contains SIO that are ON PROGRESS <br><br>";	
				
				//ON PROGRESS
				foreach($res3->result_array() as $item3){
					$docs3 .= "
					<tr>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['nama_operator']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['sio_no']."</td>
						<td width='8%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['tipe']."</td>
						<td width='10%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['work_location']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['issued_by']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['signed_date']."</td>
						<td width='5%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['expire_date']."</td>
						<td width='5%'style='color:red;text-align:center;border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['status_progress']."</td>
						<td width='15%'style='border: 1px solid #cccccc;padding: 1px 1px 1px 1px;font-family: Arial, sans-serif; font-size: 14px;'>".$item3['pic']."</td>
					</tr>"; 
				}			
				$msg .= "<table style='border: 1px solid #cccccc;' cellpadding='0' cellspacing='0' width='100%'>
				<tr>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Name</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>SIO Number</b></td>
					<td width='8%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Type</b></td>
					<td width='10%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Work Location</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Issued By</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Sign Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Expired Date</b></td>
					<td width='5%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>Status</b></td>
					<td width='15%'style='border: 1px solid #cccccc;text-align:center; font-family: Arial, sans-serif; font-size: 14px;'><b>PIC</b></td> 
				</tr>";
				$msg .= $docs3."</table><br>";
				
				$msg .= "Please update the current status of the documents in the Document Management System (DMS) link below: <a href='http://10.2.2.32/dms'>http://10.2.2.32/dms</a>.<br>";
				$msg .= "If the message contents are incorrect, please further contact Legal Department. <br><br><br><br>";
				
		}
		else{
		//kalau tidak ada result
			die('no result');
			$this->fb->log('result not found');
			echo $this->email->print_debugger();
			die;
		}
		echo $msg;
		//$this->email->message($msg); 							
		//$result = $this->email->send(); 
		die('email sent');
	}
}

