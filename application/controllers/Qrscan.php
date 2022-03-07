<?php 
/**
  * 
  */
class Qrscan extends CI_Controller
{

	function __construct()
	{
 		parent::__construct();
 		error_reporting(0);
	}

	function index()
	{
		cek_sesi();
		$this->load->view('panel/qrscan');
	}

	function enginestarted($id)
	{
		$query = $this->db->get_where('users', array('id' => $id));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/devices',
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
		$total =  $data->total;
		if ($total != 0) {
			$avail = json_decode($response, TRUE);
			foreach($avail['data'] as $row){
				$getdeviceid = $row["id"];
				$getdevicekey = $row["device_key"];
				$this->db->set('deviceid', $getdeviceid);
				$this->db->set('devicekey', $getdevicekey);
				$this->db->where('id', $id);
				$this->db->update('users');
				$url=base_url('qrscan');
				redirect($url);
			}
		} else {
			$token = substr(sha1(rand()), 0, 5);
			$dataarr = [
				"name" => $token
			];
			$datarest = json_encode($dataarr, true);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/devices',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => $datarest,
				CURLOPT_HTTPHEADER => [
					"Authorization: Bearer ".$usertoken,
					"Content-Type: application/json"
				],
			]);
			$response2 = curl_exec($curl);
			$data = json_decode($response2);
			$getdeviceid = $data->id;
			$getdevicekey = $data->device_key;
			$this->db->set('deviceid', $getdeviceid);
			$this->db->set('devicekey', $getdevicekey);
			$this->db->where('id', $id);
			$this->db->update('users');
			$settingarr = [
				"auto_read" => true,
				"auto_save_media" => true,
				"include_group_message" => true,
				"sync_story" => true,
				"sync_contact" => true
			];
			$settingrest = json_encode($settingarr, true);
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/setting',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "PATCH",
				CURLOPT_POSTFIELDS => $settingrest,
				CURLOPT_HTTPHEADER => [
					"Authorization: Bearer ".$usertoken,
					"Content-Type: application/json",
					"device-key: ".$getdevicekey
				],
			]);
			$response2 = curl_exec($curl);
			$url=base_url('qrscan');
			redirect($url);
		}
	}

	function scan()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/devices/'.$deviceid.'/pair',
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
		$curl2 = curl_init();
		curl_setopt_array($curl2, [
			CURLOPT_URL => $link.'/devices/'.$deviceid,
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
		$response2 = curl_exec($curl2);
		$getphone = json_decode($response2);
		$qrdetail = json_decode($response);
		$phone = $getphone->phone;
		$status = $qrdetail->status;
		$qr_code = $qrdetail->qr_code;
		if ($status == "IDLE") { ?>
			<center><h3 style="color: red">Waiting to Started</h3></center>
		<?php } else if ($status == "PAIRING") { ?>
			<center><h3 style="color: blue">Waiting to Scan</h3></center>
			<center><img src="<?=$qr_code?>"></center>
		<?php } else if ($status == "PAIRED") { ?>
			<center><h3 style="color: green">Whatsapp Connected</h3></center>
			<center><h3 style="color: green">on Whatsapp Number <?=$phone?></h3></center>
			<center><a class="btn btn-primary" href="<?=base_url().'qrscan/unpair'?>">Unpair</a></center>
		<?php }
	}

	function device()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/devices/'.$deviceid,
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
		$phone = $data->phone;
		$wa_name = $data->wa_name;
		$wa_version = $data->wa_version;
		$manufacture = $data->manufacture;
		$os_version = $data->os_version;
		$battery = $data->battery;
		$created_at = $data->created_at;
		$updated_at = $data->updated_at;
		if ($usertoken != NULL) { ?>
			<table class="table table-bordered">
				<tbody>
					<tr>
						<td style="width: 30%">Whatsapp Name</td>
						<td style="width: 70%"><span><?=$wa_name?></span></td>
					</tr>
					<tr>
						<td>Whatsapp Version</td>
						<td><span><?=$wa_version?></span></td>
					</tr>
					<tr>
						<td>Whatsapp Number</td>
						<td><span><?=$phone?></span></td>
					</tr>
					<tr>
						<td>Manufacture</td>
						<td><span><?=$manufacture?></span></td>
					</tr>
					<tr>
						<td>OS Version</td>
						<td><span><?=$os_version?></span></td>
					</tr>
					<tr>
						<td>Battery Level</td>
						<td><span><?=$battery?></span></td>
					</tr>
					<tr>
						<td>Created</td>
						<td><span><?=date('d-M-Y H:i:s',strtotime($created_at))?></span></td>
					</tr>
					<tr>
						<td>Updated</td>
						<td><span><?=date('d-M-Y H:i:s',strtotime($updated_at))?></span></td>
					</tr>
				</tbody>
			</table>
		<?php }
	}

	function unpair()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
		}

		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $link.'/devices/'.$deviceid.'/unpair',
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