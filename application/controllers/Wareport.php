<?php 
/**
  * 
  */
class Wareport extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		error_reporting(0);
	}

	function index()
	{
		cek_sesi();
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$devicekey = $row['devicekey'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/messages?limit=999999?sort_by=created_at&order_by=desc',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_HTTPHEADER => [
				"Authorization: Bearer ".$usertoken,
				"device-key: ".$devicekey
			],
		]);
		$response = curl_exec($curl);
		$list = json_decode($response, true)['data'];
		$data['list'] = $list;
 		$this->load->view('panel/wareport',$data);
	}
} ?>