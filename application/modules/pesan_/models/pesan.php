<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class pesan extends CI_Model
{
	
	
	public function __construct()
	{
		parent::__construct();

	}
	
	  function add($data)
            {
            $this->db->insert('message',$data);
            }
	

}
