<?php 
/**
  * 
  */
class Site extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		cek_sesi();
		hasPermission([1]);
		$this->load->view('panel/site');
	}

	function webmodif()
	{
		$websitename = $this->input->post('websitename');
		$this->db->set('name', $websitename);
		$this->db->where('id', 1);
		$this->db->update('identity');
		$url=base_url('site');
		echo $this->session->set_flashdata('flash','doneweb');
		redirect($url);
	}

	function urlmodif()
	{
		$websiteurl = $this->input->post('websiteurl');
		$this->db->set('url', $websiteurl);
		$this->db->where('id', 1);
		$this->db->update('identity');
		$url=base_url('site');
		echo $this->session->set_flashdata('flash','doneurl');
		redirect($url);
	}

	function iconmodif()
	{
		$config['upload_path'] = './template/dist/img/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!empty($_FILES['websiteicon']['name'])) {
			if ($this->upload->do_upload('websiteicon')) {
				$data = $this->upload->data();
				$filename = $data['file_name'];
				$this->db->set('icon', $filename);
				$this->db->where('id', 1);
				$this->db->update('identity');
				$url=base_url('site');
				echo $this->session->set_flashdata('flash','doneicon');
				redirect($url);
			}else{
				$url=base_url('site');
				redirect($url);
			}
		}else{
			$url=base_url('site');
			redirect($url);
		}
	}
} ?>