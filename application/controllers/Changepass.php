<?php 
/**
  * 
  */
class Changepass extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		cek_sesi();
		$this->load->view('panel/changepass');
	}

	function submit()
	{
		$userid = $this->session->userdata('userid');
		$query = $this->db->get_where('users', array('id' => $userid));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$password = $row['password'];
		}

		$old = $this->input->post('old');
		$new = $this->input->post('new');
		$confirm = $this->input->post('confirm');
		$oldhash = base64_encode(md5($old));
		$newhash = base64_encode(md5($new));

		if ($oldhash != $password) {
			$url=base_url('changepass');
			echo $this->session->set_flashdata('flash','oldpasswordfail');
			redirect($url);
		} else {
			if ($new == $confirm) {
				$this->db->set('password', $newhash);
				$this->db->where('id', $userid);
				$this->db->update('users');
				$url=base_url('changepass');
				echo $this->session->set_flashdata('flash','changesuccess');
				redirect($url);
			} else {
				$url=base_url('changepass');
				echo $this->session->set_flashdata('flash','newpasswordfail');
				redirect($url);
			}
		}
		
	}
} ?>