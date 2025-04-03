<?php

include 'connection.php';

$conexion=mysqli_connect("localhost","root","toto_jk9514Th99","peliculon");
$mail_usu = $_GET['mail_usu'];

// Consulta SQL de eliminación
$sql = "UPDATE usuario SET estatus='1' WHERE mail_usu='$mail_usu'";

// Ejecutar la consulta de eliminación
if (mysqli_query($conexion, $sql)) {
    echo "<script>alert('Usuario activado con éxito.'); window.location.href='gestusu.php';</script>";
} else {
    echo "<script>alert('Error al activar.'); </script> " . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);
?>