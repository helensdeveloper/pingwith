<?php
class Sending_model extends CI_Model
{
	function SendWhatsapp($phone,$message)
	{
		$query=$this->db->get_where('gateway', array('gateway_id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$gateway_stat = $row['gateway_stat'];
			$gateway_link = $row['gateway_link'];
			$gateway_token = $row['gateway_token'];
			$gateway_device = $row['gateway_device'];
		}
		$dataarr = [
			"to" => $phone,
			"message" => $message
		];
		$datarest = json_encode($dataarr, true);
		if ($gateway_stat == "Enable") {
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $gateway_link.'/messages/send-text',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $datarest,
				CURLOPT_HTTPHEADER => [
					"Authorization: Bearer ".$gateway_token,
					"Content-Type: application/json",
					"device-key: ".$gateway_device
				],
			]);

			$response = curl_exec($curl);
		}
	}

	function SendWhatsapp1($resellerphone,$message1)
	{
		$query=$this->db->get_where('gateway', array('gateway_id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$gateway_stat = $row['gateway_stat'];
			$gateway_link = $row['gateway_link'];
			$gateway_token = $row['gateway_token'];
			$gateway_device = $row['gateway_device'];
		}
		$dataarr = [
			"to" => $resellerphone,
			"message" => $message1
		];
		$datarest = json_encode($dataarr, true);
		if ($gateway_stat == "Enable") {
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $gateway_link.'/messages/send-text',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $datarest,
				CURLOPT_HTTPHEADER => [
					"Authorization: Bearer ".$gateway_token,
					"Content-Type: application/json",
					"device-key: ".$gateway_device
				],
			]);

			$response = curl_exec($curl);
		}
	}

	function SendEmail($email,$subject,$content)
	{
		$id = '1';
		$CekEmail = $this->db->get_where('smtp_settings', ['id' => $id])->row_array();
		$smtp_protocol	= $CekEmail['smtp_protocol'];
		$smtp_from	= $CekEmail['smtp_from'];
		$smtp_host	= $CekEmail['smtp_host'];
		$smtp_email	= $CekEmail['smtp_email'];
		$smtp_password	= $CekEmail['smtp_password'];
		$smtp_secure	= $CekEmail['smtp_secure'];
		$port_no	= $CekEmail['port_no'];
		$smtp_stat	= $CekEmail['smtp_stat'];

		$config = array(
			'protocol' 	=> $smtp_protocol, 
			'smtp_host' => $smtp_secure.'://'.$smtp_host, 
			'smtp_port' => $port_no, 
			'smtp_user' => $smtp_email, 
			'smtp_pass' => $smtp_password, 
			'mailtype' 	=> 'html', 
			'charset' 	=> 'utf-8' 
		);

		if ($smtp_stat == "Enable") {
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($smtp_user, $smtp_from);
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($content);
			$this->email->send();
		}
	}

	function SendEmail1($reselleremail,$subject1,$content1)
	{
		$id = '1';
		$CekEmail = $this->db->get_where('smtp_settings', ['id' => $id])->row_array();
		$smtp_protocol	= $CekEmail['smtp_protocol'];
		$smtp_from	= $CekEmail['smtp_from'];
		$smtp_host	= $CekEmail['smtp_host'];
		$smtp_email	= $CekEmail['smtp_email'];
		$smtp_password	= $CekEmail['smtp_password'];
		$smtp_secure	= $CekEmail['smtp_secure'];
		$port_no	= $CekEmail['port_no'];
		$smtp_stat	= $CekEmail['smtp_stat'];

		$config = array(
			'protocol' 	=> $smtp_protocol, 
			'smtp_host' => $smtp_secure.'://'.$smtp_host, 
			'smtp_port' => $port_no, 
			'smtp_user' => $smtp_email, 
			'smtp_pass' => $smtp_password, 
			'mailtype' 	=> 'html', 
			'charset' 	=> 'utf-8' 
		);

		if ($smtp_stat == "Enable") {
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");
			$this->email->from($smtp_user, $smtp_from);
			$this->email->to($reselleremail);
			$this->email->subject($subject1);
			$this->email->message($content1);
			$this->email->send();
		}
	}
} ?>