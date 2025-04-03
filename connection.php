<?php

// Conexión a la base de datos
$host = "localhost";
$usuario = "root";
$contrasena = "toto_jk9514Th99";
$base_de_datos = "peliculon";

$conexion = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);


// Verificar la conexión
if (!$conexion) {
    die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
}

