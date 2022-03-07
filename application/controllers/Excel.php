<?php 
/**
  * 
  */
class Excel extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
	}

	function index()
	{
		$this->load->view('excel');
	}
} ?>