<?php 

require "../backend/connection.php";

$is_logged_in = false;
session_start();
if(!empty($_SESSION) && isset($_SESSION['status']) && $_SESSION['status'] == 'logged in'){
	$is_logged_in = true;
}else{
	header("Location: /login.php");
}

if($_SESSION['role'] != 'admin'){
	header("Location: /index.php");	
}

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


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Blog</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand" href="/index.php">News</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="/index.php">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/blog">Blog</a>
					</li>
					<li class="nav-item active">
						<a class="nav-link" href="/admin">Admin</a>
					</li>
				</ul>
				<form class="form-inline my-2 my-lg-0">
					<?php 
					if(!$is_logged_in){
						?>
						<a href="/login.php" class="btn btn-light my-2 my-sm-0 mr-2">Login</a>
						<a href="/register.php" class="btn btn-light my-2 my-sm-0">Register</a>
					<?php }else{ ?>
						<a href="/logout.php" class="btn btn-light my-2 my-sm-0 mr-2">Logout</a>
					<?php } ?>
				</form>
			</div>
		</div>
	</nav>

	<?php 
	if($is_logged_in){
		?>
		<div class="container mt-4">
			<div class="alert alert-success">Kamu telah login dengan email : <?= $_SESSION['email'] ?></div>
		</div>
		<?php 
	}
	?>

	<div class="container mt-4">
		<div class="row">
			<div class="col-md-6 m-auto">
				<div class="panel">
					<div class="panel-body">
						<h3>Edit Blog</h3>
						<hr>
						<form method="post" action="/backend/blog_edit.php?id=<?= $id ?>" enctype="multipart/form-data">
							<div class="form-group">
								<label>Judul</label>
								<input type="text" name="title" required="" placeholder="Judul Blog" class="form-control" value="<?= $blog['title'] ?>">
							</div>
							<div class="form-group">
								<label>Konten</label>
								<textarea name="content" placeholder="Konten Blog" required="" class="form-control"><?= $blog['description'] ?></textarea>
							</div>
							<div class="form-group">
								<label>Gambar</label>
								<input type="file" name="image" class="form-control" placeholder="Gambar">
							</div>
							<hr>
							<div class="form-group text-right">
								<button class="btn btn-primary btn-block"><i class="fas fa-add"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>	
			</div>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>