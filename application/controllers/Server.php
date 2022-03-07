<?php 
/**
  * 
  */
 class Server extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 	}

 	function index()
 	{
 		cek_sesi();
 		hasPermission([1]);
 		$this->load->view('panel/server');
 	}

 	function setserver()
	{
		$name = $this->input->post('name');
		$link = $this->input->post('link');
		$this->db->set('servername', $name);
		$this->db->set('link', $link);
		$this->db->where('id', 1);
		$this->db->update('server');
		$url=base_url('server');
		echo $this->session->set_flashdata('flash','donechange');
		redirect($url);
	}
 } ?>