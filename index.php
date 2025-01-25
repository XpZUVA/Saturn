<?php include_once 'inc/ini.php'; 
session_start();

?>

<?php define("TITLE", "Inicio"); ?>

<?php
if (!isset($_SESSION['logged_in'])) {
    noSesionHeaderTemplate(); 

?>
<main>
    <div class="d-flex justify-content-center align-items-center vh-100" style="transform: translateY(-20%);">
        <div class="col-sm-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title animated-title">¡Bienvenido a SATURN!</h5>
                    <hr>
                    <p class="card-text">
                        Saturn es una plataforma moderna para <b>gestionar</b> y <b>editar</b> artículos, pensada
                        para facilitar la creación de contenido de calidad. </br>
                        Ofrecemos <b>herramientas intuitivas</b> para que puedas crear, organizar y compartir tus
                        artículos de manera <b>rápida</b> y <b>profesional</b>.
                    </p>
                    <p class="card-text">
                        <b>Regístrate</b> y empieza a explorar los artículos más relevantes de la actualidad.
                        </br>Únete a nuestra comunidad y <b>disfruta</b> de una experiencia única de lectura y
                        publicación.
                    </p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Acceso
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item text-primary" href="login.php">Iniciar Sesión</a></li>
                            <li><a class="dropdown-item text-success" href="register.php">Registrarse</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php } else { 
    sesionHeaderTemplate(); 

if (isset($_SESSION['error_message'])) {?>
<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    <?php echo $_SESSION['error_message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php unset($_SESSION['error_message']);}?>

<div class="navArticles position-relative py-4 text-white bg-dark">
    <!-- Título centrado absolutamente -->
    <h2 class="articlesTitlesNav m-0 position-absolute top-50 start-50 translate-middle">Artículos</h2>

    <!-- Botón a la derecha -->
    <button class="btn btn-success position-absolute end-0 me-3 top-50 translate-middle-y"
        onclick="createArticle()">Crear artículo</button>
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
            <?php 
                    if(isset($_SESSION['articles'])){
                        foreach($_SESSION['articles'] as $article){
                            $id = $article['id'];

                            echo "<div class='col'>";
                            echo "<div class='card shadow-sm hover-shadow'>";
                            echo "<img class='card-img-top' style='object-fit: cover; height: 225px;' role='img' aria-label='Placeholder: Thumbnail' src='data:image/jpeg;base64," . base64_encode($article['cover']) . "'/>";
                            echo "<div class='card-body'>";
                            echo "<h3 class='card-text'>" . $article['title'] . "</h3>";
                            echo "<p class='card-text'>" . $article['description'] . "</p>";
                            echo "<p class='card-text badge bg-success text-wrap'>" . $article['category'] . "</p>";
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
                        unset($_SESSION['articles']);
                    }else{
                        getAllArticles($conn);
                        if(isset($_SESSION['articles'])){
                            foreach($_SESSION['articles'] as $article){
                                $id = $article['id'];
    
                                echo "<div class='col'>";
                                echo "<div class='card shadow-sm hover-shadow'>";
                                echo "<img class='card-img-top' style='object-fit: cover; height: 225px;' role='img' aria-label='Placeholder: Thumbnail' src='data:image/jpeg;base64," . base64_encode($article['cover']) . "'/>";
                                echo "<div class='card-body'>";
                                echo "<h3 class='card-text'>" . $article['title'] . "</h3>";
                                echo "<p class='card-text'>" . $article['description'] . "</p>";
                                echo "<p class='card-text badge bg-success text-wrap'>" . $article['category'] . "</p>";
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
                            unset($_SESSION['articles']);
                        }
                        
                    }
                ?>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteArticle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quiere borrar este artículo?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Al borrar este artículo, no se podrá recuperar.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary bg-danger text-white p-" id="confirmDelete">Borrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">ERROR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $_SESSION['error_message']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
function readArticle(id) {
    window.location.href = "articleReading.php?id=" + id;
}

function editArticle(id) {

    window.location.href = "articleEditing.php?id=" + id;

}


document.addEventListener('DOMContentLoaded', function() {
    // Selecciona el modal
    var deleteArticleModal = document.getElementById('deleteArticle');

    // Evento que se dispara cuando se abre el modal
    deleteArticleModal.addEventListener('show.bs.modal', function(event) {
        // Obtén el botón que activó el modal
        var button = event.relatedTarget;

        // Extrae el ID del atributo data-id
        var articleId = button.getAttribute('data-id');

        // Encuentra el botón de confirmación dentro del modal
        var confirmButton = deleteArticleModal.querySelector('#confirmDelete');

        // Limpia eventos previos del botón de confirmación
        confirmButton.onclick = function() {

            // Aquí puedes redirigir al usuario o hacer una petición AJAX
            window.location.href = "articleDeleting.php?id=" + articleId;
        };
    });
});
</script>

<?php } ?>



<?php
if (!isset($_SESSION['logged_in'])) {
    noSesionFooterTemplate(); 
} else {
    footerTemplate();
}
?>


<?php include_once 'inc/end.php'; ?>