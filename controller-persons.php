<?php 
session_start();

include_once 'inc/ini.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(array_key_exists('newPerson', $_POST)) {
    $username = comprobar_entrada($_POST['username']);
    $email = comprobar_entrada($_POST['email']);
    $password = password_hash(comprobar_entrada($_POST['password']), PASSWORD_DEFAULT);
    
    $result = newPerson($conn, $username, $email, $password);
    if ($result == "OK") {
        header("Location: login.php", true, 303);
        exit();
    } else {
        $_SESSION['error_message'] = "Error: No se pudo registrar la nueva persona. Inténtelo de nuevo.";
        header("Location: register.php", true, 303);
        exit();
    }
}

if(array_key_exists('getPerson', $_POST)) {
    $email = comprobar_entrada($_POST['email']);
    $password = comprobar_entrada($_POST['password']);
    
    $user = getPerson($conn, $email);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            setcookie('username', $username, time() + (30 * 24 * 60 * 60), "/");
            setcookie('logged_in', true, time() + (30 * 24 * 60 * 60), "/");

            header("Location: index.php", true, 303);
            exit();
        } else {
            $_SESSION['error_message'] = "Contraseña incorrecta";
            header("Location: login.php", true, 303);
            exit();
        }
    } else {
        $_SESSION['error_message'] = "No existe un usuario con ese email";
        header("Location: login.php", true, 303);
        exit();
    }
}


if (isset($_POST['addCollaborator']) && $_POST['addCollaborator'] == 1) {
    $articleId = intval($_POST['article_id']);
    $selectedCollaborators = isset($_POST['collaborators']) ? $_POST['collaborators'] : [];

    // Consulta los colaboradores actuales en la base de datos
    $query = "SELECT collaborator_id FROM ARTICULO_COLABORADOR WHERE article_id = :article_id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':article_id', $articleId, PDO::PARAM_INT);
    $stmt->execute();
    $currentCollaborators = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Colaboradores para añadir
    $toAdd = array_diff($selectedCollaborators, $currentCollaborators);

    // Colaboradores para eliminar
    $toRemove = array_diff($currentCollaborators, $selectedCollaborators);

    // Añadir colaboradores nuevos
    if (!empty($toAdd)) {
        $insertQuery = "INSERT INTO ARTICULO_COLABORADOR (article_id, collaborator_id) VALUES (:article_id, :collaborator_id)";
        $insertStmt = $conn->prepare($insertQuery);
        foreach ($toAdd as $collaboratorId) {
            $insertStmt->execute([
                ':article_id' => $articleId,
                ':collaborator_id' => $collaboratorId
            ]);
        }
    }

    // Eliminar colaboradores que ya no están seleccionados
    if (!empty($toRemove)) {
        $deleteQuery = "DELETE FROM ARTICULO_COLABORADOR WHERE article_id = :article_id AND collaborator_id = :collaborator_id";
        $deleteStmt = $conn->prepare($deleteQuery);
        foreach ($toRemove as $collaboratorId) {
            $deleteStmt->execute([
                ':article_id' => $articleId,
                ':collaborator_id' => $collaboratorId
            ]);
        }
    }

    //Desbloquear el artículo
    $query = "UPDATE ARTICULO SET blocked = 0 WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
    $stmt->execute();

    

    // Redirigir o mostrar un mensaje de éxito
    header("Location: articleEditing.php?id=$articleId", true, 303);
    exit();
}



include_once 'inc/end.php';
?>