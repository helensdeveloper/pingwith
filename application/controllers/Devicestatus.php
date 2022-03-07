<?php 
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Devicestatus extends REST_Controller
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

		$curl = curl_init();
		if ($valid == 1) {
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

		$curl = curl_init();
		if ($valid == 1) {
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
			$this->response(array('status' => 200, 'Message' => 'Your Devices Now '.$status ));
		}else{
			$this->response(array('status' => 404, 'Message' => 'Apikey was not found'));
		}
	}
} ?>