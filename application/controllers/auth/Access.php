<?php 
/**
  * 
  */
class Access extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Sending_model', 'sending_model');
 		error_reporting(0);
	}

	function actived($id)
	{
		$valid = $id;
		$query=$this->db->get_where('users', array('valid' => $valid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Account is Already Active";
		$subject = "Account Active";
		$content = "<h1>Hi ".$name."</h1><span>Your Account is Already Active</span>";
		$this->db->set('status', 1);
		$this->db->set('valid', NULL);
		$this->db->where('valid', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('auth/login');
		echo $this->session->set_flashdata('flash','actived');
		redirect($url);
	}
} ?>