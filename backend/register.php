<?php 

require './connection.php';

// if there is user input
if($_POST){
	// parse user input
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);

	// register user
	$sql = "INSERT INTO users (name, email, password, role) VALUES('$name', '$email', '$password', 'user')";
	if($connection->query($sql)){
		// save to session
		session_start();
		$user_id = 0;
		$sql = "SELECT * FROM users WHERE email = '$email'";
		$result = $connection->query($sql);

		if($result->num_rows > 0){
			$user_id = $result->fetch_assoc()['id'];
		}

		$_SESSION['email'] = $email;
		$_SESSION['status'] = "logged in";
		$_SESSION['user_id'] = $user_id;
		$_SESSION['role'] = 'user';
		
		header("Location: /index.php");
	}else{
		echo "Gagal Register. ".$connection->error;
		die();
	}

}else{
	echo "Data Register Tidak Lengkap";
	die();
}