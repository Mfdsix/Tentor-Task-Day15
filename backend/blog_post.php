<?php 

require './connection.php';
session_start();
// if there is user input
if($_POST){
	// parse user input
	$title = $_POST['title'];
	$content = $_POST['content'];
	$user_id = $_SESSION['user_id'];
	$filename = null;
	$image = $_FILES['image'];
	$tmp_name = $image['tmp_name'];

	if($tmp_name){
		$dir = "../uploads/posts/";
		$extension = pathinfo($image['name'], PATHINFO_EXTENSION);
		$filename = 'post_thumbnail_'.date('YmdHis').'.'.$extension;

		$upload = move_uploaded_file($tmp_name, $dir.$filename);
		if(!$upload){
			header("Location: /admin/blog.php");
		}
	}

	// register user
	$sql = "INSERT INTO blogs (title, description, image, user_id) VALUES('$title', '$content', '$filename', '$user_id')";
	if($connection->query($sql)){
		// save to session
		header("Location: /admin/index.php");
	}else{
		echo "Blog Gagal Ditambahkan. ".$connection->error;
		die();
	}

}else{
	echo "Data Blog Tidak Lengkap.";
	die();
}