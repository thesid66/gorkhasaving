<?php 
include('../database/db.php'); 
if($_POST)
{
$pageid = $_POST['linkid'];

$getDetail = $db->query("select * from gallery where pageid = '$pageid'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>