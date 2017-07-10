<?php
	error_reporting(0);
	session_start();
	unset($_SESSION);
	session_destroy();
	header('location: login.php');
?>