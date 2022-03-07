<?php 
$query = $this->db->get_where('identity', array('id' => 1));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$name = $row['name'];
	$url = $row['url'];
	$icon = $row['icon'];
}

$query = $this->db->get_where('server', array('id' => 1));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$link = $row['link'];
}

$userid = $this->session->userdata('userid');
$query = $this->db->get_where('users', array('id' => $userid));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$fullname = $row['name'];
	$role = $row['role'];
	$credit = $row['credit'];
	$usertoken = $row['usertoken'];
	$deviceid = $row['deviceid'];
	$multi = $row['multi'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$name?> | Send Message</title>
	<link rel="icon" type="image/x-icon" href="<?=base_url().'template/dist/img/'.$icon?>"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/fontawesome-free/css/all.min.css'?>">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/jqvmap/jqvmap.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/dist/css/adminlte.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/daterangepicker/daterangepicker.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/summernote/summernote-bs4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/toastr/toastr.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/select2/css/select2.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/bs-stepper/css/bs-stepper.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/dropzone/min/dropzone.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/toastr/toastr.min.css'?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
	<div class="wrapper">
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" data-widget="fullscreen" href="#" role="button">
						<i class="fas fa-expand-arrows-alt"></i>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?=base_url().'welcome/logout'?>" role="button">
						<i class="fas fa-sign-out-alt"></i>
					</a>
				</li>
			</ul>
		</nav>
		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<a href="<?=base_url().'Dashboard'?>" class="brand-link">
				<img src="<?=base_url().'template/dist/img/'.$icon?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
				<span class="brand-text font-weight-light"><?=$name?></span>
			</a>
			<div class="sidebar">
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<h3 class="img-circle elevation-3" style="color: black; background: white;">
							<?php
							$sub_kalimat = substr($fullname,0,1);
							echo $sub_kalimat; ?>
						</h3>
					</div>
					<div class="info">
						<a href="#" class="d-block"><?=$fullname?></a>
					</div>
				</div>
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
						<li class="nav-item">
							<a href="<?=base_url().'dashboard'?>" class="nav-link">
								<i class="nav-icon fas fa-tachometer-alt"></i>
								<p>
									Dashboard
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'sendwa'?>" class="nav-link">
								<i class="nav-icon fas fa-paper-plane"></i>
								<p>
									Send Message
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'wareport'?>" class="nav-link">
								<i class="nav-icon fas fa-envelope"></i>
								<p>
									Message Report
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'qrscan'?>" class="nav-link">
								<i class="nav-icon fas fa-qrcode"></i>
								<p>
									Scan QR
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'credithistory'?>" class="nav-link">
								<i class="nav-icon fas fa-money-bill"></i>
								<p>
									Credit History
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'changepass'?>" class="nav-link">
								<i class="nav-icon fas fa-lock"></i>
								<p>
									Change Password
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url().'api'?>" class="nav-link">
								<i class="nav-icon fas fa-code"></i>
								<p>
									Manage API
								</p>
							</a>
						</li>
						<?php 
						if ($role == 1) { ?>
							<li class="nav-header">ADMIN</li>
							<li class="nav-item">
							<a href="<?=base_url().'users'?>" class="nav-link">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Manage Users
								</p>
							</a>
							<li class="nav-item">
							<a href="<?=base_url().'server'?>" class="nav-link">
								<i class="nav-icon fas fa-server"></i>
								<p>
									Manage Server
								</p>
							</a>
							<li class="nav-item">
							<a href="<?=base_url().'notifications'?>" class="nav-link">
								<i class="nav-icon fas fa-bell"></i>
								<p>
									Manage Notifications
								</p>
							</a>
							<li class="nav-item">
							<a href="<?=base_url().'filetype'?>" class="nav-link">
								<i class="nav-icon fas fa-file"></i>
								<p>
									Manage Filetype
								</p>
							</a>
							<li class="nav-item">
							<a href="<?=base_url().'site'?>" class="nav-link">
								<i class="nav-icon fas fa-globe"></i>
								<p>
									Site Identity
								</p>
							</a>
						</li>
						<?php } else if ($role == 2) { ?>
							<li class="nav-header">RESELLER</li>
							<li class="nav-item">
							<a href="<?=base_url().'users'?>" class="nav-link">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Manage Users
								</p>
							</a>
						<?php }
						?>
					</ul>
				</nav>
			</div>
		</aside>
		<div class="content-wrapper">
			<br>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-sm-12">
							<div class="card card-primary card-tabs">
								<?php echo $this->session->flashdata('msg'); ?>
								<div class="card-header p-0 pt-1">
									<ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
										<li class="pt-2 px-3"><h3 class="card-title">Your Credit : <?=$credit?></h3></li>
										<li class="nav-item">
											<a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-home" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Sending Message</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Make Media URL</a>
										</li>
										<?php if ($multi == 1): ?>
											<li class="nav-item">
												<a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Multiple Sending</a>
											</li>
										<?php endif ?>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-two-tabContent">
										<div class="tab-pane fade show active" id="custom-tabs-two-home" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
											<?php 
											$curl = curl_init();
											curl_setopt_array($curl, [
												CURLOPT_URL => $link.'/devices/'.$deviceid,
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => "",
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 30,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => "GET",
												CURLOPT_POSTFIELDS => "",
												CURLOPT_HTTPHEADER => [
													"Authorization: Bearer ".$usertoken,
												],
											]);
											$response = curl_exec($curl);
											$data = json_decode($response);
											$status = $data->status;
											if ($deviceid != NULL) {
												if ($status != "PAIRED") { ?>
													<center><h3>Phone not Paired</h3></center>
													<center><a href="<?=base_url().'qrscan'?>" class="btn btn-app">
														<i class="fas fa-play"></i> Scan QR
													</a></center>
												<?php } else { ?>
													<form autocomplete="off" action="<?=base_url().'sendwa/submit'?>" method="POST" enctype="multipart/form-data">
														<div class="form-group">
															<label>Phone Number</label>
															<input type="text" name="phone" class="form-control" placeholder="Enter ...">
														</div>
														<div class="form-group">
															<label>Message</label>
															<textarea name="message" class="form-control" style="height: 200px;resize: none;"></textarea>
														</div>
														<div class="form-group">
															<label>Send Message With Media</label><br>
															<input type="radio" onclick="javascript:yesnoCheck();" name="yesno" value="1" id="yesCheck"> Enable<br>
															<input type="radio" onclick="javascript:yesnoCheck();" name="yesno" value="0" id="noCheck" checked> Disable<br>
														</div>
														<div class="form-group" id="ifYes" style="visibility:hidden">
															<label for="exampleInputFile">File input</label>
															<div class="input-group">
																<div class="custom-file">
																	<input type="file" name="berkas" class="custom-file-input" id="exampleInputFile">
																	<label class="custom-file-label" for="exampleInputFile">Choose file</label>
																</div>
																<div class="input-group-append">
																	<span class="input-group-text">Upload</span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<button class="btn btn-primary" type="submit">Submit</button>
														</div>
													</form>
												<?php }
											} else { ?>
												<center><h3>Your Account isn't Verified <br>Contact Administrator to Verified Your Account</h3></center>
											<?php }
											?>
										</div>
										<div class="tab-pane fade show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
											<?php 
											$curl = curl_init();
											curl_setopt_array($curl, [
												CURLOPT_URL => $link.'/devices/'.$deviceid,
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => "",
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 30,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => "GET",
												CURLOPT_POSTFIELDS => "",
												CURLOPT_HTTPHEADER => [
													"Authorization: Bearer ".$usertoken,
												],
											]);
											$response = curl_exec($curl);
											$data = json_decode($response);
											$status = $data->status;
											if ($deviceid != NULL) {
												if ($status != "PAIRED") { ?>
													<center><h3>Phone not Paired</h3></center>
													<center><a href="<?=base_url().'qrscan'?>" class="btn btn-app">
														<i class="fas fa-play"></i> Scan QR
													</a></center>
												<?php } else { ?>
													<hr>
													<a href="<?=base_url().'download/sample-xlsx.xlsx'?>"><button class="btn btn-success"><i class="fa fa-file-excel"> Sample .xlsx</i></button></a>
													<a href="<?=base_url().'download/sample-xls.xls'?>"><button class="btn btn-success"><i class="fa fa-file-excel"> Sample .xls</i></button></a>
													<hr>
													<form autocomplete="off" action="<?=base_url().'sendwa/Queue'?>" method="POST" enctype="multipart/form-data">
														<label for="exampleInputFile">File input</label>
														<div class="form-group">
															<div class="input-group">
																<div class="custom-file">
																	<input type="file" name="fileURL" class="custom-file-input" id="exampleInputFile">
																	<label class="custom-file-label" for="exampleInputFile">Choose file</label>
																</div>
																<div class="input-group-append">
																	<span class="input-group-text">Upload</span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<button class="btn btn-primary" type="submit">Submit</button>
														</div>
													</form>
												<?php }
											} else { ?>
												<center><h3>Your Account isn't Verified <br>Contact Administrator to Verified Your Account</h3></center>
											<?php }
											?>
										</div>
										<div class="tab-pane fade show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
											<?php 
											$curl = curl_init();
											curl_setopt_array($curl, [
												CURLOPT_URL => $link.'/devices/'.$deviceid,
												CURLOPT_RETURNTRANSFER => true,
												CURLOPT_ENCODING => "",
												CURLOPT_MAXREDIRS => 10,
												CURLOPT_TIMEOUT => 30,
												CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												CURLOPT_CUSTOMREQUEST => "GET",
												CURLOPT_POSTFIELDS => "",
												CURLOPT_HTTPHEADER => [
													"Authorization: Bearer ".$usertoken,
												],
											]);
											$response = curl_exec($curl);
											$data = json_decode($response);
											$status = $data->status;
											if ($deviceid != NULL) {
												if ($status != "PAIRED") { ?>
													<center><h3>Phone not Paired</h3></center>
													<center><a href="<?=base_url().'qrscan'?>" class="btn btn-app">
														<i class="fas fa-play"></i> Scan QR
													</a></center>
												<?php } else { ?>
													<form autocomplete="off" action="<?=base_url().'sendwa/MakeLink'?>" method="POST" enctype="multipart/form-data">
														<label for="exampleInputFile">File input</label>
														<div class="form-group">
															<div class="input-group">
																<div class="custom-file">
																	<input type="file" name="fileURL" class="custom-file-input" id="exampleInputFile">
																	<label class="custom-file-label" for="exampleInputFile">Choose file</label>
																</div>
																<div class="input-group-append">
																	<span class="input-group-text">Upload</span>
																</div>
															</div>
														</div>
														<div class="form-group">
															<button class="btn btn-primary" type="submit">Submit</button>
														</div>
													</form>
												<?php }
											} else { ?>
												<center><h3>Your Account isn't Verified <br>Contact Administrator to Verified Your Account</h3></center>
											<?php }
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php $this->load->view('panel/footer') ?>
		<aside class="control-sidebar control-sidebar-dark"></aside>
	</div>
	<script src="<?=base_url().'template/plugins/jquery/jquery.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/jquery-ui/jquery-ui.min.js'?>"></script>
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<script src="<?=base_url().'template/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/chart.js/Chart.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/sparklines/sparkline.js'?>"></script>
	<script src="<?=base_url().'template/plugins/jqvmap/jquery.vmap.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/jqvmap/maps/jquery.vmap.usa.js'?>"></script>
	<script src="<?=base_url().'template/plugins/jquery-knob/jquery.knob.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/moment/moment.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/daterangepicker/daterangepicker.js'?>"></script>
	<script src="<?=base_url().'template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/summernote/summernote-bs4.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'?>"></script>
	<script src="<?=base_url().'template/dist/js/adminlte.js'?>"></script>
	<script src="<?=base_url().'template/dist/js/demo.js'?>"></script>
	<script src="<?=base_url().'template/dist/js/pages/dashboard.js'?>"></script>
	<script src="<?=base_url().'template/plugins/bs-custom-file-input/bs-custom-file-input.min.js'?>"></script>
	<script type="text/javascript">
		function yesnoCheck() {
			if (document.getElementById('yesCheck').checked) {
				document.getElementById('ifYes').style.visibility = 'visible';
			}
			else document.getElementById('ifYes').style.visibility = 'hidden';
		}
	</script>
	<script src="<?=base_url().'template/plugins/sweetalert2/sweetalert2.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/toastr/toastr.min.js'?>"></script>
	<script src="<?=base_url().'template/custom/sendwa.js'?>"></script>
	<script>
		$(function () {
			bsCustomFileInput.init();
		});
	</script>
</body>
</html>