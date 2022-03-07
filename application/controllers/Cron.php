<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cron extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		// $this->load->library('input');
		$this->load->model('Cron_model', 'cron_model');
		error_reporting(0);
	}

	function updateQueue()
	{
		$this->cron_model->updateQueue();
	}

	public function CheckServerStatus()
	{
		$query = $this->db->get("server");
		foreach ($query->result() as $value) {
			$serverlink = $value->link;
			$id = $value->id;
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $serverlink,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_POSTFIELDS => "",
			]);

			$response = curl_exec($curl);
			$data = json_decode($response);
			$result = $data->greeting;
			if (!empty($result)) {
				$this->db->set('status', 1);
				$this->db->where('id', $id);
				$this->db->update('server');
			}else{
				$this->db->set('status', 0);
				$this->db->where('id', $id);
				$this->db->update('server');
			}
		}
	}
} ?>