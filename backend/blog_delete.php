<?php 

require './connection.php';
session_start();

if($_GET['id']){
	$id = $_GET['id'];
	$user_id = $_SESSION['user_id'];
	$sql = "SELECT * FROM blogs WHERE id = '$id' AND user_id = '$user_id'";
	$result = $connection->query($sql);

	if($result->num_rows > 0){
		$blog = $result->fetch_assoc();
	}else{
		echo "Blog Tidak Ditemukan";
		die();
	}
}

	// register user
$sql = "DELETE FROM blogs WHERE id = '$id'";
if($connection->query($sql)){
	unlink("../uploads/posts/".$blog['image']);
	header("Location: /admin/index.php");
}else{
	echo "Blog Gagal Dihapus. ".$connection->error;
	die();
}