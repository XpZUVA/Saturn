<?php
session_start();

include_once 'inc/ini.php';



if (array_key_exists('newArticle', $_POST)) {
    $title = comprobar_entrada($_POST['title']);
    $description = comprobar_entrada($_POST['description']);
    $category = comprobar_entrada($_POST['category']);
    $content = comprobar_entrada($_POST['content']);
    $author_id = intval($_SESSION['user_id']);


    if(empty($title) || empty($description) || empty($category) || empty($content)) {
        $_SESSION['error_message'] = "Error: No se han rellenado todos los campos.";
        header("Location: article.php", true, 303);
        exit();
    }

    // Verificar si se sube un archivo y procesarlo
    if (isset($_FILES['cover']) && esImagenValida($_FILES['cover'])) {
        // Se ha subido una imagen válida
        $cover = file_get_contents($_FILES['cover']['tmp_name']);
    } else {
        // No se subió una imagen válida, usar la imagen predeterminada
        $cover = file_get_contents('assets/img/default.jpg');
    }
    

    $result = newArticle($conn, $description, $title, $category, $content, $author_id, $cover);

    if ($result === "OK") {
        echo "New record created successfully";
        header('Location: index.php', true, 303);
    } else {
        echo "Error: Could not create new record.";
        $_SESSION['error_message'] = "Error: No se pudo crear el nuevo artículo.";
        header("Location: article.php", true, 303);
    }
    exit();
}


if(array_key_exists('editArticle', $_POST)){
    $title = comprobar_entrada($_POST['title']);
    $description = comprobar_entrada($_POST['description']);
    $category = comprobar_entrada($_POST['category']);
    $content = comprobar_entrada($_POST['content']);
    $article_id = intval($_POST['editArticle']);

    if(empty($title) || empty($description) || empty($category) || empty($content)) {
        $_SESSION['error_message'] = "Error: No se han rellenado todos los campos.";
        header("Location: article.php", true, 303);
        exit();
    }

    // Verificar si se sube un archivo y procesarlo

    if (isset($_FILES['cover']) && esImagenValida($_FILES['cover'])) {
        $cover = file_get_contents($_FILES['cover']['tmp_name']);
    } else {
        $cover = getCover($conn, $article_id)? getCover($conn, $article_id) : file_get_contents('assets/img/default.jpg');

    }

    $result = editArticle($conn, $article_id, $description, $title, $category, $content, $cover);

    if ($result === "OK") {
        echo "Article edited successfully";
        header('Location: index.php', true, 303);
    } else {
        echo "Error: Could not edit the article.";
        $_SESSION['error_message'] = "Error: No se pudo editar el artículo.";
        header("Location: article.php", true, 303);
    }
    exit();


}


if (array_key_exists('searchArticles', $_POST)) {
    // Verifica si se ha enviado el término de búsqueda
    $search = isset($_POST['search']) ? comprobar_entrada($_POST['search']) : '';

    // Llama a la función para buscar artículos
    $articles = searchArticles($conn, $search);

    if ($articles != null) {
        $_SESSION['articles'] = $articles;
        header('Location: index.php', true, 303);
    } else {
        $_SESSION['error_message'] = "No se encontraron artículos con el término de búsqueda: $search";
        header('Location: index.php', true, 303);
    }
    exit();
}



?>

<?php include_once 'inc/end.php'; ?>