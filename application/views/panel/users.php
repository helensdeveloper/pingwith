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
							<a href="<?=base_url().'users'?>" class="nav-link active">
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
							<a href="<?=base_url().'users'?>" class="nav-link active">
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
							<h1>Users</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Users</li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">User Data <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
										<i class="fa fa-plus"> Add Users</i>
									</button></h3>
								</div>
								<div class="card-body">
									<?php 
									if ($role == 1) { ?>
										<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Fullname</th>
													<th>Email & Mobile</th>
													<th>Active</th>
													<th>Gateway</th>
													<th>Date</th>
													<th>Role</th>
													<th>Credit</th>
													<th>Sub User</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($AdminListUser->result() as $lu): ?>
													<tr>
														<td><?=$lu->name?></td>
														<td>
															<?=$lu->email?><br>
															<?=$lu->phone?>
														</td>
														<td>
															<?php 
															if ($lu->status == 1) { ?>
															 	<button type="button" class="btn btn-success btn-block btn-sm"><i class="fa fa-check"></i></button>
															<?php } else { ?>
															 	<button type="button" class="btn btn-danger btn-block btn-sm"><i class="fa fa-times"></i></button>
															<?php }
															?>
														</td>
														<td>
															<?php 
															if ($lu->gw_stat != NULL) { ?>
															 	<button type="button" class="btn btn-success btn-block btn-sm"><i class="fa fa-check"></i></button>
															<?php } else { ?>
															 	<button type="button" class="btn btn-danger btn-block btn-sm"><i class="fa fa-times"></i></button>
															<?php }
															?>
														</td>
														<td><?=date('d/m/Y',strtotime($lu->created))?></td>
														<td>
															<?php 
															if ($lu->role == 1) {
															 	echo "<span style='color: green'>ADMIN</span>";
															} else if ($lu->role == 2) {
															 	echo "<span style='color: red'>RESELLER</span>";
															} else {
															 	echo "<span style='color: blue'>CLIENT</span>";
															}
															?>
														</td>
														<td>
															<?php 
															if ($lu->credit < 1) {
																echo "<span style='color: red'>".number_format($lu->credit)."</span>";
															} else {
																echo "<span style='color: green'>".number_format($lu->credit)."</span>";
															}
															?>
														</td>
														<td>
															<?php 
															if ($lu->subuser < 1) {
															 	echo "<span style='color: red'>".number_format($lu->subuser)."</span>";
															} else {
															 	echo "<span style='color: green'>".number_format($lu->subuser)."</span>";
															}
															?>
														</td>
														<td>
															<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
																Action
															</button>
															<div class="dropdown-menu">
																<?php 
																if ($lu->status != 1) { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/activelogin/'.$lu->id?>">Active Login</a>
																<?php } else { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/deactivelogin/'.$lu->id?>">Deactived Login</a>
																<?php }
																?>
																<?php 
																if ($lu->gw_stat == NULL) { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/activegateway/'.$lu->id?>">Active Gateway</a>
																<?php } else { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/deactivegateway/'.$lu->id?>">Deactived Gateway</a>
																<?php }
																?>
																<a class="dropdown-item" href="<?=base_url().'action/resetpassword/'.$lu->id?>">Reset Password</a>
																<a class="dropdown-item" data-toggle="modal" data-target="#CreditAddAdmin<?=$lu->id?>">Add Credit</a>
																<a class="dropdown-item" data-toggle="modal" data-target="#ReduceCredit<?=$lu->id?>">Reduce Credit</a>
																<div class="dropdown-divider"></div>
																<a class="dropdown-item" data-toggle="modal" data-target="#ShowHistory<?=$lu->id?>">Show History</a>
																<?php 
																if ($lu->multi == 1) {?>
																 	<a class="dropdown-item" href="<?=base_url().'users/disablemulti/'.$lu->id?>">Disable Multi Message</a>
																<?php } else if ($lu->multi != 1) { ?>
																 	<a class="dropdown-item" href="<?=base_url().'users/enablemulti/'.$lu->id?>">Enable Multi Message</a>
																<?php } ?>
																<?php 
																if ($lu->role == 2) {?>
																 	<a class="dropdown-item" href="<?=base_url().'users/makeclient/'.$lu->id?>">Make Client</a>
																<?php } else if ($lu->role == 3) { ?>
																 	<a class="dropdown-item" href="<?=base_url().'users/makereseller/'.$lu->id?>">Make Reseller</a>
																<?php } ?>
																<a class="dropdown-item" data-toggle="modal" data-target="#EditUser<?=$lu->id?>">Edit User</a>
																<a class="dropdown-item" href="<?=base_url().'action/UserDeleted/'.$lu->id?>">Delete User</a>
															</div>
														</td>
													</tr>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<tr>
													<th>Fullname</th>
													<th>Email & Mobile</th>
													<th>Active</th>
													<th>Gateway</th>
													<th>Date</th>
													<th>Role</th>
													<th>Credit</th>
													<th>Sub User</th>
													<th>Action</th>
												</tr>
											</tfoot>
										</table>
									<?php } else if ($role == 2) { ?>
									 	<table id="example1" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>Fullname</th>
													<th>Email & Mobile</th>
													<th>Active</th>
													<th>Credit</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach($ResellerListUser->result() as $lu): ?>
													<tr>
														<td><?=$lu->name?></td>
														<td>
															<?=$lu->email?><br>
															<?=$lu->phone?>
														</td>
														<td>
															<?php 
															if ($lu->status == 1) { ?>
															 	<button type="button" class="btn btn-success btn-block btn-sm"><i class="fa fa-check"></i></button>
															<?php } else { ?>
															 	<button type="button" class="btn btn-danger btn-block btn-sm"><i class="fa fa-times"></i></button>
															<?php }
															?>
														</td>
														<td><?=$lu->credit?></td>
														<td><?=date('d/m/Y',strtotime($lu->created))?></td>
														<td>
															<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
																Action
															</button>
															<div class="dropdown-menu">
																<?php 
																if ($lu->status != 1) { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/activelogin/'.$lu->id?>">Active Login</a>
																<?php } else { ?>
																 	<a class="dropdown-item" href="<?=base_url().'action/deactivelogin/'.$lu->id?>">Deactived Login</a>
																<?php }
																?>
																<a class="dropdown-item" href="<?=base_url().'action/resetpassword/'.$lu->id?>">Reset Password</a>
																<a class="dropdown-item" data-toggle="modal" data-target="#CreditAddReseller<?=$lu->id?>">Add Credit</a>
															</div>
														</td>
													</tr>
												<?php endforeach;?>
											</tbody>
											<tfoot>
												<tr>
													<th>Fullname</th>
													<th>Email & Mobile</th>
													<th>Active</th>
													<th>Credit</th>
													<th>Date</th>
													<th>Action</th>
												</tr>
											</tfoot>
										</table>
									<?php }
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<?php foreach($AdminListUser->result() as $lu): ?>
			<div class="modal fade" id="CreditAddAdmin<?=$lu->id?>">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Add Credit</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form autocomplete="off" action="<?=base_url().'action/addcreditadmin'?>" method="POST">
							<div class="modal-body">
								<div class="form-group">
									<input type="number" hidden name="id" value="<?=$lu->id?>" class="form-control" placeholder="Credit">
									<input type="number" name="credit" class="form-control" placeholder="Credit">
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php foreach($AdminListUser->result() as $lu): ?>
			<div class="modal fade" id="ReduceCredit<?=$lu->id?>">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Reduce Credit</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form autocomplete="off" action="<?=base_url().'action/reducecredit'?>" method="POST">
							<div class="modal-body">
								<div class="form-group">
									<input type="number" hidden name="id" value="<?=$lu->id?>" class="form-control" placeholder="Credit">
									<input type="number" name="credit" class="form-control" placeholder="Credit">
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php foreach($AdminListUser->result() as $lu): ?>
			<div class="modal fade" id="ShowHistory<?=$lu->id?>">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Credit History <?=$lu->name?></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form autocomplete="off" action="<?=base_url().'action/reducecredit'?>" method="POST">
							<div class="modal-body">
								<div class="col-12">
									<div class="card">
										<div class="card-body table-responsive p-0" style="height: 300px;">
											<table class="table table-head-fixed text-nowrap">
												<thead>
													<tr>
														<th>Credit</th>
														<th>Old Credit</th>
														<th>New Credit</th>
														<th>Reason</th>
														<th>Time</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($Userhistory->result() as $a): ?>
														<?php if ($a->userid == $lu->id): ?>
															<?php if ($a->servicename != "Sending Message"): ?>
																<tr>
																	<td><?=$a->credit?></td>
																	<td><?=$a->oldcredit?></td>
																	<td><?=$a->newcredit?></td>
																	<td><?=$a->servicename?></td>
																	<td><?=$a->transtime?></td>
																</tr>
															<?php endif ?>
														<?php endif ?>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php foreach($AdminListUser->result() as $lu): ?>
			<div class="modal fade" id="EditUser<?=$lu->id?>">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Edit Users</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form autocomplete="off" action="<?=base_url().'action/editusers'?>" method="POST">
							<div class="modal-body">
								<div class="form-group">
									<input type="number" hidden name="id" value="<?=$lu->id?>" class="form-control">
									<label>Phone Number</label>
									<input type="number" name="phone" class="form-control" value="<?=$lu->phone?>" placeholder="Phone Number">
								</div>
								<div class="form-group">
									<label>Address</label>
									<input type="text" name="address" class="form-control" value="<?=$lu->address?>" placeholder="Address">
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php foreach($ResellerListUser->result() as $lu): ?>
			<div class="modal fade" id="CreditAddReseller<?=$lu->id?>">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Add Credit</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form autocomplete="off" action="<?=base_url().'action/addcreditreseller'?>" method="POST">
							<div class="modal-body">
								<div class="form-group">
									<input type="number" hidden name="id" value="<?=$lu->id?>" class="form-control" placeholder="Credit">
									<input type="number" name="credit" class="form-control" placeholder="Credit">
								</div>
							</div>
							<div class="modal-footer justify-content-between">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endforeach;?>
		<?php $this->load->view('panel/footer') ?>
		<aside class="control-sidebar control-sidebar-dark"></aside>
	</div>
	<div class="modal fade" id="modal-lg">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Users</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form action="<?=base_url().'users/add'?>" method="POST">
					<div class="modal-body">
						<div class="form-group">
							<label>Fullname</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Fullname" required name="fullname">
							</div>
						</div>
						<div class="form-group">
							<label>Email</label>
							<div class="input-group">
								<input type="email" class="form-control" placeholder="Email" required name="email">
							</div>
						</div>
						<div class="form-group">
							<label>Phone Number</label>
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Phone" required name="phone">
							</div>
							<span>Please Input With Coutry Code</span>
						</div>
						<?php if ($role == 1): ?>
							<div class="form-group">
								<label>Role</label>
								<select class="form-control" required name="role">
									<option value="1">Admin</option>
									<option value="2">Reseller</option>
									<option value="3">Customer</option>
								</select>
							</div>
						<?php endif ?>
					</div>
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</form>
			</div>
		</div>
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
		function yesnoCheck() {
			if (document.getElementById('yesCheck').checked) {
				document.getElementById('ifYes').style.visibility = 'visible';
			}
			else document.getElementById('ifYes').style.visibility = 'hidden';
		}
	</script>
</body>
</html>