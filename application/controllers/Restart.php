<?php 
/**
  * 
  */
class Restart extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
	}

	function now()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$deviceid = $row['deviceid'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link."/devices/".$deviceid."/unpair",
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
		$url = base_url().'qrscan';
		redirect($url);
	}
} ?>