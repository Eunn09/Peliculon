<?php
session_start();
if(!isset($_SESSION["user"])){
    
    header("Location:inicio de sesion.php");
}else{
$servername = "localhost";
$username = "root";
$password = "toto_jk9514Th99";
$database = "peliculon";

$conexion = new mysqli($servername, $username, $password, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$query_genero = "SELECT id_mun, nom_mun FROM municipio";
$result_genero = $conexion->query($query_genero);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Agregar</title>
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
        <h2>Agregar Sucursal</h2>
        <form action="addsuc.php" method="POST" onsubmit="">
            <input type="text"  name="nom_suc" placeholder="Nombre" required>
            <input type="text" name="col_suc" placeholder="Colonia" required>
            <input type="text" name="call_suc" placeholder="Calle" required>
            <input type="text" name="nI_suc" placeholder="Numero Interior">
            <input type="text" name="nE_suc" placeholder="Numero Exterior" required>
            <input type="text" name="cp_suc" placeholder="Codigo postal" required>
            <select class="form-control" id="id_mun" name="id_mun">
                    <?php
                    while ($row = $result_genero->fetch_assoc()) {
                        echo '<option value="' . $row['id_mun'] . '">' . $row['nom_mun'] . '</option>';
                    }
                    ?>
                </select>
            <input type="submit" value="Agregar">


        </form>
    </div>
 
    <?php


    include('connection.php');
    if(isset($_POST["nom_suc"])&&isset($_POST["nom_suc"])){
    $sql="INSERT INTO sucursal VALUES (0,'".$_POST["nom_suc"]."','".$_POST["col_suc"]."','".$_POST["call_suc"]."','".$_POST["nI_suc"]."','".$_POST["nE_suc"]."','".$_POST["cp_suc"]."','".$_POST["id_mun"]."','1')";
    if($conexion->query($sql)===TRUE){
    echo "<script>alert('Sucursal agregada con éxito.'); window.location.href='gestsuc.php';</script>";
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
}
?>