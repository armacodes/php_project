<?php

function redirect($message)
{ 
    echo "<form id='redirect-form' method='post' action='../welcome.php'>";
    echo "<input type='hidden' name='message' value='$message'>";
    echo "</form>";
    echo "<script>document.getElementById('redirect-form').submit();</script>";
    exit();
}

// Directorio donde se guardarán los archivos subidos
$directorio_destino = 'image_graph/';

// Verificar si se ha subido un archivo
if (isset($_FILES['graph']) && $_FILES['graph']['error'] === UPLOAD_ERR_OK) {
    // Obtener el tipo MIME del archivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $_FILES["graph"]["tmp_name"]);
    finfo_close($finfo);

    // Verificar que el archivo sea de tipo PDF
    if ($mime_type !== 'image/jpeg') {
        $message = '<div class="alert alert-danger" role="alert"> Only JPEG files are allowed. </div>';
        redirect($message);
    }
    // Mover el archivo temporal al directorio de destino
    if (move_uploaded_file($_FILES['graph']['tmp_name'], $directorio_destino . "graf_hard_data_temp.jpg")) {
        $message = '<div class="alert alert-success" role="alert"> The graph has been uploaded successfully. </div>';
        redirect($message);
    } else {
        $message = '<div class="alert alert-danger" role="alert"> An error occurred while uploading the file. </div>';
        redirect($message);
    }
} else {
    $message = '<div class="alert alert-warning" role="alert"> No JPEG file was selected. </div>';
    redirect($message);
}
?>