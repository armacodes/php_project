<?php 
session_start();
// Controlo si el usuario ya está logueado en el sistema.

if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login/index.php');
	exit;
}
include('stadistic.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Table and graph</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php 
include('../layout/head.php');

echo '<div class="container">';
echo '<p style="font-weight: bold;"> Total sensors:  '.count($valores).' </p>';
echo '<p style="font-weight: bold;"> Processed measurements:  '. $fin_data .' of 2016 </p>';
echo '<p style="font-weight: bold;"> Measurement range:  Every '. $diferenciaEnMinutos. ' Minuts <br> Equivalent to 7 days (one week) of measurement.</p>';

echo '<a class="" href="upload/zip/hard_data.zip" style="font-weight: bold;"> Check the zip with the hard data processed in this example HERE! </a> <br>';
echo '<a class="" href="graph.php" style="font-weight: bold; font-size: 20px;" target="_blank"> &rarr; Generate interactive graph! &larr; </a> <br>';

if($_SESSION['rol'] == "ADMIN")
{
	echo '<a class="btn btn-outline-secondary mt-2 mb-2" href="admin.php" style="font-weight: bold;"> Back/Return </a>';
}
else
{
	echo '<a class="btn btn-outline-secondary mt-2 mb-2" href="welcome.php" style="font-weight: bold;"> Back/Return </a>';
}

echo '</div>';
// Mostrar el contenido del archivo CSV en forma de tabla
echo "<table border='1' style='width: 95%; margin: auto; box-shadow: 0 0 12px rgba(0, 0, 0, 0.6);'>";
if (($archivo = fopen($rutaCSV, "r")) !== false) {
    $filaCount = 0;
    while (($fila = fgetcsv($archivo)) !== false) {

        echo "<tr>";
        if($filaCount == 0)
        {
          echo "<td>Line number</td>";
        }
        else
        {
          echo "<td>$filaCount</td>";
        }
        $filaCount++;
        foreach ($fila as $valor) {
            echo "<td>$valor</td>";
        }
        
        echo "</tr>";
    }
    fclose($archivo);
} else {
    echo "No se pudo abrir el archivo CSV";
}
echo "</table>";

include('../layout/footer.php')
?>
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>