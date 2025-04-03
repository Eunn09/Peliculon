<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "toto_jk9514Th99";
    $database = "peliculon";

    // Crear conexión
    $conexion = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    if (isset($_POST['id_peli'], $_POST['id_suc'], $_POST['exist_inv'])) {
        $id_peli = $_POST['id_peli'];
        $id_suc = $_POST['id_suc'];
        $exist_inv = $_POST['exist_inv'];
    
        $sql_buscar_existencia = "SELECT id_inv FROM inventario WHERE id_peli = ? AND id_suc = ?";
        if ($stmt_buscar = $conexion->prepare($sql_buscar_existencia)) {
            $stmt_buscar->bind_param("ii", $id_peli, $id_suc);
            $stmt_buscar->execute();
            $stmt_buscar->store_result();
    
            if ($stmt_buscar->num_rows > 0) {
                // Si ya existe la película en esa sucursal, actualiza la existencia
                $sql_actualizar_existencia = "UPDATE inventario SET exist_inv = exist_inv + ? WHERE id_peli = ? AND id_suc = ?";
                if ($stmt_actualizar = $conexion->prepare($sql_actualizar_existencia)) {
                    $stmt_actualizar->bind_param("iii", $exist_inv, $id_peli, $id_suc);
                    if ($stmt_actualizar->execute()) {
                        echo " <script> alert('Existencia actualizada con éxito.'); window.location.href='gestinv.php'; </script>";
                    } else {
                        echo " <script> alert('Error al actualizar la existencia.'); window.location.href='gestinv.php'; </script>" . $stmt_actualizar->error;
                    }
                    $stmt_actualizar->close();
                } else {
                    echo " <script> alert('Error en la preparacion.'); window.location.href='gestinv.php'; </script>" . $conexion->error;
                }
            } else {
                // Si no existe, inserta un nuevo registro en el inventario
                $sql_insertar = "INSERT INTO inventario (id_peli, id_suc, exist_inv) VALUES (?, ?, ?)";
                if ($stmt_insertar = $conexion->prepare($sql_insertar)) {
                    $stmt_insertar->bind_param("iii", $id_peli, $id_suc, $exist_inv);
                    if ($stmt_insertar->execute()) {
                        echo "<script> alert('El inventario se guardo correctamente con éxito.'); window.location.href='gestinv.php';</script>";
                    } else {
                        echo " <script> alert('Error al guardar.'); window.location.href='gestinv.php'; </script>" . $stmt_insertar->error;
                    }
                    $stmt_insertar->close();
                } else {
                    echo " <script> alert('Error.'); window.location.href='gestinv.php'; </script>" . $conexion->error;
                }
            }
            $stmt_buscar->close();
        } else {
            echo "Error en la preparación de la búsqueda: " . $conexion->error;
        }
    }
}
?>    
