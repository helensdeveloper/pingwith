<?php 
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Send extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('MUsers');
		$this->load->model('MHistoryCredit');
		$this->load->model('MServer');
	}

	public function index_post()
	{
		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}

		$apikey = $this->post('apikey');
		$mobile = $this->post("mobile");
		$msg = $this->post("msg");
		$mediaurl = $this->post("mediaurl");

		$query=$this->db->get_where('users', array('usercode' => $apikey));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$valid = 1;
			$userid = $row['id'];
			$usertoken = $row['usertoken'];
			$devicekey = $row['devicekey'];
			$deviceid = $row['deviceid'];
			$credit = $row['credit'];
			$user_role = $row['role'];
		}else{
			$valid = 0;
		}

		$ext = pathinfo($mediaurl, PATHINFO_EXTENSION);
		$query = $this->db->get_where('filetype', array('ext' => $ext));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$typeupload = $row['filetype'];
		}else{
			$typeupload = "document";
		}
		$curl = curl_init();
		if ($valid == 1) {
			if (!empty($mobile)) {
				if (!empty($msg)) {
					if ($user_role == 1) {
						if (!empty($mediaurl)) {
							$dataarr = [
								"to" => $mobile,
								"message" => $msg,
								"media_url" => $mediaurl,
								"type" => $typeupload
							];
							$sendrest = json_encode($dataarr, true);
							curl_setopt_array($curl, [
								CURLOPT_URL => $link."/devices/".$deviceid,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_POSTFIELDS => "",
								CURLOPT_HTTPHEADER => [
									"Authorization: Bearer ".$usertoken
								],
							]);
							$response = curl_exec($curl);
							$data = json_decode($response);
							$status = $data->status;
							if ($status == "PAIRED") {
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/messages/send-media",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $sendrest,
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken,
										"Content-Type: application/json",
										"device-key: ".$devicekey
									],
								]);
								$response = curl_exec($curl);
								$this->response([
									'status' => 200,
									'message' => 'Sending Successfull'
								], 200);
							}else{
								$this->response([
									'status' => 403,
									'message' => 'Device Not Paired'
								], 403);
							}
						}else{
							$dataarr = [
								"to" => $mobile,
								"message" => $msg
							];
							$sendrest = json_encode($dataarr, true);
							curl_setopt_array($curl, [
								CURLOPT_URL => $link."/devices/".$deviceid,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_POSTFIELDS => "",
								CURLOPT_HTTPHEADER => [
									"Authorization: Bearer ".$usertoken
								],
							]);
							$response = curl_exec($curl);
							$data = json_decode($response);
							$status = $data->status;
							if ($status == "PAIRED") {
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/messages/send-text",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $sendrest,
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken,
										"Content-Type: application/json",
										"device-key: ".$devicekey
									],
								]);
								$response = curl_exec($curl);
								$this->response([
									'status' => 200,
									'message' => 'Sending Successfull'
								], 200);
							}else{
								$this->response([
									'status' => 403,
									'message' => 'Device Not Paired'
								], 403);
							}
						}
					}else{
						if ($credit > 0) {
							if (!empty($mediaurl)) {
								$dataarr = [
									"to" => $mobile,
									"message" => $msg,
									"media_url" => $mediaurl,
									"type" => $typeupload
								];
								$sendrest = json_encode($dataarr, true);
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/devices/".$deviceid,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_POSTFIELDS => "",
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken
									],
								]);
								$response = curl_exec($curl);
								$data = json_decode($response);
								$status = $data->status;
								if ($status == "PAIRED") {
									curl_setopt_array($curl, [
										CURLOPT_URL => $link."/messages/send-media",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $sendrest,
										CURLOPT_HTTPHEADER => [
											"Authorization: Bearer ".$usertoken,
											"Content-Type: application/json",
											"device-key: ".$devicekey
										],
									]);
									$response = curl_exec($curl);
									$newcredit = $credit - 1;
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');

									$historyCredit = [
										'userid' => $userid,
										'servicename' => 'Sending Message',
										'credit' => -1,
										'oldcredit' => $credit,
										'newcredit' => $newcredit
									];
									$this->MHistoryCredit->createHistoryCredit($historyCredit);
									$this->response([
										'status' => 200,
										'message' => 'Sending Successfull'
									], 200);
								}else{
									$this->response([
										'status' => 403,
										'message' => 'Device Not Paired'
									], 403);
								}
							}else{
								$dataarr = [
									"to" => $mobile,
									"message" => $msg
								];
								$sendrest = json_encode($dataarr, true);
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/devices/".$deviceid,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_POSTFIELDS => "",
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken
									],
								]);
								$response = curl_exec($curl);
								$data = json_decode($response);
								$status = $data->status;
								if ($status == "PAIRED") {
									curl_setopt_array($curl, [
										CURLOPT_URL => $link."/messages/send-text",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $sendrest,
										CURLOPT_HTTPHEADER => [
											"Authorization: Bearer ".$usertoken,
											"Content-Type: application/json",
											"device-key: ".$devicekey
										],
									]);
									$response = curl_exec($curl);
									$newcredit = $credit - 1;
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');

									$historyCredit = [
										'userid' => $userid,
										'servicename' => 'Sending Message',
										'credit' => -1,
										'oldcredit' => $credit,
										'newcredit' => $newcredit
									];
									$this->MHistoryCredit->createHistoryCredit($historyCredit);
									$this->response([
										'status' => 200,
										'message' => 'Sending Successfull'
									], 200);
								}else{
									$this->response([
										'status' => 403,
										'message' => 'Device Not Paired'
									], 403);
								}
							}
						}else{
							$this->response([
								'status' => false,
								'message' => 'Insufficient Balance'
							], 403);
						}
					}
				}else{
					$this->response(array('status' => 404, 'Message' => 'Message Cant Empty'));
				}
			}else{
				$this->response(array('status' => 404, 'Message' => 'Phone Number Cant Empty'));
			}
		}else{
			$this->response(array('status' => 404, 'Message' => 'Apikey was not found'));
		}
	}

	public function index_get()
	{
		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}

		$apikey = $this->get('apikey');
		$mobile = $this->get("mobile");
		$msg = $this->get("msg");
		$mediaurl = $this->get("mediaurl");

		$query=$this->db->get_where('users', array('usercode' => $apikey));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$valid = 1;
			$userid = $row['id'];
			$usertoken = $row['usertoken'];
			$devicekey = $row['devicekey'];
			$deviceid = $row['deviceid'];
			$credit = $row['credit'];
			$user_role = $row['role'];
		}else{
			$valid = 0;
		}

		$ext = pathinfo($mediaurl, PATHINFO_EXTENSION);
		$query = $this->db->get_where('filetype', array('ext' => $ext));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$typeupload = $row['filetype'];
		}else{
			$typeupload = "document";
		}
		$curl = curl_init();
		if ($valid == 1) {
			if (!empty($mobile)) {
				if (!empty($msg)) {
					if ($user_role == 1) {
						if (!empty($mediaurl)) {
							$dataarr = [
								"to" => $mobile,
								"message" => $msg,
								"media_url" => $mediaurl,
								"type" => $typeupload
							];
							$sendrest = json_encode($dataarr, true);
							curl_setopt_array($curl, [
								CURLOPT_URL => $link."/devices/".$deviceid,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_POSTFIELDS => "",
								CURLOPT_HTTPHEADER => [
									"Authorization: Bearer ".$usertoken
								],
							]);
							$response = curl_exec($curl);
							$data = json_decode($response);
							$status = $data->status;
							if ($status == "PAIRED") {
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/messages/send-media",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $sendrest,
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken,
										"Content-Type: application/json",
										"device-key: ".$devicekey
									],
								]);
								$response = curl_exec($curl);
								$this->response([
									'status' => 200,
									'message' => 'Sending Successfull'
								], 200);
							}else{
								$this->response([
									'status' => 403,
									'message' => 'Device Not Paired'
								], 403);
							}
						}else{
							$dataarr = [
								"to" => $mobile,
								"message" => $msg
							];
							$sendrest = json_encode($dataarr, true);
							curl_setopt_array($curl, [
								CURLOPT_URL => $link."/devices/".$deviceid,
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "GET",
								CURLOPT_POSTFIELDS => "",
								CURLOPT_HTTPHEADER => [
									"Authorization: Bearer ".$usertoken
								],
							]);
							$response = curl_exec($curl);
							$data = json_decode($response);
							$status = $data->status;
							if ($status == "PAIRED") {
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/messages/send-text",
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "POST",
									CURLOPT_POSTFIELDS => $sendrest,
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken,
										"Content-Type: application/json",
										"device-key: ".$devicekey
									],
								]);
								$response = curl_exec($curl);
								$this->response([
									'status' => 200,
									'message' => 'Sending Successfull'
								], 200);
							}else{
								$this->response([
									'status' => 403,
									'message' => 'Device Not Paired'
								], 403);
							}
						}
					}else{
						if ($credit > 0) {
							if (!empty($mediaurl)) {
								$dataarr = [
									"to" => $mobile,
									"message" => $msg,
									"media_url" => $mediaurl,
									"type" => $typeupload
								];
								$sendrest = json_encode($dataarr, true);
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/devices/".$deviceid,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_POSTFIELDS => "",
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken
									],
								]);
								$response = curl_exec($curl);
								$data = json_decode($response);
								$status = $data->status;
								if ($status == "PAIRED") {
									curl_setopt_array($curl, [
										CURLOPT_URL => $link."/messages/send-media",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $sendrest,
										CURLOPT_HTTPHEADER => [
											"Authorization: Bearer ".$usertoken,
											"Content-Type: application/json",
											"device-key: ".$devicekey
										],
									]);
									$response = curl_exec($curl);
									$newcredit = $credit - 1;
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');

									$historyCredit = [
										'userid' => $userid,
										'servicename' => 'Sending Message',
										'credit' => -1,
										'oldcredit' => $credit,
										'newcredit' => $newcredit
									];
									$this->MHistoryCredit->createHistoryCredit($historyCredit);
									$this->response([
										'status' => 200,
										'message' => 'Sending Successfull'
									], 200);
								}else{
									$this->response([
										'status' => 403,
										'message' => 'Device Not Paired'
									], 403);
								}
							}else{
								$dataarr = [
									"to" => $mobile,
									"message" => $msg
								];
								$sendrest = json_encode($dataarr, true);
								curl_setopt_array($curl, [
									CURLOPT_URL => $link."/devices/".$deviceid,
									CURLOPT_RETURNTRANSFER => true,
									CURLOPT_ENCODING => "",
									CURLOPT_MAXREDIRS => 10,
									CURLOPT_TIMEOUT => 30,
									CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
									CURLOPT_CUSTOMREQUEST => "GET",
									CURLOPT_POSTFIELDS => "",
									CURLOPT_HTTPHEADER => [
										"Authorization: Bearer ".$usertoken
									],
								]);
								$response = curl_exec($curl);
								$data = json_decode($response);
								$status = $data->status;
								if ($status == "PAIRED") {
									curl_setopt_array($curl, [
										CURLOPT_URL => $link."/messages/send-text",
										CURLOPT_RETURNTRANSFER => true,
										CURLOPT_ENCODING => "",
										CURLOPT_MAXREDIRS => 10,
										CURLOPT_TIMEOUT => 30,
										CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
										CURLOPT_CUSTOMREQUEST => "POST",
										CURLOPT_POSTFIELDS => $sendrest,
										CURLOPT_HTTPHEADER => [
											"Authorization: Bearer ".$usertoken,
											"Content-Type: application/json",
											"device-key: ".$devicekey
										],
									]);
									$response = curl_exec($curl);
									$newcredit = $credit - 1;
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');

									$historyCredit = [
										'userid' => $userid,
										'servicename' => 'Sending Message',
										'credit' => -1,
										'oldcredit' => $credit,
										'newcredit' => $newcredit
									];
									$this->MHistoryCredit->createHistoryCredit($historyCredit);
									$this->response([
										'status' => 200,
										'message' => 'Sending Successfull'
									], 200);
								}else{
									$this->response([
										'status' => 403,
										'message' => 'Device Not Paired'
									], 403);
								}
							}
						}else{
							$this->response([
								'status' => false,
								'message' => 'Insufficient Balance'
							], 403);
						}
					}
				}else{
					$this->response(array('status' => 404, 'Message' => 'Message Cant Empty'));
				}
			}else{
				$this->response(array('status' => 404, 'Message' => 'Phone Number Cant Empty'));
			}
		}else{
			$this->response(array('status' => 404, 'Message' => 'Apikey was not found'));
		}
	}
} ?>