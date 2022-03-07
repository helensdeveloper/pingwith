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
	$credit = $row['credit'];
} ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$name?> | Credit History</title>
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
							<a href="<?=base_url().'credithistory'?>" class="nav-link active">
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
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Credit</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Credit</li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<?php 
							if ($role == 1) { ?>
								<div class="card">
									<div class="card-body">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th>Username</th>
													<th>Service Name</th>
													<th>Credit Status</th>
													<th>Transtime</th>
													<th>Old Credit</th>
													<th>New Credit</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($AdminHistory->result() as $ch): ?>
													<?php if ($ch->servicename != "Sending Message"): ?>
														<tr>
															<td></td>
															<td>
																<?php 
																$query = $this->db->get_where('users', array('id' => $ch->userid));
																if($query->num_rows() > 0){
																	$row = $query->row_array();
																	echo $row['name'];
																} ?>
															</td>
															<td><?=$ch->servicename?></td>
															<td><?=$ch->credit?></td>
															<td><?=date('d/M/Y H:i:s',strtotime($ch->transtime))?></td>
															<td><?=$ch->oldcredit?></td>
															<td><?=$ch->newcredit?></td>
														</tr>
													<?php endif ?>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<tr>
													<th>#</th>
													<th>Username</th>
													<th>Service Name</th>
													<th>Credit Status</th>
													<th>Transtime</th>
													<th>Old Credit</th>
													<th>New Credit</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							<?php } else { ?>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Your Credit : <span style="color: red"><?=$credit?></span></h3>
									</div>
									<div class="card-body">
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Service Name</th>
													<th>Credit Status</th>
													<th>Transtime</th>
													<th>Old Credit</th>
													<th>New Credit</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($CreditHistory->result() as $ch): ?>
													<tr>
														<td><?=$ch->servicename?></td>
														<td><?=$ch->credit?></td>
														<td><?=date('d-M-Y H:i:s',strtotime($ch->transtime))?></td>
														<td><?=$ch->oldcredit?></td>
														<td><?=$ch->newcredit?></td>
													</tr>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<tr>
													<th>Service Name</th>
													<th>Credit</th>
													<th>Transtime</th>
													<th>Old Credit</th>
													<th>New Credit</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							<?php } ?>
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
	<script>
		function ajaxcredit()
		{
			$.ajax({
				type: "GET",
				url: "<?php echo base_url().'Credithistory/ajaxcredit'?>",
				success: function(response){
					$("#ajaxcredit").html(response);
				}
			});
		}
	</script>
	<script type="text/javascript">
		setInterval('ajaxcredit();', 1);
	</script>
</body>
</html>