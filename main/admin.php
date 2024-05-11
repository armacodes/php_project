<?php 
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login/index.php');
	exit;
}

if (isset($_POST['message'])) {
	$message = $_POST['message'];
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/stylesheet.css">
	<title>Admin</title>
</head>
<body>

<?php 
include('../layout/head.php')
?>

<div class="container" style="margin-top: 8%;">

	<div class="card" style="box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);">
	<div class="card-header">
		ADMIN
	</div>
	<div class="card-body">
		<h5 class="card-title">Logged in user: <?php echo $_SESSION['user']; ?> </h5>
		<p class="card-text">Upload the ZIP file with the hard data to be processed.</p>
		<?php 
			if(!empty($message))
			{
				echo $message;
			}
		?>
		<form action="upload/file_zip.php" method="post" enctype="multipart/form-data">
			<div class="input-group mb-3">
			<input type="file" class="form-control" name="zip_dd" accept=".zip">
			<label class="input-group-text">Upload</label>
			</div>
			<button type="submit" class="btn btn-primary">Save</button>
		</form>

		<?php 
			if (file_exists('upload/zip/hard_data.zip')) {
				echo '<hr>';
				echo '<p style="margin-top: 2%;"> <a href="table.php" class="btn btn-primary" target="_blank"> Generate table and graph </a> </p>';
			} else {
				echo '<p class="card-text" style="font-weight: bold;"> Required zip file. </p>';
			}
		?>

	</div>
	</div>

</div>

<?php 
include('../layout/footer.php')
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>