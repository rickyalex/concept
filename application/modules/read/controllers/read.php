<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Read extends MX_Controller
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
		
		$this->meta = array(
            'activeMenu' => 'timeline',
            'activeTab' => 'timeline'
			 );
		
       	
	}
	
    public function index()
    {
		//$this->load->model('timeline');
		//
	
		$this->load->library('lib_pagination');                         //Load the "lib_pagination" library
        $pg_config['sql']      = "
								SELECT
								news.id,
								news.judul,
								news.artikel,
								news.gambar,
								news.youtube_url,
								news.tanggal,
								news.created,
								news.icon,
								news.frame,
								news.`status`,
								news.entry_by,
								news.entry_id,
								view_users.nama_lengkap,
								view_users.nama_divisi,
								view_users.foto AS foto_penulis
								FROM
								news
								LEFT OUTER JOIN view_users ON news.entry_id = view_users.id ORDER BY news.id DESC
								";              //your SQL, don't add ";" in your SQL query
        $pg_config['per_page'] = 3;                                     //Display items per page
        $data = $this->lib_pagination->create_pagination($pg_config);   //Load function in "lib_pagination" libraryfor create pagination. 
        $this->load->helper('xcrud');
        $meta = $this->meta;	

		$data['test'] = $this->db->get('info_terkini');		
		$this->load->view('commons/header',$data);		
        $this->load->view('read',$data);
        $this->load->view('commons/footer');
    }
	function baca_artikel(){
		$id= $_GET['news_id'];
		//$data['recent_news'] = $this->db->get('recent_news');
		//$data = $this->timeline->getArticle();
		$this->load->library('lib_pagination');                         //Load the "lib_pagination" library
        $pg_config['sql']      = "SELECT
								news_event.id,
								news_event.judul,
								news_event.artikel,
								news_event.gambar,
								news_event.youtube_url,
								news_event.tanggal,
								news_event.created,
								news_event.icon,
								news_event.frame,
								news_event.`status`,
								news_event.entry_by,
								news_event.entry_id,
								view_users.nama_lengkap AS author,
								view_users.nama_divisi,
								view_users.foto AS foto_penulis,
								news_event.`schedule`,
								news_event.`schedule2`,
								news_event.`schedule3`,
								news_event.des_schedule,
								news_event.pelaksanaan,
								news_event.des_pelaksanaan,
								news_event.sp_audit,
								news_event.des_sp_audit,
								news_event.ceklis,
								news_event.des_ceklis,
								news_event.ncr,
								news_event.des_ncr,
								news_event.ncr2,
								news_event.des_ncr2,
								news_event.ncr3,
								news_event.des_ncr3,
								news_event.ncr4,
								news_event.des_ncr4,
								news_event.ncr5,
								news_event.des_ncr5,
								news_event.ncr6,
								news_event.des_ncr6,
								news_event.ncr7,
								news_event.des_ncr7,
								news_event.ncr8,
								news_event.des_ncr8,
								news_event.ncr9,
								news_event.des_ncr9,
								news_event.ncr10,
								news_event.des_ncr10,
								news_event.ncr11,
								news_event.des_ncr11,
								news_event.rangkuman,
								news_event.rangkuman2,
								news_event.rangkuman3,
								news_event.rangkuman4,
								news_event.des_rangkuman
								FROM
								news_event
								LEFT OUTER JOIN view_users ON news_event.entry_id = view_users.id
								WHERE
								news_event.id='".$id."'";              //your SQL, don't add ";" in your SQL query
        $pg_config['per_page'] = 1;                                     //Display items per page
        $data = $this->lib_pagination->create_pagination($pg_config);   //Load function in "lib_pagination" libraryfor create pagination. 
		// $data['test']= $this->db->query('SELECT
// news_event.id,
// news_event.judul,
// news_event.artikel,
// news_event.gambar,
// news_event.`schedule`,
// news_event.des_schedule,
// news_event.pelaksanaan,
// news_event.des_pelaksanaan,
// news_event.sp_audit,
// news_event.des_sp_audit,
// news_event.ceklis,
// news_event.des_ceklis,
// news_event.ncr,
// news_event.des_ncr,
// news_event.ncr2,
// news_event.des_ncr2,
// news_event.ncr3,
// news_event.des_ncr3,
// news_event.ncr4,
// news_event.des_ncr4,
// news_event.ncr5,
// news_event.des_ncr5,
// news_event.ncr6,
// news_event.des_ncr6,
// news_event.ncr7,
// news_event.des_ncr7,
// news_event.ncr8,
// news_event.des_ncr8,
// news_event.ncr9,
// news_event.des_ncr9,
// news_event.ncr10,
// news_event.des_ncr10,
// news_event.ncr11,
// news_event.des_ncr11,
// news_event.rangkuman,
// news_event.des_rangkuman,
// news_event.youtube_url,
// news_event.tanggal,
// news_event.created,
// news_event.icon,
// news_event.frame,
// news_event.`status`,
// news_event.entry_by,
// news_event.entry_id,
// users.email,
// users.first_name,
// users.last_name
// FROM
// news_event
// INNER JOIN users ON users.id = news_event.entry_id
// ');
		$data['test']= $this->db->query('select `news_event`.`id` AS `id`,`news_event`.`judul` AS `judul`,`news_event`.`artikel` AS `artikel`,`news_event`.`gambar` AS `gambar`,`news_event`.`schedule` AS `schedule`,`news_event`.`schedule2` AS `schedule2`,`news_event`.`schedule3` AS `schedule3`,`news_event`.`schedule4` AS `schedule4`,`news_event`.`des_schedule` AS `des_schedule`,`news_event`.`pelaksanaan` AS `pelaksanaan`,`news_event`.`des_pelaksanaan` AS `des_pelaksanaan`,`news_event`.`sp_audit` AS `sp_audit`,`news_event`.`des_sp_audit` AS `des_sp_audit`,`news_event`.`ceklis` AS `ceklis`,`news_event`.`des_ceklis` AS `des_ceklis`,`news_event`.`ncr` AS `ncr`,`news_event`.`des_ncr` AS `des_ncr`,`news_event`.`ncr2` AS `ncr2`,`news_event`.`des_ncr2` AS `des_ncr2`,`news_event`.`ncr3` AS `ncr3`,`news_event`.`des_ncr3` AS `des_ncr3`,`news_event`.`ncr4` AS `ncr4`,`news_event`.`des_ncr4` AS `des_ncr4`,`news_event`.`ncr5` AS `ncr5`,`news_event`.`des_ncr5` AS `des_ncr5`,`news_event`.`ncr6` AS `ncr6`,`news_event`.`des_ncr6` AS `des_ncr6`,`news_event`.`ncr7` AS `ncr7`,`news_event`.`des_ncr7` AS `des_ncr7`,`news_event`.`ncr8` AS `ncr8`,`news_event`.`des_ncr8` AS `des_ncr8`,`news_event`.`ncr9` AS `ncr9`,`news_event`.`des_ncr9` AS `des_ncr9`,`news_event`.`ncr10` AS `ncr10`,`news_event`.`des_ncr10` AS `des_ncr10`,`news_event`.`ncr11` AS `ncr11`,`news_event`.`des_ncr11` AS `des_ncr11`,`news_event`.`rangkuman` AS `rangkuman`,`news_event`.`rangkuman2` AS `rangkuman2`,`news_event`.`rangkuman3` AS `rangkuman3`,`news_event`.`rangkuman4` AS `rangkuman4`,`news_event`.`des_rangkuman` AS `des_rangkuman`,`news_event`.`youtube_url` AS `youtube_url`,`news_event`.`tanggal` AS `tanggal`,`news_event`.`created` AS `created`,`news_event`.`icon` AS `icon`,`news_event`.`frame` AS `frame`,`news_event`.`status` AS `status`,`news_event`.`entry_by` AS `entry_by`,`news_event`.`entry_id` AS `entry_id` from `news_event` order by `news_event`.`id` desc limit 5');
        $this->load->view('commons/header');		
        $this->load->view('read_even',$data);
        $this->load->view('commons/footer');
	}		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
