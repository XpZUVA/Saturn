<?php include_once 'inc/ini.php';
session_start();



if(!isset($_SESSION['logged_in'])){
    header('Location: index.php');
    exit();
}else{
    $current_user_id = $_SESSION['user_id'];
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        
        $sql = "SELECT author_id FROM ARTICULO WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            $author = $stmt->fetch();

            if($author['author_id'] == $current_user_id){
                $sql = "DELETE FROM ARTICULO WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                
                if($stmt->execute()){
                    $_SESSION['message'] = "Artículo eliminado correctamente.";
                    header('Location: index.php', true, 303);
                    exit();
                }else{
                    $_SESSION['error_message'] = "Error al eliminar el artículo.";
                    header('Location: index.php', true, 303);
                    exit();
                }
        }else{
            $_SESSION['error_message'] = "Error al eliminar el artículo.";
            header('Location: index.php');
            exit();
        }
        }
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id']; // Asignar el valor de $_GET['id'] a la variable $id
    
    $current_user_id = $_SESSION['user_id'];

    // Preparamos la consulta SQL para eliminar el artículo
    $sql = "DELETE FROM ARTICULO WHERE id = :id AND author_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $current_user_id, PDO::PARAM_INT);
    
    
    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Redirigimos después de eliminar correctamente el artículo
        $_SESSION['message'] = "Artículo eliminado correctamente."; // Guardar mensaje de éxito
        header('Location: index.php', true, 303); // Redirigir a la página principal
        exit(); // Asegurarse de que el script se detiene después de la redirección
    } else {
        // Si ocurre un error, redirigimos con mensaje de error
        $_SESSION['error_message'] = "Error al eliminar el artículo.";
        header('Location: index.php', true, 303);
        exit(); // Detener el script después de la redirección
    }
    
} else {
    // Si no se ha recibido el parámetro 'id', redirigimos a la página principal
    $_SESSION['error_message'] = "Error al eliminar el artículo.";
    header('Location: index.php', true, 303);
    exit();
}
?>