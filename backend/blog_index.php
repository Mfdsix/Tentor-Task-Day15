<?php 

require '../backend/connection.php';
session_start();

$user_id = $_SESSION['user_id'];

$sql = "SELECT blogs.*, users.name FROM blogs LEFT JOIN users ON users.id=blogs.user_id WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = $connection->query($sql);

$blogs = [];

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$blogs[] = $row;
	}
}