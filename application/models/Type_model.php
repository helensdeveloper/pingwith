<?php 
/**
  * 
  */
class Type_model extends CI_Model
{
	function GetFileType()
	{
		$result = $this->db->query("SELECT * FROM filetype");
		return $result;
	}
} ?>