<?php
require_once "config.php";

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["role"] !== 'admin') {
    header("location: ../login.php");
    exit;
}

$sql = "SELECT users.username, respuesta.respuesta FROM respuesta INNER JOIN users ON respuesta.user_id = users.id_user";
$result = mysqli_query($mysqli, $sql);

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Respuestas</title>
    <link rel="stylesheet" href="css/styleCards.css">
    <script src="js/script.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styleRespuestas.css">
</head>
<body>
    <div class="main-container">
        <div>
            <a href="logout.php" class="lout">Cerrar sesión</a>
        </div>
    <div class="login-form">
        <table>
            <tr>
                <th>Username</th>
                <th>Respuesta</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["username"]. "</td><td>" . $row["respuesta"]. "</td></tr>";
                }
            } else {
                echo "No se encontraron respuestas.";
            }
            ?>
        </table>
    </div>
    </div>
    
</body>
</html>