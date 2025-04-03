<?php

include 'connection.php';

$conexion=mysqli_connect("localhost","root","toto_jk9514Th99","peliculon");
$id_suc = $_GET['id_suc'];

// Consulta SQL de eliminación
$sql = "UPDATE sucursal SET estatus='0' WHERE id_suc='$id_suc'";

// Ejecutar la consulta de eliminación
if (mysqli_query($conexion, $sql)) {
    echo "<script>alert('Sucursal desactivada con éxito.'); window.location.href='gestsuc.php';</script>";
} else {
    echo "<script>alert('Error al desactivar.'); </script> " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>