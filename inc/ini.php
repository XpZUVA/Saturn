<?php



ob_start();

define("CANCELAR", 399);
define("BAD_REQUEST", 400);
define("OK", 0);
define("ERROR", 1);
define("NO_EXISTE", 2);
define("NO_AUTORIZADO", 3);
define("ERROR_CONSULTA_PERSONA", 4);
define("BLOCK_EXPIRATION_TIME", 600); // 10 minutos en segundos


//CONEXION A LA BASE DE DATOS


// Parámetros de la conexión
$host = "localhost";
$dbname = "saturn"; 
$user = "root"; 
$pass = "Tecnologias_Web24/25"; 

try {
    // Creación de la instancia PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    
    // Establecer el modo de error de PDO para excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error, lo mostramos
    die("Error de conexión: " . $e->getMessage());
}


//COOKIE DE SESION



// Verificar si la cookie está presente
if (isset($_COOKIE['username']) && !isset($_SESSION['username']) && !isset($_SESSION['logged_in'])) {
    // Si la cookie existe y la sesión no está activa, se inicia la sesión automáticamente
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['logged_in'] = $_COOKIE['logged_in'];
}







//INCLUDES

include 'functions.php';
include 'templates.php';
include 'model-persons.php';
include 'model-articles.php';