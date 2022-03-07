<?php 
/**
  * 
  */
class Register extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth_model');
		$this->load->model('Sending_model', 'sending_model');
		error_reporting(0);
	}

	function index()
	{
		$this->load->view('auth/register');
	}

	function submit()
	{
		$fullname = ucwords($this->input->post('fullname'));
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$phonenumber = $this->input->post('phone');
		$token = substr(sha1(rand()), 0, 50);
		$hash = base64_encode(md5($password));
		$phone = preg_replace("/[^0-9]/", "", $phonenumber);
		$usercode = substr($fullname, -1).date('Hsd').$token;
		$role = 3;
		$credit = 0;
		$message = "Hi ".$fullname."\n\nHere is your activation link\n\nLink Activations : ".base_url().'actived='.$token;
		$subject = "Activations Account";
		$content = "<h1>Hi ".$fullname."</h1><span>Registration Successfull</span><br><span><a href=".base_url().'actived='.$token.">Klik to Activations</a></span>";
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

		$query = $this->db->query("SELECT * FROM users");
 		if($query->num_rows()>0)
 		{
 			if ($emailavail != 1) {
 				if ($phoneavail != 1) {
 					if ($this->input->post('password') == $this->input->post('repassword')) {
 						$this->auth_model->Register($fullname,$email,$hash,$phone,$token,$usercode,$role,$credit);
 						$this->sending_model->SendWhatsapp($phone,$message);
 						$this->sending_model->SendEmail($email,$subject,$content);
 						$url=base_url('auth/register');
 						echo $this->session->set_flashdata('flash','registerdone');
 						redirect($url);
 					} else {
 						$url=base_url('auth/register');
 						echo $this->session->set_flashdata('flash','pwdnotmatch');
 						redirect($url);
 					}
 				} else {
 					$url=base_url('auth/register');
 					echo $this->session->set_flashdata('flash','phoneavail');
 					redirect($url);
 				}
 			} else {
 				$url=base_url('auth/register');
 				echo $this->session->set_flashdata('flash','emailavail');
 				redirect($url);
 			}
 		}
 		else
 		{
 			if ($emailavail != 1) {
 				if ($phoneavail != 1) {
 					if ($this->input->post('password') == $this->input->post('repassword')) {
 						$data = array(
 							'usercode'	=> $usercode,
 							'name' 		=> $fullname,
 							'email'		=> $email,
 							'password'	=> $hash,
 							'status'	=> 0,
 							'phone'		=> $phone,
 							'role'		=> 1,
 							'valid'		=> $token,
 							'credit'	=> $credit
 						);
 						$this->db->insert('users', $data);
 						$this->sending_model->SendWhatsapp($phone,$message);
 						$this->sending_model->SendEmail($email,$subject,$content);
 						$url=base_url('auth/register');
 						echo $this->session->set_flashdata('flash','registerdone');
 						redirect($url);
 					} else {
 						$url=base_url('auth/register');
 						echo $this->session->set_flashdata('flash','pwdnotmatch');
 						redirect($url);
 					}
 				} else {
 					$url=base_url('auth/register');
 					echo $this->session->set_flashdata('flash','phoneavail');
 					redirect($url);
 				}
 			} else {
 				$url=base_url('auth/register');
 				echo $this->session->set_flashdata('flash','emailavail');
 				redirect($url);
 			}
 		}
 	}
} ?>