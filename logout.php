<?php
session_start();
// remove all session variables
session_unset();

// destroy the session
session_destroy();

echo"<script> alert('Tu sesion ha finalizado'); window.location.href='landing.php'; </script>";

?>
