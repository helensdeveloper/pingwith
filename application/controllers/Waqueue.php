<?php 
/**
  * 
  */
 class Waqueue extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
 		$this->load->model('User_model', 'user_model');
 		error_reporting(0);
 	}

 	function index()
 	{
 		cek_sesi();
 		$userid = $this->session->userdata('userid');
 		$data['QueueList'] = $this->user_model->QueueList($userid);
 		$this->load->view('panel/queue',$data);
 	}

 	function count()
 	{
 		$userid = $this->session->userdata('userid');
 		$query = $this->db->query("SELECT * FROM qmess WHERE userid='$userid'");
 		if($query->num_rows()>0)
 		{
 			echo $query->num_rows();
 		}
 		else
 		{
 			echo 0;
 		}
 	}
 } ?>