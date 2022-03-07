<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$url = base_url().'auth/login';
		redirect($url);
	}

	function logout()
	{
		$this->session->sess_destroy();
		$url=base_url('');
		redirect($url);
	}

	function testing()
	{
		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$regisarr = [
			"email" => "helensdeveloper@gmail.com",
			"password" => "Mayads1997"
		];
		$regisrest = json_encode($regisarr, true);
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/auth/login',
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
		$data = json_decode($response);
		echo $data->token;
	}
}
