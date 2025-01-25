<?php


//INYECCIONES DE CÓDIGO

function comprobar_entrada($dato) { /* Función para prevenir inyección código JS */
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

function comprobar_entrada2($conexion, $dato) { /* Función para prevenir inyección código JS y SQL */
    $dato = mysqli_real_escape_string($conexion, $dato);
    $dato = trim($dato);
    $dato = stripslashes($dato);
    $dato = htmlspecialchars($dato);
    return $dato;
}

function esImagenValida($file) {
    // Verificar si hay algún error en la carga del archivo
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false; // El archivo no se ha subido correctamente
    }

    // Verificar el tipo MIME utilizando getimagesize
    $imageData = getimagesize($file['tmp_name']);
    
    // Si getimagesize devuelve false, no es una imagen válida
    if ($imageData === false) {
        return false;
    }

    // Verificar que el archivo sea una imagen (el valor de 'mime' debería empezar con "image/")
    if (strpos($imageData['mime'], 'image/') === false) {
        return false; // No es un archivo de imagen
    }

    return true; // El archivo es una imagen válida
}

function getUsername($conn, $user_id) {
    $sentenciaSQL = "SELECT username FROM USUARIO WHERE id = :user_id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result['username'];
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function getAllArticles($conn) {
    $sentenciaSQL = "SELECT * FROM ARTICULO";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->execute();

        $_SESSION['articles'] = $stmt->fetchAll();
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function getPersonalArticle($conn){
    $sentenciaSQL = "SELECT * FROM ARTICULO WHERE author_id = :author_id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':author_id', $_SESSION['user_id'], PDO::PARAM_INT);

        $stmt->execute();

        $_SESSION['personalArticles'] = $stmt->fetchAll();
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}


function getArticle($conn, $id){

    $articleId = intval($id);
    $sentenciaSQL = "SELECT * FROM ARTICULO WHERE id = :articleId";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();

        return $result;
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }

}


function canModify($conn, $user_id, $article_id){

    $sentenciaSQL = "SELECT * FROM ARTICULO WHERE id = :article_id AND author_id = :user_id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();

        if($result != null){
            return true;
        } else {
            
            $sentenciaSQL = "SELECT * FROM ARTICULO_COLABORADOR WHERE article_id = :article_id AND collaborator_id = :user_id";

            $stmt = $conn->prepare($sentenciaSQL);
            $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch();

            if($result != null){
                return true;
            } else {
                return false;
            }

        }
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}


function comprobar_autor($id, $author_id, $conn){
    $sentenciaSQL = "SELECT * FROM ARTICULO WHERE id = :id AND author_id = :author_id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);

        $stmt->execute();

        $result = $stmt->fetch();

        if($result != null){
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }

}
function getUsers($conn){
    $sentenciaSQL = "SELECT * FROM USUARIO";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->execute();

        $_SESSION['users'] = $stmt->fetchAll();
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function getCollaborators($conn, $article_id){
    $sentenciaSQL = "SELECT * FROM ARTICULO_COLABORADOR WHERE article_id = :article_id";

    try {
        $stmt = $conn->prepare($sentenciaSQL);

        $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

        $stmt->execute();

        $_SESSION['collaborators'] = $stmt->fetchAll();
    } catch (PDOException $e) {
        return "ERROR: " . $e->getMessage();
    }
}

function hasExceededEditLimit($conn, $articleId) {
    $query = "SELECT TIMESTAMPDIFF(SECOND, last_blocked_time, NOW()) AS time_diff FROM ARTICULO WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si ha excedido el tiempo permitido
    return $result && $result['time_diff'] > BLOCK_EXPIRATION_TIME;
}


?>
