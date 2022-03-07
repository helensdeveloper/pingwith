<?php 
$query = $this->db->get_where('identity', array('id' => 1));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$name = $row['name'];
	$url = $row['url'];
	$icon = $row['icon'];
}

$userid = $this->session->userdata('userid');
$query = $this->db->get_where('users', array('id' => $userid));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$fullname = $row['name'];
	$role = $row['role'];
	$usercode = $row['usercode'];
} ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$name?> | Users</title>
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
							<a href="<?=base_url().'api'?>" class="nav-link active">
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
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>API</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">API</li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<a href="<?=base_url().'api/generate'?>"><button class="btn btn-primary">Generate Token</button></a>
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">API Data</h3>
								</div>
								<div class="card-body">
									<table id="example2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>#</th>
												<th>API</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Your API Token :</td>
												<td><?=$usercode?></td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th>#</th>
												<th>API</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Send Without Attachment : <span style="color: red"><?=base_url().''?>api/send</span></h3>
								</div>
								<div class="card-body">
									<table id="example2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ParameterName</th>
												<th>Description</th>
												<th>ParameterValue</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>apikey</td>
												<td>apiKey is in the table above</td>
												<td><?=$usercode?></td>
											</tr>
											<tr>
												<td>mobile</td>
												<td>Your delivery destination begins with the country code</td>
												<td>919841xxxxx</td>
											</tr>
											<tr>
												<td>msg</td>
												<td>Message containt</td>
												<td>This is Test message</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="3">Example : <span><?=base_url().''?>api/send?<span style="color: red; background: yellow">apikey</span>=<?=$usercode?>&<span style="color: red; background: yellow">mobile</span>=9198410xxxxx&<span style="color: red; background: yellow">msg</span>=hallo</span></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Send With Attachment : <span style="color: red"><?=base_url().''?>api/send</span></h3>
								</div>
								<div class="card-body">
									<table id="example2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ParameterName</th>
												<th>Description</th>
												<th>ParameterValue</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>apikey</td>
												<td>apiKey is in the table above</td>
												<td><?=$usercode?></td>
											</tr>
											<tr>
												<td>mobile</td>
												<td>Your delivery destination begins with the country code</td>
												<td>919841xxxxx</td>
											</tr>
											<tr>
												<td>msg</td>
												<td>Message containt</td>
												<td>This is Test message</td>
											</tr>
											<tr>
												<td>mediaurl</td>
												<td>Your Media URL</td>
												<td>https://image.flaticon.com/icons/png/512/124/124034.png</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="3">Example : <span><?=base_url().''?>api/send?<span style="color: red; background: yellow">apikey</span>=<?=$usercode?>&<span style="color: red; background: yellow">mobile</span>=9198410xxxxx&<span style="color: red; background: yellow">msg</span>=hallo&</span><span style="color: red; background: yellow">mediaurl</span>=https://google.com</span></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Devices Status : <span style="color: red"><?=base_url().''?>api/devices</span></h3>
								</div>
								<div class="card-body">
									<table id="example2" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>ParameterName</th>
												<th>Description</th>
												<th>ParameterValue</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>apikey</td>
												<td>apiKey is in the table above</td>
												<td><?=$usercode?></td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="3">Example : <span><?=base_url().''?>api/devices?<span style="color: red; background: yellow">apikey</span>=<?=$usercode?></th>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">Make URL : <span style="color: red"><?=base_url().''?>api/makeurl</span></h3>
								</div>
								<div class="card-body">
									<video controls autoplay width="100%">
										<source src="<?=base_url().'video/capcutnew.mp4' ?>" type="video/mp4">
									</video>
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
	<script src="<?=base_url().'template/plugins/datatables/jquery.dataTables.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-responsive/js/dataTables.responsive.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-buttons/js/dataTables.buttons.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/jszip/jszip.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/pdfmake/pdfmake.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/pdfmake/vfs_fonts.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-buttons/js/buttons.html5.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-buttons/js/buttons.print.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/datatables-buttons/js/buttons.colVis.min.js'?>"></script>
	<script>
		$(function () {
			$("#example1").DataTable({
				"responsive": true, "lengthChange": false, "autoWidth": false,
				"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
			}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			$('#example2').DataTable({
				"paging": true,
				"lengthChange": false,
				"searching": false,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"responsive": true,
			});
		});
	</script>
	<script src="<?=base_url().'template/plugins/sweetalert2/sweetalert2.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/toastr/toastr.min.js'?>"></script>
	<script src="<?=base_url().'template/custom/user.js'?>"></script>
</body>
</html>