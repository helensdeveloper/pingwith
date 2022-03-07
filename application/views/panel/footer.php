<?php 
$query = $this->db->get_where('identity', array('id' => 1));
if($query->num_rows() > 0){
	$row = $query->row_array();
	$name = $row['name'];
	$url = $row['url'];
	$icon = $row['icon'];
}?>
<footer class="main-footer">
	<div class="float-right d-none d-sm-block">
		<b>Version</b> 1.1.5
	</div>
	<strong>Copyright &copy; <?php echo date('Y') ?> <a href="<?=$url?>"><?=$name?></a>.</strong> All rights reserved.
</footer>