<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MServer extends CI_Model
{

    public function getServer($where)
    {
        return $this->db->get_where('server', $where);
    }
}
