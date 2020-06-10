<?php 

require "../backend/connection.php";

session_start();

$is_logged_in = false;
if(!empty($_SESSION) && isset($_SESSION['status']) && $_SESSION['status'] == 'logged in'){
	$is_logged_in = true;
}

$sql = "SELECT blogs.*, users.name FROM blogs LEFT JOIN users ON users.id=blogs.user_id ORDER BY created_at DESC";
$result = $connection->query($sql);

$blogs = [];

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		$blogs[] = $row;
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
					<li class="nav-item active">
						<a class="nav-link" href="#">Blog</a>
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

	<div class="container mt-4">
		<div class="row">
			<div class="col-md-6">
				<h3>Blog</h3>
			</div>
			<div class="col-md-6 text-right">
			</div>
		</div>
		<br>
		<?php 
		if(count($blogs) == 0){
			?>
			<div class="text-center py-5">
				<h3>Belum ada data</h3>
			</div>
			<?php 
		}else{
			?>
			<div class="row">
				<?php 
				foreach ($blogs as $key => $value) {?>
					<div class="col-md-4">
						<div class="card">
							<?php 
							if($value['image'] != null){
								?>
								<img class="card-img-top" style="height: 200px;object-fit: cover;" src="../uploads/posts/<?= $value['image'] ?>" alt="Card image cap">
								<?php 
							}else{
								?>
								<img class="card-img-top" style="height: 200px;object-fit: cover;" src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="Card image cap">
								<?php 
							}
							?>
							<div class="card-body">
								<h5 class="card-title"><?= $value['title'] ?></h5>
								<p class="card-text"><?= substr($value['description'], 0, 60) ?>...</p>
								<a href="/blog/detail.php?id=<?= $value['id'] ?>" class="btn btn-primary">Read More</a>
							</div>
						</div>
					</div>
						<?php 
					}
					?>
				</div>
				<?php 
			}
			?>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

	</body>
	</html>