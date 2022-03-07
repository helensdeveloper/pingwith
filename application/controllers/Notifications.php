<?php 
/**
  * 
  */
class Notifications extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		cek_sesi();
		hasPermission([1]);
		$this->load->view('panel/notif');
	}

	function savewa()
	{
		$status = $this->input->post('status');
		$gateway_apikey = $this->input->post('gateway_apikey');
		$query = $this->db->get_where('server', array('id' => 1));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$link = $row['link'];
		}

		$query = $this->db->get_where('users', array('usercode' => $gateway_apikey));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$devicekey = $row['devicekey'];
			$this->db->set('gateway_stat', $status);
			$this->db->set('gateway_apikey', $gateway_apikey);
			$this->db->set('gateway_link', $link);
			$this->db->set('gateway_token', $usertoken);
			$this->db->set('gateway_device', $devicekey);
			$this->db->where('gateway_id', 1);
			$this->db->update('gateway');
			$url=base_url('notifications');
			echo $this->session->set_flashdata('flash','wasave');
			redirect($url);
		}else{
			$url=base_url('notifications');
			echo $this->session->set_flashdata('flash','cancelwasave');
			redirect($url);
		}
	}

	function saveemail()
	{
		$status = $this->input->post('status');
		$smtp_protocol = $this->input->post('smtp_protocol');
		$smtp_host = $this->input->post('smtp_host');
		$smtp_from = $this->input->post('smtp_from');
		$smtp_email = $this->input->post('smtp_email');
		$smtp_password = $this->input->post('smtp_password');
		$smtp_secure = $this->input->post('smtp_secure');
		$port_no = $this->input->post('port_no');
		$this->db->set('smtp_stat', $status);
		$this->db->set('smtp_protocol', $smtp_protocol);
		$this->db->set('smtp_host', $smtp_host);
		$this->db->set('smtp_from', $smtp_from);
		$this->db->set('smtp_email', $smtp_email);
		$this->db->set('smtp_password', $smtp_password);
		$this->db->set('smtp_secure', $smtp_secure);
		$this->db->set('port_no', $port_no);
		$this->db->where('id', 1);
		$this->db->update('smtp_settings');
		$url=base_url('notifications');
		echo $this->session->set_flashdata('flash','wasave');
		redirect($url);
	}
} ?>