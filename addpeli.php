<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){

$servername = "localhost";
$username = "root";
$password = "toto_jk9514Th99";
$database = "peliculon";

$conexion = new mysqli($servername, $username, $password, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$query_genero = "SELECT id_gen, nom_gen FROM genero";
$result_genero = $conexion->query($query_genero);
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

        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            background-color: #444;
            color: #FFF;
            border-radius: 5px;
        }

        option {
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
        <h2>Agregar pelicula</h2>
        <form action="addpeli.php" method="POST" onsubmit="">
            <input type="text"  name="tit_peli" placeholder="Titulo" required>
            <input type="text" name="prec_peli" placeholder="Precio" required>
            <input type="text" name="costo_peli" placeholder="Costo" required>
            <input type="text" name="anio_peli" placeholder="Anio" required>
            <input type="file" id="archivo" name="img_peli" accept="image/*">
            <select class="form-control" id="id_gen" name="id_gen">
                    <?php
                    while ($row = $result_genero->fetch_assoc()) {
                        echo '<option value="' . $row['id_gen'] . '">' . $row['nom_gen'] . '</option>';
                    }
                    ?>
                </select>
            
            <input type="submit" value="Agregar">


        </form>
    </div>
 
    <?php


    include('connection.php');
    if(isset($_POST["tit_peli"])&&isset($_POST["tit_peli"])){
    $sql="INSERT INTO pelicula VALUES (0,'".$_POST["tit_peli"]."','".$_POST["prec_peli"]."','".$_POST["costo_peli"]."','".$_POST["anio_peli"]."','".$_POST["img_peli"]."','".$_POST["id_gen"]."','1')";
    if($conexion->query($sql)===TRUE){
    echo "<script>alert('Pelicula agregada con éxito.'); window.location.href='gestpeli.php';</script>";
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