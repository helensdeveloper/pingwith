<?php 
/**
  * 
  */
class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth_model');
		error_reporting(0);
	}

	function index()
	{
		cek_sesi_login();
		$this->load->view('auth/login');
	}

	function submit()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$hash = base64_encode(md5($password));
		$cek_login	= $this->auth_model->cek_login($email,$hash);
		if ($cek_login->num_rows() == 1) {
			$row = $cek_login->row();
			if ($row->status != 1) {
				$url=base_url('auth/login');
				echo $this->session->set_flashdata('flash','notactive');
				redirect($url);
			}else{
				$this->session->set_userdata(array(
					'logged'	=> 'true',
					'userid'    => $row->id,
					'role'     	=> $row->role
				));
				$url=base_url('dashboard');
				echo $this->session->set_flashdata('flash','valid');
				redirect($url);
			}
		} else {
			$url=base_url('auth/login');
			echo $this->session->set_flashdata('flash','invalid');
			redirect($url);
		}
	}
} ?>