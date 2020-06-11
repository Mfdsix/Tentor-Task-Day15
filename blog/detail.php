<?php 
require "../backend/connection.php";

$is_logged_in = false;
session_start();
if(!empty($_SESSION) && isset($_SESSION['status']) && $_SESSION['status'] == 'logged in'){
	$is_logged_in = true;
}

if($_GET['id']){
	$id = $_GET['id'];
	$sql = "SELECT blogs.*, users.name, users.email FROM blogs LEFT JOIN users ON users.id=blogs.user_id WHERE blogs.id = '$id'";
	$result = $connection->query($sql);

	if($result->num_rows > 0){
		$blog = $result->fetch_assoc();
	}else{
		echo "Blog Tidak Ditemukan";
		die();
	}

	$blogs = [];
	$sql = "SELECT blogs.*, users.name, users.email FROM blogs LEFT JOIN users ON users.id=blogs.user_id WHERE blogs.id != '$id' ORDER BY created_at DESC LIMIT 3";
	$result = $connection->query($sql);

	if($result->num_rows > 0){
		while ($row = $result->fetch_assoc()) {
			$blogs[] = $row;
		}
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
					<?php if($is_logged_in && $_SESSION['role'] == 'admin'): ?>
						<li class="nav-item">
							<a class="nav-link" href="/admin">Admin</a>
						</li>
					<?php endif; ?>
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

	<div class="container my-4">
		<div class="row">
			<div class="col-md-8">
				<?php 
				if($blog['image'] != null){
					?>
					<img class="img-fluid" src="../uploads/posts/<?= $blog['image'] ?>" alt="Card image cap">
					<?php 
				}else{
					?>
					<img class="img-fluid" src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="Card image cap">
					<?php 
				}
				?>
				<div class="mt-3">
					<h3><?= $blog['title'] ?></h3>
					<p>Ditulis oleh : <u><?= $blog['name'] ?> <i>(<?= $blog['email'] ?>)</i></u></p>
				</div>
				<hr>
				<p>
					<?= $blog['description']; ?>
				</p>
			</div>

			<div class="col-md-4">
				<h3>Blog Terkait</h3>
				<hr>

				<?php if(count($blogs) == 0): ?>
					<div class="text-center">Tidak Ada Blog Terkait</div>	
					<?php else: ?>
						<?php foreach ($blogs as $key => $value): ?>
							<div class="panel mb-2" style="border: 1px solid #ddd">
								<div class="panel-body">
									<div class="p-4">
										<?php 
										if($blog['image'] != null){
											?>
											<img style="height: 100px; object-fit: cover; width: 100%" src="../uploads/posts/<?= $value['image'] ?>" alt="Card image cap">
											<?php 
										}else{
											?>
											<img class="img-fluid" src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="Card image cap">
											<?php 
										}
										?>
										<div class="mt-3">
											<a href="/blog/detail.php?id=<?= $value['id'] ?>"><h5><?= $value['title'] ?></h5></a>
										</div>
										<hr>
										<p>
											<?= substr($value['description'],0,60); ?>...
										</p>
									</div>
								</div>
							</div>
						<?php endforeach ?>
					<?php endif; ?>
				</div>
			</div>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
	</html>