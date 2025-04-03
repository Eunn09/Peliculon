<?php
session_start();
if(isset($_SESSION["admin"]) && $_SESSION["admin"] === true){


  ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Buscador de Productos</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-4">
    <h1>Buscador de Productos</h1>
    <form action="" method="GET">
      <div class="form-group">
        <input type="text" name="term" class="form-control" placeholder="Buscar productos...">
      </div>
      <button type="submit" class="btn btn-primary">Buscar</button>
    </form>
    
    <?php
    if (isset($_GET["term"])) {
        $conexion = new mysqli("localhost", "root", "", "peliculon");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $term = $_GET["term"];

        $query = "SELECT * FROM pelicula WHERE tit_peli LIKE '%$term%' OR id_gen  LIKE '%$term%' OR estatus LIKE '%$term%'";
        $result = $conexion->query($query);

        if (!$result) {
            die("Error en la consulta: " . mysqli_error($conexion));
        }

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["estatus"] != 0) {
                    echo "<div class='card mt-2'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row["tit_peli"] . "</h5>";
                    echo "<button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#modalProducto" . $row["id_peli"] . "'>Stock</button>";

                    // Modal para cada producto
                    echo "<div class='modal fade' id='modalProducto" . $row["id_peli"] . "' tabindex='-1' aria-labelledby='modalProductoLabel" . $row["id_peli"] . "' aria-hidden='true'>";
                    echo "<div class='modal-dialog'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='modalProductoLabel" . $row["id_peli"] . "'>" . $row["tit_peli"] . "</h5>";
                    echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";

                    // Formulario para seleccionar la sucursal y las existencias
                    echo "<form action='guardar_inventario.php' method='POST'>";
                    echo "<div class='form-group'>";
                    echo "<label for='sucursal'>Sucursal:</label>";
                    echo "<select class='form-control' name='sucursal' id='sucursal'>";
                    // Obtener y mostrar opciones de sucursales
                    $query_sucursales = "SELECT id_suc, nom_suc FROM sucursal";
                    $result_sucursales = $conexion->query($query_sucursales);
                    while ($sucursal = $result_sucursales->fetch_assoc()) {
                        echo '<option value="' . $sucursal['id_suc'] . '">' . $sucursal['nom_suc'] . '</option>';
                    }
                    echo "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='existencias'>Existencias:</label>";
                    echo "<input type='number' class='form-control' name='existencias' id='exist_inv' required>";
                    echo "</div>";
                    echo "<input type='hidden' name='producto_id' value='" . $row['id_peli'] . "'>";
                    echo "<button type='submit' class='btn btn-primary'>Guardar</button>";
                    echo "</form>";

                    echo "</div>";
                    echo "<div class='modal-footer'>";
                    echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>";
                    echo "</div></div></div></div>";
                    // Fin del modal para cada producto

                    echo "</div></div>";
                }
            }
        } else {
            echo "<p>El producto no existe.</p>";
        }

        $conexion->close();
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}else{
    header("Location: inicio de sesion.php");
    exit;
}
?>