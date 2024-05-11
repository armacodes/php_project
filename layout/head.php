<?php
if(isset($_SESSION['loggedin']))
{
    echo '
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
        <h5> Active Session || ' . $_SESSION['rol'] . ' </h5>
        <div class="d-flex">
            <div class="" style="width: 100%;">
            <a class="btn btn-outline-dark" href="../control/login_out.php" style="font-weight: bold;"> Sign-off </a>
            </div>
        </div>
        </div>
    </nav>
    ';
}
else{
    echo '
    <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <h5> Login </h5>
    </div>
    </nav>
    ';
}
?>