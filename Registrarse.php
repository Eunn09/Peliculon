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
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #941010fe;
        }

        .navbar a {
            color: #FFF;
            text-decoration: none;
            margin: 0 20px;
        }

        .form-container {
            background-color: #333;
            padding: 20px;
            margin: 20px auto;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #444;
            color: #FFF;
            border-radius: 5px;
        }

        .form-container input[type="submit"] {
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
            width: 100%;
            position: fixed;
            bottom: 0;
        }
    </style>

    <script>
        function validarRegistro() {
            var correo = document.getElementsByName("mail_usu")[0].value;
            var pass1 = document.getElementsByName("pass_usu")[0].value;
            var pass2 = document.getElementsByName("confirm_pass")[0].value;
            var regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (correo.trim() === '' || pass1.trim() === '' || pass2.trim() === '') {
                alert("Por favor, complete todos los campos.");
                return false;
            }

            if (!regexCorreo.test(correo)) {
                alert("Ingrese un correo electrónico válido");
                return false;
            }

            if (pass1 !== pass2) {
                alert("Las contraseñas no coinciden");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark">
            <div class="container d-flex justify-content-between">
                <a class="navbar-brand" href="homapage.html">
                    <h1>Peliculón</h1>
                </a>
                <div class="d-flex">
                    <a href="inicio de sesion.php">Inicio de sesion</a>
                    <a href="catalogo.php">Catálogo</a>
                    <a href="#">Contáctanos</a>
                </div>
            </div>
        </nav>
    </header>
 
    <div class="form-container">
        <h2>Registrarse</h2>
        <form action="Registrarse.php" method="POST" onsubmit="return validarRegistro()">
            <input type="text"  name="mail_usu" placeholder="Correo Electrónico" required>
            <input type="password" name="pass_usu" placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Confirmar Contraseña" required>
            <input type="submit" value="Registrarse">
        </form>
    </div>

    <?php
        include('connection.php');

        if (isset($_POST["mail_usu"]) && isset($_POST["pass_usu"])) {
            $correo_usu = $_POST["mail_usu"];
            $pass_usu = $_POST["pass_usu"];
            $regexCorreo = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';

            if (!preg_match($regexCorreo, $correo_usu)) {
                echo "<script>alert('Ingrese un correo electrónico válido'); window.location.href='registrarse.php';</script>";
            } else {

                $sql = "INSERT INTO usuario VALUES ('$correo_usu', '$pass_usu', '2','1')";

                if ($conexion->query($sql) === TRUE) {
                    echo "<script>alert('Usuario registrado!'); window.location.href='inicio de sesion.php';</script>";
                } else {
                    echo "No se pudo registrar :(";
                }
            }
        }

        mysqli_close($conexion);
    ?>

    <footer class="text-center py-3">
        &copy; 2023 Peliculón. Todos los derechos reservados.
    </footer>
</body>
</html>
