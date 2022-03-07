<?php 
/**
  * 
  */
class Api extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		cek_sesi();
		$this->load->view('panel/api');
	}

	function generate()
	{
		$userid = $this->session->userdata('userid');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$fullname = $row['name'];
		}
		$token = substr(sha1(rand()), 0, 50);
		$usercode = substr($fullname, -1).date('Hsd').$token;
		$this->db->set('usercode', $usercode);
		$this->db->where('id', $userid);
		$this->db->update('users');
		$url=base_url('api');
		echo $this->session->set_flashdata('flash','sended');
		redirect($url);
	}
} ?>