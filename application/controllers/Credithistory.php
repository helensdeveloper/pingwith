<?php 
/**
  * 
  */
class Credithistory extends CI_Controller
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
		$data['CreditHistory'] = $this->user_model->CreditHistory($userid);
		$data['AdminHistory'] = $this->user_model->AdminHistory();
		$this->load->view('panel/credithistory',$data);
	}
} ?>