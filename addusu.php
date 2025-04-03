<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){

    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar</title>
    <style>
        /* Estilos generales */
        body {
            background-color: #000;
            color: #FFF;
            margin: 0;
            padding: 0;
        }

        /* Estilos para el encabezado (navbar) */
        .navbar {
            background-color: #941010fe;
        }

        .navbar a {
            color: #FFF;
            text-decoration: none;
            margin: 0 20px;
        }

        /* Estilos para el formulario de registro */
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

        /* Estilos para el pie de página (footer) */
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
</head>
<body>
    <!-- Encabezado (navbar) -->
    <header>
        <nav class="navbar navbar-dark">
        </nav>
    </header>
 
    <div class="form-container">
        <h2>Agregar usuario</h2>
        <form action="addusu.php" method="post" onsubmit="validarPasswords()">
            <input type="text"  name="mail_usu"  placeholder="Correo Electrónico" required>
            <input type="password" name="pass_usu"  placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Confirmar Contraseña" required>
            <input type="submit" value="Actualizar">
        </form>
    </div>
 
    <?php


    include('connection.php');
    if(isset($_POST["mail_usu"])&&isset($_POST["mail_usu"])){
    $sql="INSERT INTO usuario VALUES ('".$_POST["mail_usu"]."','".$_POST["pass_usu"]."', '1', '1')";
    if($conexion->query($sql)===TRUE){
    echo "<script>alert('Usuario agregado con éxito.'); window.location.href='gestusu.php';</script>";
    }else{
    echo "No se pudo agregar :(";
}
}

// Cerrar la conexión
mysqli_close($conexion);
?>

</body>
</html>
<?php
}else {
    // Si no es un administrador, redirige a la página de inicio de sesión o a alguna otra página de acceso
    header("Location: inicio de sesion.php");
    exit;
}
?>