<?php 
/**
  * 
  */
class Dashboard extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		cek_sesi();
		$this->load->view('panel/dashboard');
		error_reporting(0);
	}

	function count()
	{
		cek_sesi();
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$usertoken = $row['usertoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
		}

		$query = $this->db->get_where('server', array('id' => 1));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$link = $row['link'];
		}

		if ($deviceid != NULL) {
			$curl = curl_init();
			curl_setopt_array($curl, [
				CURLOPT_URL => $link.'/messages?limit=9999999999',
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
			$list = json_decode($response, TRUE)['data'];
			$total['READ'] = 0;
			$total['DELIVERED'] = 0;
			$total['PENDING'] = 0;
			$total['FAILED'] = 0;
			$total['PLAYED'] = 0;
			$total['SENT'] = 0;
			foreach ($list as $data) {
				if ($data['from_me'] == 'true') {
					$status = $data['status'];
					$total[$status]++;
				}
			}
			?>
			<div class="col-sm-3 border-right">
				<div class="description-block">
					<h5 class="description-header"><?=$total['READ']+$total['DELIVERED']+$total['PENDING']+$total['FAILED'] ?></h5>
					<span class="description-text">TOTAL</span>
				</div>
			</div>
			<div class="col-sm-2 border-right">
				<div class="description-block">
					<h5 class="description-header"><?=$total['PENDING']?></h5>
					<span class="description-text">PENDING</span>
				</div>
			</div>
			<div class="col-sm-2 border-right">
				<div class="description-block">
					<h5 class="description-header"><?=$total['DELIVERED']?></h5>
					<span class="description-text">DELIVERED</span>
				</div>
			</div>
			<div class="col-sm-2 border-right">
				<div class="description-block">
					<h5 class="description-header"><?=$total['READ']?></h5>
					<span class="description-text">READ</span>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="description-block">
					<h5 class="description-header"><?=$total['FAILED']?></h5>
					<span class="description-text">FAILED</span>
				</div>
			</div>
			<?php
		}
	}

	function QueueStatus()
	{
		$query = $this->db->get_where('queue', array('id' => 1));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$now = $row['now'];
			if ($now != NULL) { ?>
				<h3 class="widget-user-username">Queue Multiple Send Message</h3>
				<h5 class="widget-user-desc">Now : <?=$now?> | Next Queue : <?=$now + 1 ?></h5>
			<?php }
		}
	}
} ?>