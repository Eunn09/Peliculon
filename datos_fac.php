<?php
session_start();
if(!isset($_SESSION["cliente"])){
    
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
    <title>Datos fiscales</title>
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
        <h2>Datos Fiscales</h2>
        <form action="datos_fac.php" method="POST" onsubmit="">
            <input type="tel" name="tel_cli" placeholder="Telefono" required>
            <input type="text"  name="n1_cli" placeholder="Nombre" required>
            <input type="text" name="app_cli" placeholder="Apellido Paterno" required>
            <input type="text" name="apm_cli" placeholder="Apellido Materno" required>
            <input type="text" name="rfc_cli" placeholder="RFC" required>
            <input type="text" name="col_cli" placeholder="Colonia" required>
            <input type="text" name="calle_cli" placeholder="Calle" required>
            <input type="text" name="nI_cli" placeholder="Número Interior">
            <input type="text" name="nE_cli" placeholder="Número Exterior" required>
            <input type="text" name="cp_cli" placeholder="Codigo Postal" required>
            <input type="text" name="mail_usu" placeholder="mail_usu" required>
            <select class="form-control" id="id_mun" name="id_mun">
                    <?php
                    while ($row = $result_genero->fetch_assoc()) {
                        echo '<option value="' . $row['id_mun'] . '">' . $row['nom_mun'] . '</option>';
                    }
                    ?>
                </select>
            
            <input type="submit" value="Proceder a comprar">


        </form>
    </div>
 
    <?php


    include('connection.php');
    $id_cliente_insertado = null;

    if(isset($_POST["n1_cli"])&&isset($_POST["n1_cli"])){
    $sql="INSERT INTO cliente VALUES (0,'".$_POST["tel_cli"]."','".$_POST["n1_cli"]."','".$_POST["app_cli"]."','".$_POST["apm_cli"]."','".$_POST["rfc_cli"]."','".$_POST["col_cli"]."','".$_POST["calle_cli"]."','".$_POST["nI_cli"]."','".$_POST["nE_cli"]."','".$_POST["cp_cli"]."','".$_POST["mail_usu"]."','".$_POST["id_mun"]."','1')";
    if ($conexion->query($sql) === TRUE) {
        // Obtener el ID del cliente insertado
        $id_cliente_insertado = $conexion->insert_id;
    
        // Guardar el ID del cliente en una variable de sesión
        $_SESSION['id_cli'] = $id_cliente_insertado;
    
        echo "<script>alert('Tus datos se han guardado con éxito.'); window.location.href='pago2.php';</script>";
    } else {
        echo "No se pudieron agregar, intenta nuevamente";
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