<?php 
$is_logged_in = false;
session_start();
if(!empty($_SESSION) && isset($_SESSION['status']) && $_SESSION['status'] == 'logged in'){
	$is_logged_in = true;
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
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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

	<div class="jumbotron">
		<div class="container">
			<h1 class="display-4">Halo Pengunjung</h1>
			<p class="lead">Baca blog terbaru dari kami yang update setiap harinya</p>
			<a class="btn btn-primary btn-lg" href="/blog" role="button">Mulai Membaca</a>
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

</body>
</html>