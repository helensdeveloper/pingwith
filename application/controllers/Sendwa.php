<?php 
/**
  * 
  */
class Sendwa extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model', 'auth_model');
		$this->load->model('Sending_model', 'sending_model');
		error_reporting(0);
	}

	function index()
	{
		cek_sesi();
		$this->load->view('panel/sendwa');
	}
	
	function submit()
	{
		$userid = $this->session->userdata('userid');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$usercode = $row['usercode'];
			$oldcredit = $row['credit'];
			$usertoken = $row['usertoken'];
			$refreshtoken = $row['refreshtoken'];
			$deviceid = $row['deviceid'];
			$devicekey = $row['devicekey'];
			$role = $row['role'];
		}
		$query=$this->db->get_where('server', array('id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$link = $row['link'];
		}
		$phone = $this->input->post('phone');
		$message = $this->input->post('message');
		$yesno = $this->input->post('yesno');
		if ($role == 1) {
			if ($yesno != 0) {
				$config['upload_path'] = './upload/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf';
				$config['encrypt_name'] = TRUE;
				$this->upload->initialize($config);
				if (!empty($_FILES['berkas']['name'])) {
					if ($this->upload->do_upload('berkas')) {
						$file = $this->upload->data();
						$filename = $file['file_name'];
						$fileup = $_SERVER['HTTP_HOST'] . "/app/upload/" .$filename;
						$ext = pathinfo($filename, PATHINFO_EXTENSION);
						$query = $this->db->get_where('filetype', array('ext' => $ext));
						if($query->num_rows() > 0){
							$row = $query->row_array();
							$typeupload = $row['filetype'];
						}else{
							$typeupload = "document";
						}
						$dataarr = [
							"to" => $phone,
							"message" => $message,
							"media_url" => "http://" . $fileup,
							"type" => $typeupload
						];
						$sendrest = json_encode($dataarr, true);
						$curl = curl_init();
						curl_setopt_array($curl, [
							CURLOPT_URL => $link.'/messages/send-media',
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => "",
							CURLOPT_MAXREDIRS => 10,
							CURLOPT_TIMEOUT => 30,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => "POST",
							CURLOPT_POSTFIELDS => $sendrest,
							CURLOPT_HTTPHEADER => [
								"Authorization: Bearer ".$usertoken,
								"Content-Type: application/json",
								"device-key: ".$devicekey
							],
						]);
						$response = curl_exec($curl);
						$url=base_url('sendwa');
						echo $this->session->set_flashdata('flash','sended');
						redirect($url);
					}
				} else {
					$url=base_url('sendwa');
					echo $this->session->set_flashdata('flash','errorupload');
					redirect($url);
				}
			} else {
				$sendarr = [
					"to" => $phone,
					"message" => $message
				];
				$sendrest = json_encode($sendarr, true);
				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_URL => $link.'/messages/send-text',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => $sendrest,
					CURLOPT_HTTPHEADER => [
						"Authorization: Bearer ".$usertoken,
						"Content-Type: application/json",
						"device-key: ".$devicekey
					],
				]);
				$response = curl_exec($curl);
				$url=base_url('sendwa');
				echo $this->session->set_flashdata('flash','sended');
				redirect($url);
			}
		} else {
			if ($oldcredit > 0) {
				if ($yesno != 0) {
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf';
					$config['encrypt_name'] = TRUE;
					$this->upload->initialize($config);
					if (!empty($_FILES['berkas']['name'])) {
						if ($this->upload->do_upload('berkas')) {
							$file = $this->upload->data();
							$filename = $file['file_name'];
							$fileup = $_SERVER['HTTP_HOST'] . "/app/upload/" .$filename;
							$ext = pathinfo($filename, PATHINFO_EXTENSION);
							$query = $this->db->get_where('filetype', array('ext' => $ext));
							if($query->num_rows() > 0){
								$row = $query->row_array();
								$typeupload = $row['filetype'];
							}else{
								$typeupload = "document";
							}
							$dataarr = [
								"to" => $phone,
								"message" => $message,
								"media_url" => "http://" . $fileup,
								"type" => $typeupload
							];
							$sendrest = json_encode($dataarr, true);
							$curl = curl_init();
							curl_setopt_array($curl, [
								CURLOPT_URL => $link.'/messages/send-media',
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_ENCODING => "",
								CURLOPT_MAXREDIRS => 10,
								CURLOPT_TIMEOUT => 30,
								CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
								CURLOPT_CUSTOMREQUEST => "POST",
								CURLOPT_POSTFIELDS => $sendrest,
								CURLOPT_HTTPHEADER => [
									"Authorization: Bearer ".$usertoken,
									"Content-Type: application/json",
									"device-key: ".$devicekey
								],
							]);
							$response = curl_exec($curl);
							$credit = 1;
							$newcredit = $oldcredit - $credit;
							$tanda = "-";
							$servicename = "Sending Message";
							$this->auth_model->CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda);
							$this->db->set('credit', $newcredit);
							$this->db->where('id', $userid);
							$this->db->update('users');
							$url=base_url('sendwa');
							echo $this->session->set_flashdata('flash','sended');
							redirect($url);
						}
					} else {
						$url=base_url('sendwa');
						echo $this->session->set_flashdata('flash','errorupload');
						redirect($url);
					}
				} else {
					$sendarr = [
						"to" => $phone,
						"message" => $message
					];
					$sendrest = json_encode($sendarr, true);
					$curl = curl_init();
					curl_setopt_array($curl, [
						CURLOPT_URL => $link.'/messages/send-text',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => "",
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 30,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => "POST",
						CURLOPT_POSTFIELDS => $sendrest,
						CURLOPT_HTTPHEADER => [
							"Authorization: Bearer ".$usertoken,
							"Content-Type: application/json",
							"device-key: ".$devicekey
						],
					]);
					$response = curl_exec($curl);
					$credit = 1;
					$newcredit = $oldcredit - $credit;
					$tanda = "-";
					$servicename = "Sending Message";
					$this->auth_model->CreditHistory($userid,$servicename,$credit,$oldcredit,$newcredit,$tanda);
					$this->db->set('credit', $newcredit);
					$this->db->where('id', $userid);
					$this->db->update('users');
					$url=base_url('sendwa');
					echo $this->session->set_flashdata('flash','sended');
					redirect($url);
				}
			} else {
				$url=base_url('sendwa');
				echo $this->session->set_flashdata('flash','lowcredit');
				redirect($url);
			}
		}
	}

	function MakeLink()
	{
		$userid = $this->session->userdata('userid');
		$query=$this->db->get_where('users', array('id' => $userid));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$phone = $row['phone'];
		}
		$query=$this->db->get_where('gateway', array('gateway_id' => 1));
		if ($query->num_rows()>0) {
			$row = $query->row_array();
			$gateway_stat = $row['gateway_link'];
			$gateway_link = $row['gateway_link'];
			$gateway_token = $row['gateway_token'];
			$gateway_device = $row['gateway_device'];
		}
		$config['upload_path'] = './upload/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp|pdf';
		$config['encrypt_name'] = TRUE;
		$this->upload->initialize($config);
		if (!empty($_FILES['fileURL']['name'])) {
			if ($this->upload->do_upload('fileURL')) {
				$file = $this->upload->data();
				$filename = $file['file_name'];
				$fileup = $_SERVER['HTTP_HOST'] . "/app/upload/" .$filename;
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$query = $this->db->get_where('filetype', array('ext' => $ext));
				if($query->num_rows() > 0){
					$row = $query->row_array();
					$typeupload = $row['filetype'];
				}else{
					$typeupload = "document";
				}
				$message = "Your Link Has Been Created\n\nLink : http://$fileup\nFileType : $typeupload";
				$this->sending_model->SendWhatsapp($phone,$message);
				$url=base_url('sendwa');
				echo $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Success!</h5>
					Media URL : http://'.$fileup.' <br>FileType : '.$typeupload.'.
					</div>');
				echo $this->session->set_flashdata('flash','makedone');
				redirect($url);
			}
		} else {
			$url=base_url('sendwa');
			echo $this->session->set_flashdata('flash','errorupload');
			redirect($url);
		}
	}

	function Queue()
	{
		$userid = $this->session->userdata('userid');
		$status = 0;
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fileURL', 'Upload File', 'callback_checkFileValidation');
		if($this->form_validation->run() == false) {

		} else {
			if(!empty($_FILES['fileURL']['name'])) {
				$extension = pathinfo($_FILES['fileURL']['name'], PATHINFO_EXTENSION);

				if($extension == 'csv'){
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif($extension == 'xlsx') {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				}
				$spreadsheet = $reader->load($_FILES['fileURL']['tmp_name']);
				$allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true, true);
				$arrayCount = count($allDataInSheet);
				$flag = 0;
				$createArray = array('Contact_No', 'Message', 'Media_url', 'FileType');
				$makeArray = array('Contact_No' => 'Contact_No', 'Message' => 'Message', 'Media_url' => 'Media_url');
				$SheetDataKey = array();
				foreach ($allDataInSheet as $dataInSheet) {
					foreach ($dataInSheet as $key => $value) {
						if (in_array(trim($value), $createArray)) {
							$value = preg_replace('/\s+/', '', $value);
							$SheetDataKey[trim($value)] = $key;
						} 
					}
				}
				$dataDiff = array_diff_key($makeArray, $SheetDataKey);
				if (empty($dataDiff)) {
					$flag = 1;
				}
				if ($flag == 1) {
					for ($i = 2; $i <= $arrayCount; $i++) {
						$addresses = array();
						$phone = $SheetDataKey['Contact_No'];
						$message = $SheetDataKey['Message'];
						$media = $SheetDataKey['Media_url'];

						$phone = filter_var(trim($allDataInSheet[$i][$phone]), FILTER_SANITIZE_STRING);
						$message = filter_var(trim($allDataInSheet[$i][$message]), FILTER_SANITIZE_STRING);
						$media = filter_var(trim($allDataInSheet[$i][$media]), FILTER_SANITIZE_STRING);
						$fetchData[] = array('phone' => $phone, 'mess' => $message, 'mediaurl' => $media, 'userid' => $userid, 'status' => $status);
					}   
					$data['dataInfo'] = $fetchData;
					$this->auth_model->setBatchImport($fetchData);
					$this->auth_model->importData();
				} else {
					echo "Please import correct file, did not match excel sheet column";
				}
				$url=base_url('sendwa');
				echo $this->session->set_flashdata('flash','sended');
				redirect($url);
			}              
		}
	}

	public function checkFileValidation($string) {
		$file_mimes = array('text/x-comma-separated-values', 
			'text/comma-separated-values', 
			'application/octet-stream', 
			'application/vnd.ms-excel', 
			'application/x-csv', 
			'text/x-csv', 
			'text/csv', 
			'application/csv', 
			'application/excel', 
			'application/vnd.msexcel', 
			'text/plain', 
			'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);
		if(isset($_FILES['fileURL']['name'])) {
			$arr_file = explode('.', $_FILES['fileURL']['name']);
			$extension = end($arr_file);
			if(($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['fileURL']['type'], $file_mimes)){
				return true;
			}else{
				$this->form_validation->set_message('checkFileValidation', 'Please choose correct file.');
				return false;
			}
		}else{
			$this->form_validation->set_message('checkFileValidation', 'Please choose a file.');
			return false;
		}
	}
} ?>