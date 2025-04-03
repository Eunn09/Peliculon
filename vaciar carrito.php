<?php
session_start();

// Vacía el carrito eliminando la variable de sesión
unset($_SESSION['carrito']);

// Redirecciona a la página del carrito
header('Location: carrito.php');
exit();
?>
