<?php 
include('../database/db.php'); 
if($_POST)
{
$CateID = $_POST['CateID'];

$getDetail = $db->query("select * from article_subcate where SubCateID = '$CateID'");
echo json_encode($getDetail->fetch_object());
}
else
{
	echo "Invalid Request";
	die();
}
?>