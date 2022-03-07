<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MHistoryCredit extends CI_Model
{

    public function createHistoryCredit($data)
    {
        $this->db->insert('credithistory', $data);
    }
}
