<?php
session_start();
require_once "php/config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["role"] !== 'user') {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$mensaje = "No se encontró ningún mensaje para este usuario.";

$sql = "SELECT mensaje FROM mensajes WHERE user_id = ?";

if($stmt = mysqli_prepare($mysqli, $sql)){
    mysqli_stmt_bind_param($stmt, "i", $param_id);
    
    $param_id = $user_id;
    
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) == 1){                    
            mysqli_stmt_bind_result($stmt, $mensaje);
            mysqli_stmt_fetch($stmt);
        }
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card</title>
    <link rel="stylesheet" href="css/styleCards.css">
    <script src="js/script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container">
        <div class="login-form">
            <div class="flor">
                <img class="flor-primary" src="img/flork.png">
            </div>
            <p><?php echo $mensaje; ?></p>
            <a class="respuesta" href="resp/respuesta.php" role="button">Responder</a>
            <a class="respuesta" href="php/logout.php" role="button">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>