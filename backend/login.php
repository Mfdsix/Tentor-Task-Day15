<?php 

require './connection.php';

// if there is user input
if($_POST){
	// parse user input
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	// register user
	$sql = "SELECT * FROM users WHERE email = '$email' && password = '$password'";
	$result = $connection->query($sql);
	
	if($result->num_rows > 0){
		// save to session
		session_start();
		$user = $result->fetch_assoc();
		$_SESSION['email'] = $email;
		$_SESSION['status'] = "logged in";
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['role'] = $user['role'];
		header("Location: /index.php");
	}else{
		echo "Login Gagal. ".$connection->error;
		die();
	}

}else{
	echo "Data Login Tidak Lengkap";
	die();
}