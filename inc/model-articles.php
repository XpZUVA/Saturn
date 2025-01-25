<?php

function newArticle($conn, $description, $title, $category, $content, $author_id, $cover) {
    $sentenciaSQL = "INSERT INTO ARTICULO (title, description, category, content, author_id, cover) VALUES (:title, :description, :category, :content, :author_id, :cover)";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':cover', $cover, PDO::PARAM_LOB);

        $stmt->execute();

        return "OK";
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function editArticle($conn, $id, $description, $title, $category, $content, $cover) {
    $sentenciaSQL = "UPDATE ARTICULO SET title = :title, description = :description, category = :category, content = :content, cover = :cover, blocked = 0 WHERE id = :id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':cover', $cover, PDO::PARAM_LOB);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return "OK";
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function getCover($conn, $id) {
    $sentenciaSQL = "SELECT cover FROM ARTICULO WHERE id = :id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Devuelve directamente el contenido de la columna "cover"
        $cover = $stmt->fetchColumn(); 
        return $cover;
    } catch (PDOException $e) {
        return null; // Devuelve null si ocurre un error
    }
}

function isBlocked($conn, $id){

    $sentenciaSQL = "SELECT blocked FROM ARTICULO WHERE id = :id";

    $stmt = $conn->prepare($sentenciaSQL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try{

        $stmt->execute();
        $blocked = $stmt->fetchColumn();

        return $blocked;

    } catch (PDOException $e) {
        return null;
    }
}

function blockArticle($conn, $id){

    $sentenciaSQL = "UPDATE ARTICULO SET blocked = 1, last_blocked_time = NOW() WHERE id = :id";

    $stmt = $conn->prepare($sentenciaSQL);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try{

        $stmt->execute();
        return "OK";

    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}


function unlockExpiredArticles($conn) {
    $query = "UPDATE ARTICULO SET blocked = 0 WHERE blocked = 1 AND TIMESTAMPDIFF(SECOND, last_blocked_time, NOW()) > :block_expiration_time";
    
    // Preparar la consulta
    $stmt = $conn->prepare($query);

    // Vincular el parámetro con el valor
    $stmt->bindValue(':block_expiration_time', BLOCK_EXPIRATION_TIME, PDO::PARAM_INT);
    
    // Ejecutar la consulta
    $stmt->execute();
}


function searchArticles($conn, $search) {
    try {
        $query = "SELECT * FROM ARTICULO WHERE title LIKE :search";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        // Captura el error y muestra un mensaje para depuración
        error_log("Error en searchArticles: " . $e->getMessage());
        return null;
    }
}



?>