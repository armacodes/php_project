<?php
session_start();
include('connection.php');

if (!empty($_POST['userName']) && !empty($_POST['password'])) {

    $user_name = $_POST['userName'];
    $pass      = $_POST['password'];

    $sql = "SELECT * FROM user WHERE USER_NAME = '$user_name' AND PASS = '$pass'";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    if ($query && mysqli_num_rows($query) > 0) {

        $_SESSION['loggedin'] = true; 
        $_SESSION['rol']      = $row["ROL"]; //ADMIN o USER
        $_SESSION['user']     = $user_name;

        if($_SESSION['rol'] == "ADMIN")
        {
            header('Location: ../main/admin.php');
        }
        else{
            header('Location: ../main/welcome.php');
        }
    }
    else
    {
        $message = '<div class="alert alert-danger" role="alert"> Incorrect username / password </div>';
        include('../login/index.php');
    }
}
else
{
    $message = '<div class="alert alert-danger" role="alert"> The username and/or password is mandatory </div>';
    include('../login/index.php');
}
?>