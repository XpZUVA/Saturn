<?php

include_once 'inc/ini.php';

session_start();

?>

<?php define("TITLE", "Saturn"); ?>

<?php accountHeaderTemplate(); 

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
}

?>

<div class="navArticles d-flex align-items-center justify-content-between py-3 text-white bg-dark">
    <div class="flex-grow-1 text-center">
        <h2 class="articlesTitlesNav m-0">Mis Artículos</h2>
    </div>
    <button class="btn btn-success me-3" onclick="createArticle()">Crear artículo</button>
</div>
<script>
function createArticle() {
    window.location.href = "article.php";
}
</script>
<hr class="m-0 p-0 border-5 border-secondary">
<div class="album py-5 bg-dark main-content">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
            <?php getPersonalArticle($conn);
                    if(isset($_SESSION['personalArticles'])){
                        foreach($_SESSION['personalArticles'] as $article){
                            $id = $article['id'];

                            echo "<div class='col'>";
                            echo "<div class='card shadow-sm hover-shadow'>";
                            echo "<img class='card-img-top' style='object-fit: cover; height: 225px;' role='img' aria-label='Placeholder: Thumbnail' src='data:image/jpeg;base64," . base64_encode($article['cover']) . "'/>";
                            echo "<div class='card-body'>";
                            echo "<h3 class='card-text'>" . $article['title'] . "</h3>";
                            echo "<p class='card-text'>" . $article['description'] . "</p>";
                            echo "<div class='d-flex justify-content-between align-items-center'>";
                            echo "<div class='btn-group'>";

                            echo "<button type='button' class='btn btn-sm btn-outline-secondary' onclick='readArticle($id)'>Leer</button>";

                            if(canModify($conn, $_SESSION['user_id'], $id)){
                                echo "<button type='button' class='btn btn-sm btn-outline-primary' onclick='editArticle($id)'>Editar</button>";
                                echo "<button type='button' class='btn btn-sm btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deleteArticle' data-id='$id'>Eliminar</button>";

                            }
                            

                            echo "</div>";
                            echo "<small class='text-muted'>" . date("Y-m-d", strtotime($article['dateCreation'])) . "</small>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";


                        }
                    }
                ?>
        </div>
    </div>
</div>

<?php footerTemplate(); ?>
<?php include_once 'inc/end.php'; ?>