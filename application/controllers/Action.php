<?php 
/**
  * 
  */
class Action extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Sending_model', 'sending_model');
		$this->load->model('Auth_model', 'auth_model');
		error_reporting(0);
	}

	function deactivelogin($id)
	{
		$valid = $id;
		$query=$this->db->get_where('users', array('id' => $valid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Account Disable by Admin";
		$subject = "Account Deactive";
		$content = "<h1>Hi ".$name."</h1><span>Your Account Disable by Admin</span>";
		$this->db->set('status', 0);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','deactivelogin');
		redirect($url);
	}

	function activelogin($id)
	{
		$valid = $id;
		$query=$this->db->get_where('users', array('id' => $valid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Account Enable by Admin";
		$subject = "Account Active";
		$content = "<h1>Hi ".$name."</h1><span>Your Account Enable by Admin</span>";
		$this->db->set('status', 1);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','activelogin');
		redirect($url);
	}

	function activegateway($id)
	{
		$pass = substr(sha1(rand()), 0, 25);
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
			$usertoken = $row['usertoken'];
			$refreshtoken = $row['refreshtoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$message = "Hi ".$name."\nYou Can Now Use the Gateway";
		$subject = "Active Gateway";
		$content = "<h1>Hi ".$name."</h1><span>You Can Now Use the Gateway</span>";
		if ($refreshtoken != NULL) {
			$refreshnarr = [
				"refresh_token" => $refreshtoken
			];
			$refreshrest = json_encode($refreshnarr, true);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/auth/refresh',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $refreshrest,
				CURLOPT_HTTPHEADER => [
					"Content-Type: application/json"
				],
			]);
			$response2 = curl_exec($curl);
			$data = json_decode($response2);
			$token =  $data->token;
			$refresh = $data->refreshToken;

			$this->db->set('gw_stat', 1);
			$this->db->set('usertoken', $token);
			$this->db->set('refreshtoken', $refresh);
			$this->db->where('id', $id);
			$this->db->update('users');
			$this->sending_model->SendWhatsapp($phone,$message);
			$this->sending_model->SendEmail($email,$subject,$content);
			$url=base_url('users');
			echo $this->session->set_flashdata('flash','activegateway');
			redirect($url);
		} else {
			//Make Account
			$regisarr = [
				"email" => $email,
				"password" => $pass
			];
			$regisrest = json_encode($regisarr, true);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/auth/register',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $regisrest,
				CURLOPT_HTTPHEADER => [
					"Content-Type: application/json"
				],
			]);
			$response = curl_exec($curl);

			$loginarr = [
				"email" => $email,
				"password" => $pass
			];
			$loginrest = json_encode($loginarr, true);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/auth/login',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $loginrest,
				CURLOPT_HTTPHEADER => [
					"Content-Type: application/json"
				],
			]);
			$response2 = curl_exec($curl);
			$data = json_decode($response2);
			$token =  $data->token;
			$refresh = $data->refreshToken;

			$this->db->set('gw_stat', 1);
			$this->db->set('usertoken', $token);
			$this->db->set('refreshtoken', $refresh);
			$this->db->set('gwpass', $pass);
			$this->db->where('id', $id);
			$this->db->update('users');
			$this->sending_model->SendWhatsapp($phone,$message);
			$this->sending_model->SendEmail($email,$subject,$content);
			$url=base_url('users');
			echo $this->session->set_flashdata('flash','activegateway');
			redirect($url);
		}
	}

	function deactivegateway($id)
	{
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\nYour Gateway Disable by Admin";
		$subject = "Deactive Gateway";
		$content = "<h1>Hi ".$name."</h1><span>Your Gateway Disable by Admin</span>";
		$this->db->set('gw_stat', NULL);
		$this->db->set('usertoken', NULL);
		$this->db->set('deviceid', NULL);
		$this->db->set('devicekey', NULL);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','deactivegateway');
		redirect($url);
	}

	function resetpassword($id)	
	{
		$token = substr(sha1(rand()), 0, 10);
		$hash = base64_encode(md5($token));
		$query=$this->db->get_where('users', array('id' => $id));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
		}
		$message = "Hi ".$name."\n\nYour Password = ".$token;
		$subject = "Password Reset";
		$content = "<h1>Hi ".$name."</h1><span>Your Password = ".$token."</span>";
		$this->db->set('password', $hash);
		$this->db->where('id', $id);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','newpassword');
		redirect($url);
	}

	function addcreditadmin()
	{
		$userid = $this->input->post('id');
		$credit = $this->input->post('credit');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
			$oldcredit = $row['credit'];
			$usercode = $row['usercode'];
		}

		$newcredit = $oldcredit + $credit;
		$tanda = "+";
		$servicename = "Credit Add";
		$message = "Hi ".$name."\n\nYou Get an Additional Credit of ".$credit."Credit";
		$subject = "Credit Added";
		$content = "<h1>Hi ".$name."</h1><span>You Get an Additional Credit of ".$credit."Credit</span>";
		$this->db->set('credit', $newcredit);
		$this->db->where('id', $userid);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$this->auth_model->CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','addcredit');
		redirect($url);
	}

	function reducecredit()
	{
		$userid = $this->input->post('id');
		$credit = $this->input->post('credit');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
			$oldcredit = $row['credit'];
			$usercode = $row['usercode'];
		}

		$newcredit = $oldcredit - $credit;
		$tanda = "-";
		$servicename = "Credit Reduce";
		$message = "Hi ".$name."\n\nYour Credit is Reduce by the Admin Amount ".$credit." Credit";
		$subject = "Credit Added";
		$content = "<h1>Hi ".$name."</h1><span>Your Credit is Reduce by the Admin Amount ".$credit." Credit</span>";
		$this->db->set('credit', $newcredit);
		$this->db->where('id', $userid);
		$this->db->update('users');
		$this->sending_model->SendWhatsapp($phone,$message);
		$this->sending_model->SendEmail($email,$subject,$content);
		$this->auth_model->CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda);
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','reducecredit');
		redirect($url);
	}

	function addcreditreseller()
	{
		$uid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $uid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$creditreseller = $row['credit'];
			$resellername = $row['name'];
			$reselleremail = $row['email'];
			$resellerphone = $row['phone'];
			$resellerid = $row['id'];
		}
		$userid = $this->input->post('id');
		$credit = $this->input->post('credit');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$email = $row['email'];
			$phone = $row['phone'];
			$name = $row['name'];
			$oldcredit = $row['credit'];
			$usercode = $row['usercode'];
		}
		if ($creditreseller >= $credit) {
			#Reseller Proses
			$resellernew = $creditreseller - $credit;
			$tanda = "-";
			$servicename1 = "Credit Transfer";
			$message1 = "Hi ".$resellername."\n\nYou Credit Transfer to ".$name." Amount ".$credit." Credit";
			$subject1 = "Credit Added";
			$content1 = "<h1>Hi ".$resellername."</h1><span>You Credit Transfer to ".$name."</span><br><span>Amount ".$credit." Credit</span>";
			$this->db->set('credit', $resellernew);
			$this->db->where('id', $uid);
			$this->db->update('users');
			$this->sending_model->SendWhatsapp1($resellerphone,$message1);
			$this->sending_model->SendEmail1($reselleremail,$subject1,$content1);
			$this->auth_model->CreditHistory1($resellerid,$servicename1,$credit,$creditreseller,$resellernew,$tanda);

			#CS Proses
			$newcredit = $oldcredit + $credit;
			$tanda = "+";
			$servicename = "Credit Add";
			$message = "Hi ".$name."\n\nYou Get an Additional Credit of ".$credit."Credit";
			$subject = "Credit Added";
			$content = "<h1>Hi ".$name."</h1><span>You Get an Additional Credit of ".$credit."Credit</span>";
			$this->db->set('credit', $newcredit);
			$this->db->where('id', $userid);
			$this->db->update('users');
			$this->sending_model->SendWhatsapp($phone,$message);
			$this->sending_model->SendEmail($email,$subject,$content);
			$this->auth_model->CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda);
			$url=base_url('users');
			echo $this->session->set_flashdata('flash','addcredit');
			redirect($url);
		}else{
			$url=base_url('users');
			echo $this->session->set_flashdata('flash','kurangbalance');
			redirect($url);
		}
	}

	function UserDeleted($id)
	{
		$query=$this->db->get_where('credithistory', array('userid' => $id));
		if ($query->num_rows()>0) {
			$this->db->where('userid', $id);
			$this->db->delete('credithistory');
		}
		$this->db->where('id', $id);
		$this->db->delete('users');
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','userdelete');
		redirect($url);
	}

	function editusers()
	{
		$id = $this->input->post('id');
		$phone = $this->input->post('phone');
		$address = $this->input->post('address');
		$this->db->set('phone', $phone);
		$this->db->set('address', $address);
		$this->db->where('id', $id);
		$this->db->update('users');
		$url=base_url('users');
		echo $this->session->set_flashdata('flash','editokay');
		redirect($url);
	}
} ?>