<?php 
include('../database/db.php'); 
if($_POST)
{
$InfoID = $_POST['InfoID'];

$getDetail = $db->query("select * from tblvetinfo where InfoID = '$InfoID'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>