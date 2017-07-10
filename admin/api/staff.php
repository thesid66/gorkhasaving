<?php 
include('../database/db.php'); 
if($_POST)
{
$StaffID = $_POST['StaffID'];

$getDetail = $db->query("select StaffID,Fullname,SPost,Placeorder,Status from tblstaff where StaffID = '$StaffID'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>