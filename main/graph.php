<?php
    session_start();

    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../login/index.php');
        exit;
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $id = 123;
    $limite = 2016;

    $li = 10;
    $ls = 15;

    $archivoCSV = "upload/zip/hard_data.csv";

    $file = fopen($archivoCSV, "r");
    $headers = fgetcsv($file); // Obtener los encabezados

    // Filtrar los encabezados que contengan ""
    $selectedHeaders = [];
    foreach ($headers as $index => $header) {
        if (strpos($header, 'Date/Time') === false) {
            $selectedHeaders[] = $header;
        }
    }

    // Determinar el rango de columnas a seleccionar
    $startColumn = array_search($selectedHeaders[0], $headers);
    $endColumn = array_search($selectedHeaders[count($selectedHeaders) - 1], $headers);

    // Generar colores aleatorios
    function generateRandomColor() {
        $color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
        return $color;
    }

    $j = 0;
    while ( $j < $limite && ($data = fgetcsv($file)) !== false) {
        $labels[] = $data[0]; // Agregar la fecha a las etiquetas
        
        for ($i = $startColumn; $i <= $endColumn; $i++) {
            
            if (empty($datasets[$i - $startColumn])) {
                $color = generateRandomColor(); // Generar un color aleatorio
                $datasets[$i - $startColumn] = [
                    'label' => $selectedHeaders[$i - $startColumn], // Usar el nombre del encabezado seleccionado
                    'data' => [],
                    'borderWidth' => 3,
                    'backgroundColor' => 'rgba(0, 0, 0, 0)', // Usar color transparente
                    'borderColor' => $color//getRandomColor() // Add this line to set a random color
                ];
            }
            
            $datasets[$i - $startColumn]['data'][] = $data[$i]; // Agregar los valores a los conjuntos de datos
        }
        $j = $j + 1;
    }

    fclose($file);

    // Convert data to JSON format
    $labelsJSON = json_encode($labels);
    $datasetsJSON = json_encode($datasets);
?>
<!DOCTYPE html>
<html>
<head>
    <title>graph temp</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <canvas id="myChart" width="1500" height="700" style="background-color: white;"></canvas>
    <a id="descargarImagen" href="#" download="graf_hard_data_temp.jpg">Download Graph</a>

    <!-- Resto del código -->
    <script>
        // Leer datos del archivo CSV
        var labels = <?php echo $labelsJSON; ?>;
        var datasets = <?php echo $datasetsJSON; ?>;

        var tMax = <?php echo $ls; ?>; // Define la temperatura máxima
        var tMin = <?php echo $li; ?>; // Define la temperatura mínima

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Temperature (°C)'
                        },
                        suggestedMin: tMin-2,
                        suggestedMax: tMax+2,
                        ticks: {
                        stepSize: 1,
                            callback: function(value, index, values) {
                                // Verificar si el valor es igual a tMin o está dentro de un rango cercano a tMin
                                if (Math.abs(value - tMin) < 0.5) {
                                    return "Lower limit. " + tMin;
                                } else if (Math.abs(value - tMax) < 0.5) {
                                    // Verificar si el valor es igual a tMax o está dentro de un rango cercano a tMax
                                    return "Upper limit. " + tMax;
                                } else {
                                    return value;
                                }
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date/Time'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Temperature hard_data graph, <?php echo count($datasets); ?> sensors, <?php echo round($limite,0); ?> measurements and (<?php echo round($limite * count($datasets),0);?>) processed data.',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        labels: {
                            color: 'black'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'white',
                        titleColor: 'black',
                        bodyColor: 'black'
                    }
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            }
        });


        document.getElementById('descargarImagen').addEventListener('click', function() {
        let chartCanvas = document.getElementById('myChart');
        let context = chartCanvas.getContext('2d');
        context.globalCompositeOperation = 'destination-over';
        context.fillStyle = 'white';
        context.fillRect(0, 0, chartCanvas.width, chartCanvas.height);
        let imageData = chartCanvas.toDataURL('image/jpeg', 1.0);
        document.getElementById('descargarImagen').href = imageData;
        });

    </script>

</body>
</html>