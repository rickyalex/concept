<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dokumen_file extends MX_Controller
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
		//$this->load->model('dn_model');
		$this->meta = array(
            'activeMenu' => 'master',
            'activeTab' => 'supir'
        );	
	}
	
    public function index()
    {
        $this->load->helper('xcrud');

        $xcrud = xcrud_get_instance('dokumen_file');
        // $xcrud->table('dokumen_file');
		// $xcrud->table_name('Dokumen');
		// $xcrud->default_tab('Dokumen');
		
		
		// $xcrud->change_type('dokumen', 'file', '', array('not_rename'=>true));
		$xcrud->table('divisi');
		$xcrud->columns('nama_divisi');
		$xcrud->fields('kode_divisi, nama_divisi');
		$xcrud->table_name('Dokumen');
		$xcrud->unset_remove();
		
		
		//$xcrud->change_type('dokumen','file',array('width' => 2, 'height' => 2));
		//
		if ( access == "user") {
				$xcrud->where('divisi=',access_group);
				//$xcrud->where('divisi=',$all);
				$xcrud->unset_add();
				
				$xcrud->unset_edit();
								}
		if ( access == "viewer" ) {
				//$xcrud->where('divisi=',access_group);
				//$xcrud->where('divisi=',$all);
				$xcrud->unset_add();
				$xcrud->unset_edit();
								}
		//$section ="<section class="content-header"><h1>Profile<small>Profile</small></h1><ol class="breadcrumb"></section>";
		//$data['section'];		// $xcrud->unset_add();
				//$xcrud->unset_pagination();
				//$xcrud->unset_print();
				//$xcrud->unset_limitlist();
				// $xcrud->unset_csv();
				// $xcrud->label('nama','Nama Dokumen');
				// $xcrud->label('dokumen','Dokumen');
				// //$xcrud->unset_remove();
				// //$xcrud->unset_search();
				 // $xcrud->benchmark();
				//$xcrud->unset_limit();
		$xcrud->set_attr('kode_divisi',array('ReadOnly'=>'True'));
		$xcrud->set_attr('nama_divisi',array('ReadOnly'=>'True'));
				 // $xcrud->set_attr('last_name',array('disabled'=>'True'));
				 // $xcrud->set_attr('default_group',array('ReadOnly'=>'True'));
				// $xcrud->change_type('foto','image',array('width' => 2, 'height' => 2));
				$xcrud->unset_title();
				//$xcrud->relation('divisi','divisi','kode_divisi','nama_divisi');
				
		
		$dokumen = $xcrud->nested_table('Dokumen','kode_divisi','dokumen_file','divisi'); //  sub_table begin
		$dokumen->connection('root','c1l3g0nbcs321','qms'); //ENABLE IN LOCAL ONLY
		$dokumen->unset_title();
		$dokumen->columns('nomor, divisi, nama, deskripsi, dokumen');
		$dokumen->change_type('dokumen', 'file', '', array('not_rename'=>true));
		//$dokumen->fields('kode_divisi, nama_divisi');
				
				// $news_event = xcrud_get_instance('news_event');
				// $news_event->table('news_event');
				// //$news_event->table_name(' Add News & Event');
				// $news_event->unset_title();
				// $news_event->default_tab('Title');
				// $news_event->columns('id,judul,periode,artikel,gambar,tanggal,entry_by');
				// $news_event->fields('judul,periode,artikel,gambar,status,icon,frame,entry_by');
				// $news_event->fields('schedule,schedule2,schedule3,des_schedule', false, 'Schedule');
				// $news_event->fields('pelaksanaan,des_pelaksanaan', false, 'Pelaksanaan');
				// $news_event->fields('sp_audit,des_sp_audit', false, 'Pemberitahuan Audit');
				// $news_event->fields('ceklis,des_ceklis', false, 'Ceklis');
				// $news_event->fields('ncr,des_ncr,ncr2,des_ncr2,ncr3,des_ncr3,
								// ncr4,des_ncr4,ncr5,des_ncr5,ncr6,des_ncr6,ncr7,des_ncr7,
								// ncr9,des_ncr9,ncr10,des_ncr10,ncr11,des_ncr11', false, 'NCR');
				// $news_event->unset_remove();
				// $news_event->unset_edit();
				// $news_event->unset_add();
				// $news_event->fields('rangkuman,rangkuman2,rangkuman3,rangkuman4,des_rangkuman', false, 'Rangkuman');
				// $base_url=base_url(); 
				// $dd="read/baca_artikel?news_id={id}"; 
				// $url =($base_url."".$dd);
				// //$tgl_bahasaindo =($hari. ", " .$tgl." " .$bln." "."20".$thn);
				// //echo $base_url;
				// $news_event->button($url, 'Preview', 'glyphicon glyphicon-zoom-in');
			    // $data['a'] = $news_event->render();
				$data['content'] = $xcrud->render();
				$meta = $this->meta;			
				$this->load->view('commons/header',$meta);	
				
        $this->load->view('dokumen_file', $data);
        $this->load->view('commons/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
