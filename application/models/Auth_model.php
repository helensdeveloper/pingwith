<?php
class Auth_model extends CI_Model
{

	function getClientIP()
	{
		if (isset($_SERVER)) {
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
				return $_SERVER["HTTP_X_FORWARDED_FOR"];
			if (isset($_SERVER["HTTP_CLIENT_IP"]))
				return $_SERVER["HTTP_CLIENT_IP"];
			return $_SERVER["REMOTE_ADDR"];
		}
		if (getenv('HTTP_X_FORWARDED_FOR'))
			return getenv('HTTP_X_FORWARDED_FOR');
		if (getenv('HTTP_CLIENT_IP'))
			return getenv('HTTP_CLIENT_IP');
		return getenv('REMOTE_ADDR');
	}

	function Register($fullname,$email,$hash,$phone,$token,$usercode,$role,$credit) {
		$data = array(
			'usercode'	=> $usercode,
			'name' 		=> $fullname,
			'email'		=> $email,
			'password'	=> $hash,
			'status'	=> 0,
			'phone'		=> $phone,
			'role'		=> $role,
			'valid'		=> $token,
			'credit'	=> $credit
		);
		$this->db->insert('users', $data);
	}

	function ImReseller($fullname,$email,$hash,$phone,$token,$usercode,$credit,$usercode2) {
		$data = array(
			'usercode'	=> $usercode,
			'name' 		=> $fullname,
			'email'		=> $email,
			'password'	=> $hash,
			'status'	=> 0,
			'phone'		=> $phone,
			'role'		=> 3,
			'valid'		=> $token,
			'regisby'	=> $usercode2,
			'credit'	=> $credit
		);
		$this->db->insert('users', $data);
	}

	function CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda) {
		$data = array(
			'userid'	=> $userid,
			'servicename'=> $servicename,
			'credit'	=> $tanda.$credit,
			'oldcredit'	=> $oldcredit,
			'newcredit'	=> $newcredit
		);
		$this->db->insert('credithistory', $data);
	}

	function CreditHistory1($resellercode,$servicename1,$credit,$creditreseller,$resellernew,$tanda) {
		$data = array(
			'userid'	=> $resellercode,
			'servicename'=> $servicename1,
			'credit'	=> $tanda.$credit,
			'oldcredit'	=> $creditreseller,
			'newcredit'	=> $resellernew
		);
		$this->db->insert('credithistory', $data);
	}

	function cek_login($email,$hash)
	{
		$result = $this->db->query("SELECT * FROM users WHERE email='$email' AND password='$hash' LIMIT 1");
		return $result;
	}

	function lastlogin($email,$ip,$time)
	{
		$this->db->set('login_ip', $ip);
		$this->db->set('last_login', $time);
        $this->db->where('email', $email);
        $this->db->update('users');
	}

	public function setBatchImport($batchImport) {
		$this->_batchImport = $batchImport;
	}

    // save data
	public function importData() {
		$data = $this->_batchImport;
		$this->db->insert_batch('qmess', $data);
	}
} ?>