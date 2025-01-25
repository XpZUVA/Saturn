<?php include_once 'inc/ini.php';



define("TITLE", "Leyendo artículo");

noSesionHeaderTemplate();

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $article = getArticle($conn, $id);
    $username = getUsername($conn, $article['author_id']);
} else {
    header('Location: index.php', true, 303);
}

?>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card" style="width: 24rem; height: auto;">
        <!-- Cargar la imagen desde el código PHP -->
        <img class="card-img-top" style="object-fit: cover; height: 250px;" role="img" aria-label="Thumbnail"
            src="data:image/jpeg;base64,<?php echo base64_encode($article['cover']); ?>" alt="Imagen de artículo">

        <div class="card-body text-center">
            <h5 class="card-title"><?php echo $article['title']; ?></h5>
            <p class="card-text"><?php echo $article['description']; ?></p>
            <p class='card-text badge bg-success text-wrap'><?php echo $article['category'] ?></p>
            <hr class="w-100 border-top border-dark">

            <p class="card-text"><?php echo $article['content']; ?></p>
            <p class="card-text"><small
                    class="text-muted"><?php echo date("Y-m-d", strtotime($article['dateCreation'])); ?></small></p>
            <p class="card-text"><small class="text-muted">Autor: <?php echo $username; ?></small></p>
        </div>
    </div>
</div>



<?php footerTemplate(); ?>
<?php include_once 'inc/end.php'; ?>