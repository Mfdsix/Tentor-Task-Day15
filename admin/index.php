<?php 

require "../backend/blog_index.php";

$is_logged_in = false;
if(!empty($_SESSION) && isset($_SESSION['status']) && $_SESSION['status'] == 'logged in'){
	$is_logged_in = true;
}else{
	header("Location: /login.php");
}

if($_SESSION['role'] != 'admin'){
	header("Location: /index.php");	
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
						<a class="nav-link" href="#">Admin</a>
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
			<div class="col-md-6">
				<h3>Blog</h3>
			</div>
			<div class="col-md-6 text-right">
				<a class="btn btn-success" href="/admin/blog.php"><i class="fas fa-add"></i> Buat Blog</a>
			</div>
		</div>
		<br>
		<table class="table table-bordered table-hovered">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Judul</th>
					<th scope="col">Kontent</th>
					<th scope="col">Penulis</th>
					<th scope="col">Gambar</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				if(count($blogs) == 0){
					?>
					<tr>
						<td colspan="6" class="text-center">Belum ada data</td>
					</tr>
					<?php 
				}else{
					foreach ($blogs as $key => $value) {?>
						<tr>
							<td><?= $key+1 ?></td>
							<td><?= $value['title'] ?></td>
							<td><?= substr($value['description'], 0, 40) ?>...</td>
							<td><?= $value['name'] ?></td>
							<td>
								<?php 
								if($value['image'] != null){
									?>
									<a href="../uploads/posts/<?= $value['image'] ?>" target="_blank"><img src="../uploads/posts/<?= $value['image'] ?>" height="50"></a>
									<?php 
								}else{
								?>
								<img class="card-img-top" src="https://getuikit.com/v2/docs/images/placeholder_600x400.svg" alt="Card image cap">
								<?php 
								} ?>
							</td>
							<td>
								<a href="/admin/blog_edit.php?id=<?=$value['id'];?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
								<a onclick="delete_me(<?= $value['id'] ?>)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
							</td>
						</tr>
						<?php 
					}
				}
				?>
			</tbody>
		</table>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		function delete_me(id){
			if(confirm("Are you sure want to delete this ?")){
				window.location.href = "/backend/blog_delete.php?id="+id;
			}
		}
	</script>

</body>
</html>