<?php 
include('../database/db.php'); 
if($_POST)
{
$linkid = $_POST['linkid'];

$getDetail = $db->query("select * from tbllinks where id = '$linkid'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>