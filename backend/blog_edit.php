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

if($_POST){
	// parse user input
	$title = $_POST['title'];
	$content = $_POST['content'];
	$filename = $blog['image'];
	$image = $_FILES['image'];
	$tmp_name = $image['tmp_name'];

	if($tmp_name){
		$dir = "../uploads/posts/";
		$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
		$filename = 'post_thumbnail_'.date('YmdHis').'.'.$extension;
		unlink("../uploads/posts/".$blog['image']);

		$upload = move_uploaded_file($tmp_name, $dir.$filename);
		if(!$upload){
			echo "Upload file gagal";
			die();
		}
	}

	// register user
	$sql = "UPDATE blogs SET title = '$title', description = '$content', image = '$filename' WHERE id = '$id'";
	if($connection->query($sql)){
		header("Location: /admin/index.php");
	}else{
		echo "Blog Gagal Diedit. ".$connection->error;
		die();
	}

}else{
	echo "Data Blog Tidak Lengkap";
	die();
}