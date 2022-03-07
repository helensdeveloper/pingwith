<?php 
/**
  * 
  */
class Users extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('User_model', 'user_model');
		$this->load->model('Auth_model', 'auth_model');
		$this->load->model('Sending_model', 'sending_model');
		error_reporting(0);
	}

	function index()
	{
		cek_sesi();
		hasPermission([1,2]);
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usercode = $row['usercode'];
		}
		$data['AdminListUser'] = $this->user_model->AdminListUser();
		$data['ResellerListUser'] = $this->user_model->ResellerListUser($usercode);
		$data['Userhistory'] = $this->user_model->Userhistory();
		$this->load->view('panel/users',$data);
	}

	function add()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$access = $row['role'];
			$usercode2 = $row['usercode'];
			$subuser = $row['subuser'];
		} 
		$fullname = ucwords($this->input->post('fullname'));
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$role = $this->input->post('role');
		$credit = $this->input->post('credit');
		$password = substr(sha1(rand()), 0, 10);
		$hash = base64_encode(md5($password));
		$token = substr(sha1(rand()), 0, 50);
		$usercode = substr($fullname, -1).date('Hsd');
		$message = "Hi ".$fullname."\nYour Password : ".$hash."\n\nHere is your activation link\n\nLink Activations : ".base_url().'actived='.$token;
		$subject = "Activations Account";
		$content = "<h1>Hi ".$fullname."</h1><h1>Your Password : ".$hash."</h1><br><br><span>Registration Successfull</span><br><span><a href=".base_url().'actived='.$token.">Klik to Activations</a></span>";
		$fullname = $this->input->post('fullname');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$role = $this->input->post('role');
		$credit = $this->input->post('credit');
		$query=$this->db->get_where('users', array('email' => $email));
		if ($query->num_rows()>0) {
			$emailavail = 1;
		}else{
			$emailavail = 0;
		}
		$query=$this->db->get_where('users', array('phone' => $phone));
		if ($query->num_rows()>0) {
			$phoneavail = 1;
		}else{
			$phoneavail = 0;
		}

		if ($access == 1) {
			if ($emailavail != 1) {
				if ($phoneavail != 1) {
					$this->auth_model->Register($fullname,$email,$hash,$phone,$token,$usercode,$role,$credit);
					$this->sending_model->SendWhatsapp($phone,$message);
					$this->sending_model->SendEmail($email,$subject,$content);
					$url=base_url('users');
					echo $this->session->set_flashdata('flash','addsuccess');
					redirect($url);
				}else{
					$url=base_url('users');
					echo $this->session->set_flashdata('flash','phoneavail');
					redirect($url);
				}
			}else{
				$url=base_url('users');
				echo $this->session->set_flashdata('flash','emailavail');
				redirect($url);
			}
		}else{
			if ($emailavail != 1) {
				if ($phoneavail != 1) {
					$subusernew = $subuser + 1;
					$this->db->set('subuser', $subusernew);
					$this->db->where('id', $userid);
					$this->db->update('users');
					$this->auth_model->ImReseller($fullname,$email,$hash,$phone,$token,$usercode,$credit,$usercode2);
					$this->sending_model->SendWhatsapp($phone,$message);
					$this->sending_model->SendEmail($email,$subject,$content);
					$url=base_url('users');
					echo $this->session->set_flashdata('flash','addsuccess');
					redirect($url);
				}else{
					$url=base_url('users');
					echo $this->session->set_flashdata('flash','phoneavail');
					redirect($url);
				}
			}else{
				$url=base_url('users');
				echo $this->session->set_flashdata('flash','emailavail');
				redirect($url);
			}
		}
	}

	function makeclient($id)
	{
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Account has Become a Client";
		$subject = "Account Downgrade";
		$content = "<h1>Hi ".$name."</h1><span>Your Account has Become a Client</span>";
		$this->db->set('role', 3);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		redirect($url);
	}

	function makereseller($id)
	{
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Account has Become a Reseller";
		$subject = "Account Upgrade";
		$content = "<h1>Hi ".$name."</h1><span>Your Account has Become a Reseller</span>";
		$this->db->set('role', 2);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		redirect($url);
	}

	function disablemulti($id)
	{
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nMulti Message Disable From Your Account";
		$subject = "Account Upgrade";
		$content = "<h1>Hi ".$name."</h1><span>Multi Message Disable From Your Account</span>";
		$this->db->set('multi', 0);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		redirect($url);
	}

	function enablemulti($id)
	{
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nMulti Message Enable From Your Account";
		$subject = "Account Upgrade";
		$content = "<h1>Hi ".$name."</h1><span>Multi Message Enable From Your Account</span>";
		$this->db->set('multi', 1);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		redirect($url);
	}
} ?>