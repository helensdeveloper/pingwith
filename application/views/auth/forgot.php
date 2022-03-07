<?php 
$query = $this->db->get_where('identity', array('id' => 1));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$name = $row['name'];
	$url = $row['url'];
	$icon = $row['icon'];
} ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$name?> | Forgot Password</title>
	<link rel="icon" type="image/x-icon" href="<?=base_url().'template/dist/img/'.$icon?>"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/fontawesome-free/css/all.min.css'?>">
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/dist/css/adminlte.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/icheck-bootstrap/icheck-bootstrap.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'?>">
	<link rel="stylesheet" href="<?=base_url().'template/plugins/toastr/toastr.min.css'?>">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<a href="<?=base_url().'auth/forgot'?>" class="h1"><b><?=$name?></b> Forgot</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
				<form action="<?=base_url().'auth/forgot/submit'?>" method="post">
					<div class="input-group mb-3">
						<input type="text" name="value" class="form-control" placeholder="Email or Phonenumber">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">Request new password</button>
						</div>
					</div>
				</form>
				<p class="mt-3 mb-1">
					<a href="<?=base_url().'auth/login'?>">Login</a>
				</p>
			</div>
		</div>
	</div>
	<script src="<?=base_url().'template/plugins/jquery/jquery.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/bootstrap/js/bootstrap.bundle.min.js'?>"></script>
	<script src="<?=base_url().'template/dist/js/adminlte.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/sweetalert2/sweetalert2.min.js'?>"></script>
	<script src="<?=base_url().'template/plugins/toastr/toastr.min.js'?>"></script>
	<script src="<?=base_url().'template/dist/js/demo.js'?>"></script>
	<script src="<?=base_url().'template/custom/forgot.js'?>"></script>
</body>
</html>