<?php
function newPerson($conn, $username, $email, $password) {
    // Define la consulta SQL
    $sentenciaSQL = "INSERT INTO USUARIO (username, email, password) VALUES (:username, :email, :password)";

    try {
        // Prepara la consulta
        $stmt = $conn->prepare($sentenciaSQL);

        // Asocia los parámetros con los valores de las variables
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Ejecuta la sentencia
        $stmt->execute();

        return "OK";  // Aquí podrías usar una constante o mensaje de éxito si lo prefieres
    } catch (PDOException $e) {
        return "ERROR";  // Aquí podrías usar una constante o mensaje de error personalizado
    }
}

function getPerson($conn, $email) {
    $sql = "SELECT * FROM USUARIO WHERE email = :email";
    
    try {
        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar los parámetros
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user;
    } catch (PDOException $e) {
        return null; // Manejo de errores, retornando null en caso de error
    }
}




?>