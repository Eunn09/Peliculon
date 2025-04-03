<?php
session_start();

include('connection.php');

if(isset($_POST["mail_usu"])){
    $sql = "SELECT * FROM usuario WHERE mail_usu=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $_POST["mail_usu"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row["pass_usu"] == $_POST["pass_usu"]){
                if($row["tipo_usu"] == 2){
                    $_SESSION["cliente"] = true;
                    echo "<script>window.location.href='homepagecli.php'</script>";
                } else {
                    if($row["tipo_usu"] == 1){
                        $_SESSION["admin"] = true;
                        echo "<script>window.location.href='dashboard.php'</script>";
                    }
                }
            }
        }
        // Si llega aquí, las credenciales son incorrectas
        echo "<script>alert('Credenciales incorrectas. Por favor, inténtalo de nuevo.');</script>";
    }
}


function validarEmail($email) {
    // Filtrar el correo electrónico a través de un filtro de validación de correo electrónico de PHP
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los índices "correo" y "contrasena" están definidos en $_POST
    if (isset($_POST["correo"]) && isset($_POST["contrasena"])) {
        // Validar el correo electrónico y la contraseña
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];

        if (validarEmail($correo) && !empty($contrasena)) {
            // Los campos son válidos, puedes realizar acciones adicionales aquí
            // ...

            // Ejemplo: Autenticar al usuario (esto dependerá de tu implementación)
            // $usuarioAutenticado = autenticarUsuario($correo, $contrasena);

            // Si el usuario se autentica correctamente, puedes redirigirlo a otra página
            // if ($usuarioAutenticado) {
            //     header("Location: otra_pagina.php");
            //     exit();
            // }
        } else {
            echo "<script>alert('Correo electrónico o contraseña no válidos.');</script>";
            // Puedes redirigir al usuario a la página de inicio de sesión u otra acción según tus necesidades
        }
    } else {
        echo "<script>alert('Datos de inicio de sesión no recibidos.');</script>";
        // Puedes redirigir al usuario a la página de inicio de sesión u otra acción según tus necesidades
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Peliculón</title>
    <style>
        body {
            background-color: #000;
            color: #FFF;
        }
        .navbar {
            background-color: #941010fe;
        }

        .navbar a {
            color: #FFF;
            text-decoration: none;
            margin: 0 20px;
        }
        .login-form {
            background-color: #333;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #444;
            color: #FFF;
            border-radius: 5px;
        }

        .login-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #941010fe;
            color: #FFF;
            border-radius: 5px;
        }
        footer {
            background-color: #941010fe;
            color: #FFF;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="homapage.php">
                    <h1>Peliculón</h1>
                </a>
                <div class="d-flex">
                    <a href="Registrarse.php">Registrarse</a>
                    <a href="catalogo.php">Catálogo</a>
                </div>
            </div>
        </nav>
    </header>
    <div class="login-form">
        <h2>Iniciar Sesión</h2>
        <form action="inicio de sesion.php" method="POST">
            <input type="text" name="mail_usu" placeholder="Email" required>
            <input type="password" name="pass_usu" placeholder="Contraseña" required>
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>

    <footer class="text-center py-3 mt-4">
        &copy; 2023 Peliculón. Todos los derechos reservados.
    </footer>
</body>
</html>