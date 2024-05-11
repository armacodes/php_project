<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$med_total = 168;
$li = 15;
$ls = 25;

$archivoZip = "upload/zip/hard_data.zip";
$rutaCSV = "upload/zip/hard_data.csv";
$dias_total = $med_total / 24;
$fin_data= 2016;

$valores = array();

// Abre el archivo ZIP
$zip = new ZipArchive;
if ($zip->open($archivoZip) === TRUE) {
    for ($i = 0; $i < $zip->numFiles; $i++) {

      $diferenciaEnMinutos = 5;
      $segundaLinea = explode("\n", $zip->getFromIndex($i))[1];  //explode(";", $cadena_loca);
      
      //echo $segundaLinea  . " Ultimos 4: " . substr($segundaLinea, -5) . "<br>";
      
      $ultimos4 = substr($segundaLinea, -5);		
      $valores[] = "ID: " . trim($ultimos4);
            
    }
    // Cierra el archivo ZIP
    $zip->close();

} else {
    echo "No se pudo abrir el archivo ZIP\n";
}

// ACA TRABAJERMOS LOS ARREGLOS

/*
$cadena_loca = "123156487454874746486465131741;56161sdfsdf618681;16846161648451;065411684651764161784166;jhfsdfvsgfv";

$cadena_loca_a_arreglo = explode(";", $cadena_loca);


foreach ($cadena_loca_a_arreglo as $valor) {
  echo $valor . "<br>";
}*/


//$array = array('Angel', 'Mendoza', '26125532', 'Project PHP');
//$array2 = array();
//echo $array[0] . "" . $array[1] . "" . $array[2] ;

/*for($i=0;$i<3;$i++)
{
  echo $array[$i] . "<br>";
}*/

/*
foreach ($array as $valor) {
  //echo $valor . "<br>";
  $array2[] = $valor;
}

foreach ($array2 as $valor) {
  echo $valor . "<br>";
}
*/


// Abre el archivo ZIP
$zip = new ZipArchive;
if ($zip->open($archivoZip) === TRUE) {

  $datos = array();
  $columnas = array("Date/Time", $valores[0]);
  
  for ($i = 0; $i < $zip->numFiles; $i++) {
    $archivoCSV = $zip->getNameIndex($i);

    if (($archivo = $zip->getStream($archivoCSV))) {
      $csv = array();
      if (count($datos) === 0) {
        $flag = false;

        $lineaActual = 0;
        $contador = 0;

        while (($fila = fgetcsv($archivo)) !== false) {

          if ($fila[0] == "Date/Time"){
            $flag = true;
            continue; 
          } 
          if ($flag) 
          {
            $datos[] = array($fila[0], $fila[2]);
            $contador++;
          }
          if ($contador > $fin_data)
          {
            break;
          }

        }
      } 
	  else {
		
        $columnas[] = $valores[(count($columnas)-1)];
        $j = 0;
        $flag = false;

        $lineaActual = 0;

        while (($fila = fgetcsv($archivo)) !== false) {

          if ($fila[0] == "Date/Time"){
            $flag = true;
            continue;
          } 
          if ($flag) 
          {
            $datos[$j][] = $fila[2];
            $j++;
          }
          if ($j > $fin_data) {
            break;
          }

        }

      }
      fclose($archivo);
    }
  }

  if (($archivo = fopen($rutaCSV, "w")) !== false) {

    $primerasColumnas = $columnas;
    fputcsv($archivo, $primerasColumnas);

    for ($i = 0; $i < count($datos); $i++) {
        if ($i > $fin_data) {
            continue;
        }
        
      $fila = $datos[$i];
      fputcsv($archivo, $fila);

    }

    fclose($archivo);

    } else {
        echo "No se pudo crear el archivo CSV";
    }
} 
else{
    echo "No se pudo abrir el archivo ZIP";
}
?>