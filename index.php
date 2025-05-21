<?php
	//.htaccess file contents found here: https://github.com/dannyvankooten/PHP-Router
	include './fn.php';

	$path = parse_url($_SERVER['REQUEST_URI'])['path'];
	$path = str_replace('/', '', $path);
	
	$conn = connect_to_mysql();
	$query = "SELECT * FROM `peacey_url` WHERE `short` = '$path'";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

	$num = mysqli_num_rows($result);
	
	if ($num == 1){
		$arr = mysqli_fetch_array($result);
		//die(json_encode($arr));
		$site = urldecode($arr['original']);
		header("Location: $site");
	} else {
		include 'inc/head.inc.php';
		include 'inc/nav.inc.php';
		//include 'inc/temp_landing_placeholder.inc.php';
	}
	
?>
<style>
	#pclogo{max-width:500px;margin-top:80px;}
	div:has(img#pclogo){display:flex;justify-content:center;}
</style>

<div class="container-fluid">

	<div class="row">
		<div class="col-md-12">
			<img id="pclogo" src="https://peaceysystems.com/wp-content/uploads/2024/02/PeaceySystems_Logo25_Big-2048x356.png">
		</div><!-- .col-md-12 -->
	</div><!-- .row -->

	<div class="row">
		<div class="col-md-12">
		</div><!-- .col-md-12 -->
	</div><!-- .row -->
</div><!-- .container-fluid -->