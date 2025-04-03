<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
    // El usuario es un administrador, se permite el acceso a la página
    // Coloca aquí el contenido de la página para el administrador

$servername = "localhost";
$username = "root";
$password = "toto_jk9514Th99";
$database = "peliculon";

$conexion = new mysqli($servername, $username, $password, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$query_productos = "SELECT id_peli, tit_peli FROM pelicula";
$result_productos = $conexion->query($query_productos);

$query_sucursales = "SELECT id_suc, nom_suc FROM sucursal";
$result_sucursales = $conexion->query($query_sucursales);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Inventario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Agregar Inventario</h1>
        <form action="guardar in (1).php" method="POST">
            <div class="form-group">
                <label for="producto">Peliculas:</label>
                <select class="form-control" id="id_peli" name="id_peli">
                    <?php
                    while ($row = $result_productos->fetch_assoc()) {
                        echo '<option value="' . $row['id_peli'] . '">' . $row['tit_peli'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sucursal">Sucursal:</label>
                <select class="form-control" id="id_suc" name="id_suc">
                    <?php
                    while ($row = $result_sucursales->fetch_assoc()) {
                        echo '<option value="' . $row['id_suc'] . '">' . $row['nom_suc'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="existencias">Existencias:</label>
                <input type="number" class="form-control" id="exist_inv" name="exist_inv" min="0" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}else {
    // Si no es un administrador, redirige a la página de inicio de sesión o a alguna otra página de acceso
    header("Location: inicio de sesion.php");
    exit;
}
?>
