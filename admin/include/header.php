<?php
if($_SESSION['loggedin'] == FALSE)
	{
		header('location: logout.php');
	}
$username = $_SESSION['user'];
$userid = $_SESSION['userid'];


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
     <link rel="apple-touch-icon" sizes="57x57" href="../images/vetnepal_fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../images/vetnepal_fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../images/vetnepal_fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../images/vetnepal_fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../images/vetnepal_fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../images/vetnepal_fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../images/vetnepal_fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../images/vetnepal_fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../images/vetnepal_fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../images/vetnepal_fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../images/vetnepal_fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../images/vetnepal_fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../images/vetnepal_fav/favicon-16x16.png">
  
  <title>VETNEPAL || Admin</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  --><link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
    <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="dist/css/jquery.tagsinput.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<?php
if(time() > $_SESSION['expire'])
{
	notify("System Notification","You stayed idle for long time. You will be redirected to login page",base_url().'logout.php', FALSE,5000,0);
	die();
}
else
{
	$_SESSION['expire'] = time() + $idle_time;
}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
