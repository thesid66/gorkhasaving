<?php 
include('../database/db.php'); 
if($_POST)
{
$CateID = $_POST['id'];

$getDetail = $db->query("select * from tblarticle where id = '$CateID'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>