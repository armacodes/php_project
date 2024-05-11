<?php
// Incluir la biblioteca TCPDF
require_once('../TCPDF/tcpdf.php');

// Instanciar TCPDF
$pdf = new TCPDF();

function header_and_footer($num_page, $total_page, $pdf)
{
    // Encabezado
    $pdf->SetY(10); // Posición vertical a 10 mm desde la parte superior de la página
    $pdf->SetFillColor(220, 220, 220); // Color de relleno (gris claro)
    $pdf->SetFont('helvetica', 'B', 12); // Fuente y tamaño del texto
    $pdf->Cell(0, 10, 'Temperature Measurements Report', 0, false, 'C', 1, '', 0, false, 'M', 'M');

    // Configurar el pie de página
    $pdf->SetFont('helvetica', 'I', 8); // Fuente y tamaño del texto
    $pdf->Text(180, 270, "Page " . $num_page . " of " . $total_page);
}

// Establecer algunas propiedades del documento
$pdf->SetCreator('TCPDF Example');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Sample PDF');
$pdf->SetSubject('Testing TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test');

// Agregar una página
$pdf->AddPage();

$pdf->SetFont('helvetica', '', 10); // Fuente y tamaño del texto
$pdf->text(10, 30, 'Total sensors: 10'); // Agregar texto y permitir salto de línea
$pdf->text(10, 40, 'Processed measurements: 2016 of 2016'); // Agregar texto y permitir salto de línea
$pdf->text(10, 50, 'Measurement range: Every 5 Minutes'); // Agregar texto y permitir salto de línea
$pdf->text(10, 60, 'Equivalent to 7 days (one week) of measurement.'); // Agregar texto y permitir salto de línea


//info cliente
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);
$html = '<table>';

$html .= '<tr bgcolor="#606160"> <td colspan="5" align="left" <font color="white"> ><b> Sensor processed format: </b></td></tr>';
$html .= '<tr><td colspan="3"><b>   1-Wire/iButton Part Number: DS1921G-F5 <br>
                                    1-Wire/iButton Registration Number: E70000004C8A9021 <br>
                                    Is Mission Active? true <br>
                                    Mission Start: Thu Jul 20 19:01:00 CLT 2023 <br>
                                    Sample Rate: Every 5 minute(s) <br>
                                    Number of Mission Samples: 2041 <br>
                                    Total Samples: 566948 <br>
                                    Roll Over Enabled? false <br>
                                    Roll Over Occurred? Roll over has NOT occurred <br>
                                    Active Alarms: Low Temp <br>
                                    Next Clock Alarm At: Disabled <br>
                                    High Temperature Alarm: 80 °C <br>
                                    Low Temperature Alarm: -15 °C <br> </b></td></tr>';

$html .= '<tr><td colspan="3"><b>   Date/Time,Unit,Value <br>
                                    20-07-23 19:01:00,C,13.5 <br>
                                    20-07-23 19:06:00,C,13.5 <br>
                                    20-07-23 19:11:00,C,13.5 <br>
                                    20-07-23 19:16:00,C,13.5 <br>
                                    20-07-23 19:21:00,C,13.5 <br> </b></td></tr>';

$html .= '</table>';

$pdf->writeHTMLCell(195, 100, 10, 70, $html, 0, 0, false, true, 'L', true);//ancho, alto,x,y,borde,salto de linea,Renderizado,Autofit,Alineacion,Fill

// Agregar una imagen
$image_file = 'upload/image_graph/graf_hard_data_temp.jpg'; // Ruta de la imagen
$pdf->Image($image_file, 10, 170, 180, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false);
                        //x, y, Escala

header_and_footer($pdf->getAliasNumPage(), $pdf->getAliasNbPages(), $pdf);
 
// Agregar una página
//$pdf->AddPage();

//header_and_footer($pdf->getAliasNumPage(), $pdf->getAliasNbPages(), $pdf);

// Salida del PDF
$pdf->Output(__DIR__ . '/pdf_file/report.pdf', 'F');
$pdf->Output();
?>