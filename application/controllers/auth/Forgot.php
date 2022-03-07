<?php
class Forgot extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Sending_model', 'sending_model');
		error_reporting(0);
	}

	function index()
	{
		$this->load->view('auth/forgot');
	}

	function submit()
	{
		$value = $this->input->post('value');
		$token = substr(sha1(rand()), 0, 10);
		$hash = base64_encode(md5($token));
		$query=$this->db->get_where('users', array('email' => $value));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			echo "Yes i Send Email";
		}else{
			$query=$this->db->get_where('users', array('phone' => $value));
			if ($query->num_rows()>0) {
				$row = $query->row_array();
				$phone = $row['phone'];
				$fullname = $row['name'];
				$message = "Hi ".$fullname."\n\nYour Password = ".$token;
				$this->sending_model->SendWhatsapp($phone,$message);
				$this->db->set('password', $hash);
				$this->db->where('phone', $phone);
				$this->db->update('users');
				$url = base_url().'auth/forgot';
				echo $this->session->set_flashdata('flash','success');
				redirect($url);
			}
			else{
				$url = base_url().'auth/forgot';
				echo $this->session->set_flashdata('flash','notfound');
				redirect($url);
			}
		}
	}
} ?>