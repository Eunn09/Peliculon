<?php

include 'connection.php';

$conexion=mysqli_connect("localhost","root","toto_jk9514Th99","peliculon");
$id_peli = $_GET['id_peli'];

// Consulta SQL de eliminación
$sql = "UPDATE pelicula SET estatus='1' WHERE id_peli='$id_peli'";

// Ejecutar la consulta de eliminación
if (mysqli_query($conexion, $sql)) {
    echo "<script>alert('Pelicula activada con éxito.'); window.location.href='gestpeli.php';</script>";
} else {
    echo "<script>alert('Error al activar.'); </script> " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>