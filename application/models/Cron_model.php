<?php 
/**
  * 
  */
class Cron_model extends CI_Model
{

	function updateQueue()
	{
		$query = $this->db->query("SELECT * FROM qmess");
		if($query->num_rows()>0)
		{
			$jumlah = $query->num_rows();
		}
		else
		{
			$jumlah = 0;
		}

		$query = $this->db->get_where('queue', array('id' => 1));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$now = $row['now'];
		}

		$query = $this->db->get_where('server', array('id' => 1));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$link = $row['link'];
		}

		$max = 20;
		if ($jumlah > $max) {
			for ($i=0; $i < $max; $i++) { 
				$next = $now + $i;
				$query = $this->db->get_where('qmess', array('id' => $next));
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$messid = $row['id'];
					$phone = $row['phone'];
					$mess = $row['mess'];
					$mediaurl = $row['mediaurl'];
					$userid = $row['userid'];
					$status = $row['status'];
					$ext = pathinfo($mediaurl, PATHINFO_EXTENSION);
					$query = $this->db->get_where('filetype', array('ext' => $ext));
					if($query->num_rows() > 0){
						$row = $query->row_array();
						$typeupload = $row['filetype'];
					}else{
						$typeupload = "document";
					}
					$query = $this->db->get_where('users', array('id' => $userid));
					if($query->num_rows() > 0){
						$row = $query->row_array();
						$usertoken = $row['usertoken'];
						$refreshtoken = $row['refreshtoken'];
						$deviceid = $row['deviceid'];
						$devicekey = $row['devicekey'];
						$role = $row['role'];
						$oldcredit = $row['credit'];
						if ($role != 1) {
							if ($oldcredit > 0) {
								if (empty($mediaurl)) {
									$sendarr = [
										"to" => $phone,
										"message" => $mess
									];
									$sendrest = json_encode($sendarr, true);
									$curl = curl_init();
									curl_setopt_array($curl, [
										CURLOPT_URL => $link.'/messages/send-text',
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
									$credit = 1;
									$newcredit = $oldcredit - $credit;
									$tanda = "-";
									$servicename = "Sending Message";
									$data = array(
										'userid'	=> $userid,
										'servicename'=> $servicename,
										'credit'	=> $tanda.$credit,
										'oldcredit'	=> $oldcredit,
										'newcredit'	=> $newcredit
									);
									$this->db->insert('credithistory', $data);
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');
									$this->db->set('now', $next);
									$this->db->where('id', 1);
									$this->db->update('queue');
									$this->db->where('id', $messid);
									$this->db->delete('qmess');
								} else {
									$sendarr = [
										"to" => $phone,
										"message" => $mess,
										"media_url" => $mediaurl,
										"type" => $typeupload
									];
									$sendrest = json_encode($sendarr, true);
									$curl = curl_init();
									curl_setopt_array($curl, [
										CURLOPT_URL => $link.'/messages/send-media',
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
									$credit = 1;
									$newcredit = $oldcredit - $credit;
									$tanda = "-";
									$servicename = "Sending Message";
									$data = array(
										'userid'	=> $userid,
										'servicename'=> $servicename,
										'credit'	=> $tanda.$credit,
										'oldcredit'	=> $oldcredit,
										'newcredit'	=> $newcredit
									);
									$this->db->insert('credithistory', $data);
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');
									$this->db->set('now', $next);
									$this->db->where('id', 1);
									$this->db->update('queue');
									$this->db->where('id', $messid);
									$this->db->delete('qmess');
								}
							}else{
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->set('status', 1);
								$this->db->set('reason', 'Insufficient Balance');
								$this->db->where('id', $messid);
								$this->db->update('qmess');
							}
						} else {
							if (empty($mediaurl)) {
								$sendarr = [
									"to" => $phone,
									"message" => $mess
								];
								$sendrest = json_encode($sendarr, true);
								$curl = curl_init();
								curl_setopt_array($curl, [
									CURLOPT_URL => $link.'/messages/send-text',
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
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->where('id', $messid);
								$this->db->delete('qmess');
							} else {
								$sendarr = [
									"to" => $phone,
									"message" => $mess,
									"media_url" => $mediaurl,
									"type" => $typeupload
								];
								$sendrest = json_encode($sendarr, true);
								$curl = curl_init();
								curl_setopt_array($curl, [
									CURLOPT_URL => $link.'/messages/send-media',
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
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->where('id', $messid);
								$this->db->delete('qmess');
							}
						}
					}else{
						echo "User Not Found";
					}
				}else{
					echo "Qmess Not Found";
				}
			}
		}else{
			for ($i=0; $i < $jumlah; $i++) { 
				$next = $now + $i;
				$query = $this->db->get_where('qmess', array('id' => $next));
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$messid = $row['id'];
					$phone = $row['phone'];
					$mess = $row['mess'];
					$mediaurl = $row['mediaurl'];
					$userid = $row['userid'];
					$status = $row['status'];
					$ext = pathinfo($mediaurl, PATHINFO_EXTENSION);
					$query = $this->db->get_where('filetype', array('ext' => $ext));
					if($query->num_rows() > 0){
						$row = $query->row_array();
						$typeupload = $row['filetype'];
					}else{
						$typeupload = "document";
					}
					$query = $this->db->get_where('users', array('id' => $userid));
					if($query->num_rows() > 0){
						$row = $query->row_array();
						$usertoken = $row['usertoken'];
						$refreshtoken = $row['refreshtoken'];
						$deviceid = $row['deviceid'];
						$devicekey = $row['devicekey'];
						$role = $row['role'];
						$oldcredit = $row['credit'];
						if ($role != 1) {
							if ($oldcredit > 0) {
								if (empty($mediaurl)) {
									$sendarr = [
										"to" => $phone,
										"message" => $mess
									];
									$sendrest = json_encode($sendarr, true);
									$curl = curl_init();
									curl_setopt_array($curl, [
										CURLOPT_URL => $link.'/messages/send-text',
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
									$credit = 1;
									$newcredit = $oldcredit - $credit;
									$tanda = "-";
									$servicename = "Sending Message";
									$data = array(
										'userid'	=> $userid,
										'servicename'=> $servicename,
										'credit'	=> $tanda.$credit,
										'oldcredit'	=> $oldcredit,
										'newcredit'	=> $newcredit
									);
									$this->db->insert('credithistory', $data);
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');
									$this->db->set('now', $next);
									$this->db->where('id', 1);
									$this->db->update('queue');
									$this->db->where('id', $messid);
									$this->db->delete('qmess');
								} else {
									$sendarr = [
										"to" => $phone,
										"message" => $mess,
										"media_url" => $mediaurl,
										"type" => $typeupload
									];
									$sendrest = json_encode($sendarr, true);
									$curl = curl_init();
									curl_setopt_array($curl, [
										CURLOPT_URL => $link.'/messages/send-media',
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
									$credit = 1;
									$newcredit = $oldcredit - $credit;
									$tanda = "-";
									$servicename = "Sending Message";
									$data = array(
										'userid'	=> $userid,
										'servicename'=> $servicename,
										'credit'	=> $tanda.$credit,
										'oldcredit'	=> $oldcredit,
										'newcredit'	=> $newcredit
									);
									$this->db->insert('credithistory', $data);
									$this->db->set('credit', $newcredit);
									$this->db->where('id', $userid);
									$this->db->update('users');
									$this->db->set('now', $next);
									$this->db->where('id', 1);
									$this->db->update('queue');
									$this->db->where('id', $messid);
									$this->db->delete('qmess');
								}
							}else{
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->set('status', 1);
								$this->db->set('reason', 'Insufficient Balance');
								$this->db->where('id', $messid);
								$this->db->update('qmess');
							}
						} else {
							if (empty($mediaurl)) {
								$sendarr = [
									"to" => $phone,
									"message" => $mess
								];
								$sendrest = json_encode($sendarr, true);
								$curl = curl_init();
								curl_setopt_array($curl, [
									CURLOPT_URL => $link.'/messages/send-text',
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
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->where('id', $messid);
								$this->db->delete('qmess');
							} else {
								$sendarr = [
									"to" => $phone,
									"message" => $mess,
									"media_url" => $mediaurl,
									"type" => $typeupload
								];
								$sendrest = json_encode($sendarr, true);
								$curl = curl_init();
								curl_setopt_array($curl, [
									CURLOPT_URL => $link.'/messages/send-media',
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
								$this->db->set('now', $next);
								$this->db->where('id', 1);
								$this->db->update('queue');
								$this->db->where('id', $messid);
								$this->db->delete('qmess');
							}
						}
					}
				}
			}
		}
	}
} ?>