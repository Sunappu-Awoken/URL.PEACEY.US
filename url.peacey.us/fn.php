<?php
	function connect_to_mysql(){
		$connect_error = 'Sorry, we are experiencing connection issues. Please try again later...';
		$conn = mysqli_connect('localhost','peaceysy_peacey','Supportmanager1111$', 'peaceysy_peacey') or die($connect_error); //or die(mysql_error());
		return $conn;
	}