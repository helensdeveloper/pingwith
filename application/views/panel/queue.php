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
	$deviceid = $row['deviceid'];
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$name?> | Message Report</title>
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
							<a href="<?=base_url().'wareport'?>" class="nav-link active">
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
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Queue Message Report</h1>
							<span>After Message Success Sending Queue Deleted by System</span>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<?php 
									if ($deviceid != NULL) { ?>
										<table id="example" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>Queue</th>
													<th>Phone</th>
													<th>Status</th>
													<th>Date</th>
													<th>View</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($QueueList->result() as $q): ?>
													<tr>
														<td><?=$q->id?></td>
														<td><?=$q->phone?></td>
														<td><?=$q->status?></td>
														<td><?=date('d/m/Y',strtotime($q->datetime))?></td>
														<td>View</td>
													</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									<?php } ?>
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

	<script type="text/javascript"> 
		var start_date;
		var end_date;
		var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
			var dateStart = parseDateValue(start_date);
			var dateEnd = parseDateValue(end_date);
			var evalDate= parseDateValue(aData[3]);
			if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
				( isNaN( dateStart ) && evalDate <= dateEnd ) ||
				( dateStart <= evalDate && isNaN( dateEnd ) ) ||
				( dateStart <= evalDate && evalDate <= dateEnd ) )
			{
				return true;
			}
			return false;
		});
		function parseDateValue(rawDate) {
			var dateArray= rawDate.split("/");
			var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);
			return parsedDate;
		}

		$( document ).ready(function() {
			var $dTable = $('#example').DataTable({
				"dom": "<'row'<'col-sm-4'l><'col-sm-5' <'datesearchbox'>><'col-sm-3'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>"
			});

			$("div.datesearchbox").html('<div class="input-group"> <div class="input-group-addon"> <i class="glyphicon glyphicon-calendar"></i> </div><input type="text" class="form-control pull-right" id="datesearch" placeholder="Search by date range.."> </div>');
			document.getElementsByClassName("datesearchbox")[0].style.textAlign = "right";
			$('#datesearch').daterangepicker({
				autoUpdateInput: false
			});
			$('#datesearch').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
				start_date=picker.startDate.format('DD/MM/YYYY');
				end_date=picker.endDate.format('DD/MM/YYYY');
				$.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
				$dTable.draw();
			});
			$('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val('');
				start_date='';
				end_date='';
				$.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
				$dTable.draw();
			});
		});
	</script>
</body>
</html>