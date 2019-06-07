<?php
require "db_connect.php";
session_start();

$rowid = $_POST['rowid'];
$rowperpage = $_POST['rowperpage'];
$selectedCategory = $_POST['selectedCategory'];

$query = "SELECT count(*) as allcount FROM urls";
if($selectedCategory != "none") { $query .= " WHERE url_category='".$selectedCategory."'"; }
$result = mysqli_query($db,$query);
$fetchresult = mysqli_fetch_array($result);
$allcount = $fetchresult['allcount'];

$query = "SELECT * FROM urls WHERE u_id=".$_SESSION['u_id'];
if($selectedCategory != "none") { $query .= " AND url_category='".$selectedCategory."'"; }
$query .= " ORDER BY url_id ASC LIMIT ".$rowid.",".$rowperpage;

$result = mysqli_query($db,$query);

$url_arr = array();
$url_arr[] = array("allcount" => $allcount);

while($row = mysqli_fetch_array($result)){
    $url_id = $row['url_id'];
    $url_link = $row['url_link'];
    $url_description = $row['url_description'];
	$url_category = $row['url_category'];
	
    $url_arr[] = array("url_id" => $url_id,"url_link" => $url_link,"url_description" => $url_description,"url_category" => $url_category);
}

echo json_encode($url_arr);