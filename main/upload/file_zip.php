<?php

function upload($message)
{
    echo "<form id='redirect-form' method='post' action='../admin.php'>";
    echo "<input type='hidden' name='message' value='$message'>";
    echo "</form>";
    echo "<script>document.getElementById('redirect-form').submit();</script>";
    exit();
}

$carpeta_destino = 'zip';

$nombre_archivo = 'hard_data.zip';

if ($_FILES['zip_dd']['error'] === UPLOAD_ERR_OK) {
    // Obtenemos información sobre el archivo enviado
    $nombre_temporal = $_FILES['zip_dd']['tmp_name'];
    $nombre_archivo_original = $_FILES['zip_dd']['name'];
    $extension = pathinfo($nombre_archivo_original, PATHINFO_EXTENSION);

    // Verificamos si es un archivo .zip
    if ($extension === 'zip') {
        // Intentamos abrir el archivo .zip
        $zip = zip_open($nombre_temporal);
        if ($zip !== 19) {
            // Si se pudo abrir el archivo, cerramos la conexión y movemos el archivo a la carpeta destino
            zip_close($zip);
            $ruta_destino = $carpeta_destino . '/' . $nombre_archivo;
            if (move_uploaded_file($nombre_temporal, $ruta_destino)) {
                // Se subió el zip correctamente
                $message = '<div class="alert alert-success" role="alert"> File uploaded successfully. </div>';
                upload($message);
            } else {
                // Error al subir el zip. Casi nunca entrará acá. Si pasa, revisarlo bien. Nos hakearon de verdad XD
                $message = '<div class="alert alert-danger" role="alert"> Error uploading file. </div>';
                upload($message);
            }
        } else {
            // Si no se pudo abrir el archivo, indicamos que no es un archivo .zip válido
            $message = '<div class="alert alert-danger" role="alert">The file is not a valid .zip </div>';
            upload($message);
        }
    } else {
        // El zip está tramposeado. No es un zip y quieren dizque hakearnos así los bobos XD
        $message = '<div class="alert alert-danger" role="alert"> The file must have a zip extension </div>';
        upload($message);
    }
} else {
    // Empezamos a descartar posibles valores vacíos en el input
    $message = '<div class="alert alert-danger" role="alert"> Error uploading zip </div>';
    upload($message);
}
?>