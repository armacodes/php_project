<?php 
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login/index.php');
	exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/stylesheet.css">
	<title>Wellcome</title>
</head>
<body>

<?php 
include('../layout/head.php')
?>

<div class="container" style="margin-top: 8%; margin-bottom: 20%;">

	<div class="card" style="box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);">
	<div class="card-header">
		WELCOME
	</div>
	<div class="card-body">
		<h5 class="card-title">Logged in user: <?php echo $_SESSION['user']; ?> </h5>
		<p class="card-text">We are going to do big-data processes with temperature sensors.</p>
		<p class="card-text"> - I have previously uploaded a .zip file with a certain number of .csv files, pertaining to temperature and humidity sensors.</p>
		<p class="card-text"> - Then this data will be processed and a general table will appear; from which graphs can be generated that visually show the behavior of the measurements.</p>
		<p class="card-text"> - The format of the processed sensors.csv is: </p>
		<p class="card-text" style="background-color: lightgray; padding: 10px; border-radius: 10px;">  1-Wire/iButton Part Number: DS1921G-F5 <br>
																										1-Wire/iButton Registration Number: E70000004C8A9021 <br>
																										Is Mission Active?  true <br>
																										Mission Start:  Thu Jul 20 19:01:00 CLT 2023 <br>
																										Sample Rate:  Every 5 minute(s) <br>
																										Number of Mission Samples:  2041 <br>
																										Total Samples:  566948 <br>
																										Roll Over Enabled?  false <br>
																										Roll Over Occurred?  Roll over has NOT occurred <br>
																										Active Alarms:  Low Temp <br>
																										Next Clock Alarm At:  Disabled <br>
																										High Temperature Alarm:  80 °C <br>
																										Low Temperature Alarm:  -15 °C <br>
																										<br>
																										Date/Time,Unit,Value <br>
																										20-07-23 19:01:00,C,13.5 <br>
																										20-07-23 19:06:00,C,13.5 <br>
																										20-07-23 19:11:00,C,13.5 <br>
																										20-07-23 19:16:00,C,13.5 <br>
																										20-07-23 19:21:00,C,13.5</p>

		
		<?php 
			if (file_exists('upload/zip/hard_data.zip')) {
				echo '<hr>';
				echo '<p style="margin-top: 2%;"> <a href="table.php" class="btn btn-primary" target="_blank"> Generate table and graph </a> </p>';
			}else {
				echo '<p class="card-text" style="font-weight: bold;"> Required zip file. ADMIN uploads it </p>';
			}
		?>
		<p style="margin-top: 2%;"> <a href="pdf.php" class="btn btn-primary" target="_blank"> Generate PDF </a> </p>
		
		<?php 
		if(!empty($_POST['message']))
		echo $_POST['message'];
		?>

		<form class="mt-2" action="upload/graph.php" method="post" enctype="multipart/form-data">

			<label for=""> Select your Graph </label>
			<input class="form-control" type="file" name="graph" accept="image/jpeg">

			<button class="btn btn-outline-dark mt-2" type="submit"> Upload </button>

		</form>

	</div>
	</div>

</div>

<?php 
include('../layout/footer.php')
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>