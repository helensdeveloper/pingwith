<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MUsers extends CI_Model
{

    public function getUsers($where)
    {
        return $this->db->get_where('users', $where);
    }
}
