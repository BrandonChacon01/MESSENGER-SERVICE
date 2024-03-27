<?php
require_once "php/config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Ingresa tu nombre de usuario.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Ingresa tu contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {

        $sql_admin = "SELECT id_user, username, password FROM administrador WHERE username = ?";
        if ($stmt_admin = mysqli_prepare($mysqli, $sql_admin)) {
            mysqli_stmt_bind_param($stmt_admin, "s", $param_username);

            $param_username = $username;

            if (mysqli_stmt_execute($stmt_admin)) {
                mysqli_stmt_store_result($stmt_admin);

                if (mysqli_stmt_num_rows($stmt_admin) == 1) {
                    mysqli_stmt_bind_result($stmt_admin, $id_admin, $username_admin, $hashed_password_admin);
                    if (mysqli_stmt_fetch($stmt_admin)) {
                        if (password_verify($password, $hashed_password_admin)) {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id_admin;
                            $_SESSION["username"] = $username_admin;
                            $_SESSION["role"] = 'admin';

                            header("location: php/verRespuestas.php");
                        } else {
                            $login_err = "Usuario o contraseña inválidos.";
                        }
                    }
                }
            }

            mysqli_stmt_close($stmt_admin);
        }

        if (empty($_SESSION["loggedin"])) {
            $sql_users = "SELECT id_user, username, password FROM users WHERE username = ?";
            if ($stmt_users = mysqli_prepare($mysqli, $sql_users)) {
                mysqli_stmt_bind_param($stmt_users, "s", $param_username);

                $param_username = $username;

                if (mysqli_stmt_execute($stmt_users)) {
                    mysqli_stmt_store_result($stmt_users);

                    if (mysqli_stmt_num_rows($stmt_users) == 1) {
                        mysqli_stmt_bind_result($stmt_users, $id_users, $username_users, $hashed_password_users);
                        if (mysqli_stmt_fetch($stmt_users)) {
                            if (password_verify($password, $hashed_password_users)) {
                                session_start();

                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id_users;
                                $_SESSION["username"] = $username_users;
                                $_SESSION["role"] = 'user';

                                header("location: cards.php");
                            } else {
                                $login_err = "Usuario o contraseña inválidos.";
                            }
                        }
                    } else {
                        $login_err = "Usuario o contraseña inválidos.";
                    }
                } else {
                    echo "Ha ocurrido un error. Intenta más tarde.";
                }

                mysqli_stmt_close($stmt_users);
            }
        }

        mysqli_close($mysqli);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/styleLogin.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="main-container">
        <div class="login-form">
            <div class="img-sobre">
                <img src="img/sobre.jpeg" alt="sobre">
            </div>
            <div class="contornos-two">
                <img src="img/contornosTwo.jpg" alt="">
            </div>
            <div class="contorno-one">
                <img src="img/contornos.png" alt="">
            </div>
            <div class="container">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <h2 class="text-right">Login</h2>
                    <div class="form-group">
                        <h4 class="text-remit">Remitente del mensaje:</h4>
                        <p class="name-remit">Brandon Chacón</p>
                    </div>
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" name="username" class="form-control" placeholder="Primer nombre">
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña personalizada:</label>
                        <input type="password" name="password" class="form-control" placeholder="**************">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="login-btn" value="Login">Abrir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>