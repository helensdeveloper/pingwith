<?php 
/**
  * 
  */
class User_model extends CI_Model
{
	function AdminListUser()
	{
		$result = $this->db->query("SELECT * FROM users");
		return $result;
	}

	function ResellerListUser($usercode)
	{
		$result = $this->db->query("SELECT * FROM users WHERE regisby='$usercode'");
		return $result;
	}

	function CreditHistory($userid)
	{
		$result = $this->db->query("SELECT * FROM credithistory WHERE userid='$userid' ORDER BY transtime DESC");
		return $result;
	}

	function AdminHistory()
	{
		$result = $this->db->query("SELECT * FROM credithistory ORDER BY transtime DESC");
		return $result;
	}

	function Userhistory()
	{
		$result = $this->db->query("SELECT * FROM credithistory ORDER BY transtime DESC");
		return $result;
	}

	function QueueList($userid)
	{
		$result = $this->db->query("SELECT * FROM qmess WHERE userid='$userid'");
		return $result;
	}
} ?>