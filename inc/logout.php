<?php

// Cerrar sesión
session_start();
session_unset();
session_destroy();

// Eliminar la cookie
setcookie('username', '', time() - 3600, "/"); // Establecer la cookie a un tiempo pasado

// Redirigir al usuario
header('Location: ../login.php');
exit();


// Redirige al usuario a la página de inicio de sesión
header("Location: ../login.php");
exit();
?>
