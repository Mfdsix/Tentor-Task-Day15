<?php 

$db_servername = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_database = "tcs_mahfudz_14";

$connection = new mysqli($db_servername, $db_username, $db_password, $db_database);
if($connection->connect_error){
	die("Koneksi Database Gagal : ".$connection->connect_error);
}

 ?>