<?php 
include('../database/db.php'); 
if($_POST)
{
$DiseaseID = $_POST['DiseaseID'];

$getDetail = $db->query("select * from tbldisease where DiseaseID = '$DiseaseID'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>