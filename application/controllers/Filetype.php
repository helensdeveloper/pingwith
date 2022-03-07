<?php 
/**
  * 
  */
 class Filetype extends CI_Controller
 {
 	
 	function __construct()
 	{
 		parent::__construct();
		$this->load->model('Type_model', 'type_model');
		error_reporting(0);
 	}

 	function index()
 	{
 		cek_sesi();
 		hasPermission([1]);
 		$data['GetFileType'] = $this->type_model->GetFileType();
 		$this->load->view('panel/filetype',$data);
 	}

 	function add()
 	{
 		$ext = $this->input->post('extension');
 		$ft = $this->input->post('filetype');
 		$query = $this->db->get_where('filetype', array('ext' => $ext));
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$status = 1;
		}else{
			$status = 0;
		}

		if ($status == 1) {
			$url = base_url().'filetype';
			echo $this->session->set_flashdata('flash','already');
			redirect($url);
		}else{
			$data = array(
				'ext'	=> $ext,
				'filetype'=> $ft
			);
			$this->db->insert('filetype', $data);
			$url = base_url().'filetype';
			echo $this->session->set_flashdata('flash','okay');
			redirect($url);
		}
 	}

 	function edit()
 	{
 		$id = $this->input->post('id');
 		$ext = $this->input->post('extension');
 		$ft = $this->input->post('filetype');
 		$this->db->set('ext', $ext);
		$this->db->set('filetype', $ft);
        $this->db->where('id', $id);
        $this->db->update('filetype');
 		$url = base_url().'filetype';
 		redirect($url);
 	}

 	function hapus()
 	{
 		$id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('filetype');
 		$url = base_url().'filetype';
 		redirect($url);
 	}
 } ?>