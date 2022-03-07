<?php 
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Makeurl extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
	}

	public function index_post()
	{
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
			$status = $row['status'];
			$user_role = $row['role'];
		}else{
			$valid = 0;
		}
		if ($status == 1) {
			if ($valid == 1) {
				$uploaddir = './upload/';
				$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
				$filename = md5($_FILES['file']['name']);
				$uploadfile = $uploaddir . $filename . '.'.$ext;
				$newlink = $filename.'.'.$ext;

				if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
					$this->response([
						'status' => 200,
						'message' => 'Url Successfull Created',
						'URL' => base_url().'upload/'.$newlink
					], 200);  
				}
			}else{
				$this->response([
					'status' => 403,
					'message' => 'Apikey Invalid'
				], 403);
			}
		}else{
			$this->response([
				'status' => 403,
				'message' => 'Your Account Deactive'
			], 403);
		}
	}
} ?>