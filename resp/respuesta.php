<?php
session_start();
require_once "../php/config.php";

$message = "";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["role"] !== 'user') {
    header("location: ../login.php");
    exit;
}
$user_id = $_SESSION["id"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["respuesta"]))){
        $message = "Por favor, ingrese una respuesta.";
    } else{
        $respuesta = trim($_POST["respuesta"]);
        $sql = "INSERT INTO respuesta (user_id, respuesta) VALUES (?, ?)";

        if($stmt = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($stmt, "is", $param_id, $param_respuesta);
            
            $param_id = $user_id;
            $param_respuesta = $respuesta;
            
            if(mysqli_stmt_execute($stmt)){
                $message = "Respuesta enviada con éxito.";
            } else{
                $message = "Oops! Algo salió mal. Por favor, inténtalo de nuevo más tarde.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta</title>
    <link rel="stylesheet" href="../css/styleCards.css">
    <link rel="stylesheet" href="css/styleCards.css">
    <script src="js/script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
p {
    font-family: 'Georgia', serif;
    margin-bottom: 10px;
    margin-top: 20%;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

textarea#respuesta {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 75%;
    padding: 10px;
    font-family: 'Georgia', serif;
    font-size: 1em;
    border: 1px solid #333;
    border-radius: 5px;
    box-sizing: border-box;
    margin-bottom: 10px;
    margin-top: 50px;
}

input[type="submit"] {
    border-radius: 20px;
    border: none;
    background-color: #333;
    color: #f7eed6;
    font-family: 'Georgia', serif;
    font-style: italic;
    font-size: 100%;
    padding: 10px 20px;
    cursor: pointer;
    margin: 0 auto;
    display: block;
    width: 70%;
    margin-bottom: 8%;
}
input[type="submit"]:hover {
    background-color: #555;
}

#message {
    background-color: green;
    color: black;
    font-weight: bold;
    text-align: center;
    margin-top: 20px;
}
    </style>
</head>
<body>
    <div class="main-container">
        <div class="login-form">
            <div id="message"><?php echo $message; ?></div>
            <p>Aquí podras colcar tu respuesta al mensaje anterior si asi lo deseas, el cual será leido por el     remitente.</p>
            <form action="respuesta.php" method="post">
                <textarea name="respuesta" id="respuesta" cols="30" rows="10"></textarea>
                <input type="submit" value="Enviar">
            </form>
        </div>
    </div>
</body>
</html>