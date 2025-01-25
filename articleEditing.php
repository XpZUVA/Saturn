<?php include_once 'inc/ini.php'; ?>



<script>
// Intervalo de comprobación
setInterval(() => {
    // Realiza una petición para verificar el límite de edición
    fetch('checkEditLimit.php?id=<?php echo $_GET["id"]; ?>')
        .then(response => response.json())
        .then(data => {
            if (data.redirect) {
                var exceedTime = new bootstrap.Modal(document.getElementById('exceedTime'));
                exceedTime.show();

                //Redirigir a la página de inicio
                setTimeout(() => {
                    window.location.href = "index.php";
                }, 7000);

            }
        })
        .catch(error => console.error('Error en la comprobación del límite:', error));
}, 20000); // Cada 20 segundos

function saveButton() {
    const form = document.querySelector('.articleForm');
    if (form) {
        form.submit();
    }
}

function cancelSave() {
    window.location.href = "index.php";
}
</script>


<?php

session_start();
if(!canModify($conn, $_SESSION['user_id'], $_GET['id'])) {
    $_SESSION['error_message'] = 'No puedes editar este artículo';
    header('Location: index.php', true, 303);
}


define("TITLE", "Editando artículo");

articleEditingHeaderTemplate();


// Desbloquear automáticamente si el bloqueo ha expirado


unlockExpiredArticles($conn);

?>





<?php

if (isset($_GET['id']) && isBlocked($conn, $_GET['id']) == 0) {
    blockArticle($conn, $_GET['id']);
    $id = $_GET['id'];
    $article = getArticle($conn, $id);
    $username = getUsername($conn, $article['author_id']);
    $cover = "data:image/jpeg;base64," . base64_encode($article['cover']);
    ?>
<div class="d-flex justify-content-center align-items-center vh-100 mt-5 mb-5">
    <div class="card m-3 position-relative" style="width: 30rem; height: auto; padding: 20px;">
        <!-- Menú hamburguesa -->
        <div class="dropdown position-absolute" style="top: 10px; right: 10px; z-index: 1050;">
            <button class="btn btn-light p-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-list"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li>
                    <button type="button" class="dropdown-item text-primary" data-bs-toggle="modal"
                        data-bs-target="#addCollaborator">
                        Modificar colaboradores
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteArticle" data-bs-id="<?php echo $id; ?>">
                        Borrar artículo
                    </button>
                </li>
            </ul>
        </div>


        <!-- Contenido de la tarjeta -->
        <div class="card-body">
            <h5 class="card-title text-center">Editar Artículo</h5>
            <form action="controller-articles.php" class="articleForm" enctype="multipart/form-data" method="post">
                <!-- Imagen de portada -->
                <div class="mb-3">
                    <img id="preview" class="card-img-top articleCover" style="object-fit: cover; height: 250px;"
                        src="<?php echo $cover; ?>" alt="Portada del artículo" />
                    <input type="file" class="form-control mt-2" id="cover" name="cover" accept="image/*"
                        onchange="previewImage(event)">
                </div>
                <!-- Título -->
                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" class="form-control" id="title" name="title"
                        value="<?php echo $article['title']; ?>">
                </div>
                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="<?php echo $article['description']; ?>">
                </div>
                <!-- Categoría -->
                <div class="mb-3">
                    <label for="category" class="form-label">Categoría</label>
                    <select id="category" name="category" class="form-select">
                        <option value="Sin categoría"
                            <?php echo $article['category'] == 'Sin categoría' ? 'selected' : ''; ?>>Sin categoría
                        </option>
                        <option value="Tecnología"
                            <?php echo $article['category'] == 'Tecnología' ? 'selected' : ''; ?>>Tecnología</option>
                        <option value="Cultura y Entretenimiento"
                            <?php echo $article['category'] == 'Cultura y Entretenimiento' ? 'selected' : ''; ?>>Cultura
                            y Entretenimiento</option>
                        <option value="Deportes" <?php echo $article['category'] == 'Deportes' ? 'selected' : ''; ?>>
                            Deportes</option>
                        <option value="Salud y Bienestar"
                            <?php echo $article['category'] == 'Salud y Bienestar' ? 'selected' : ''; ?>>Salud y
                            Bienestar</option>
                        <option value="Ciencia" <?php echo $article['category'] == 'Ciencia' ? 'selected' : ''; ?>>
                            Ciencia</option>
                        <option value="Otros" <?php echo $article['category'] == 'Otros' ? 'selected' : ''; ?>>Otros
                        </option>
                        <option value="Internacional"
                            <?php echo $article['category'] == 'Internacional' ? 'selected' : ''; ?>>Internacional
                        </option>
                        <option value="Economía" <?php echo $article['category'] == 'Economía' ? 'selected' : ''; ?>>
                            Economía</option>
                        <option value="Política" <?php echo $article['category'] == 'Política' ? 'selected' : ''; ?>>
                            Política</option>
                        <option value="Educación" <?php echo $article['category'] == 'Educación' ? 'selected' : ''; ?>>
                            Educación</option>
                        <option value="Medio Ambiente"
                            <?php echo $article['category'] == 'Medio Ambiente' ? 'selected' : ''; ?>>Medio Ambiente
                        </option>
                        <option value="Covid-19" <?php echo $article['category'] == 'Covid-19' ? 'selected' : ''; ?>>
                            Covid-19</option>
                    </select>
                </div>
                <!-- Contenido -->
                <div class="mb-3">
                    <label for="content" class="form-label">Contenido</label>
                    <textarea id="content" name="content" class="form-control"
                        rows="4"><?php echo $article['content']; ?></textarea>
                </div>
                <!-- Inputs ocultos -->
                <input type="hidden" name="editArticle" value="<?php echo $id; ?>" />
                <input type="hidden" name="author_id" value="<?php echo $article['author_id']; ?>" />
                <input type="hidden" name="blocked" value="0" />
                <!-- Botón Guardar -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview');
        preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?php
} else {
    $_SESSION['error_message'] = 'Alguien se encuentra editando este artículo, por favor, inténtalo más tarde';
    header('Location: index.php', true, 303);
}
?>

<div class="modal fade" id="exceedTime" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Has excedido el límite de edición, tienes <b>siete</b>
                    segundos para elegir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    onclick="cancelSave()"></button>
            </div>
            <div class="modal-body">
                ¿Quiere guardar los cambios realizados?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    onclick="cancelSave()">Cancelar</button>
                <button type="button" class="btn btn-primary bg-primary text-white p-"
                    onclick="saveButton()">Guardar</button>
            </div>
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

<script>
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
            <?php
            if(isset($_GET['id'])) {
                echo 'window.location.href = "articleDeleting.php?id='.$_GET['id'].'";';
            }
            ?>
        };
    });
});
</script>

<div class="modal fade" id="addCollaborator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Usuarios:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="controller-persons.php" method="post">
                <div class="modal-body">
                    <!-- <input type="text" name="username" id="username" class="form-control" placeholder="Nombre de usuario" required> -->

                    <?php
            getUsers($conn);
            getCollaborators($conn, $_GET['id']);
            
            foreach ($_SESSION['users'] as $user) {

                if($user['id'] != $_SESSION['user_id']) {
                    echo '<div class="form-check">';
                        if (in_array($user['id'], array_column($_SESSION['collaborators'], 'collaborator_id'))) {
                            echo '<input class="form-check-input" type="checkbox" name="collaborators[]" id="user'.$user['id'].'" value="'.$user['id'].'" checked>';
                        } else {
                            echo '<input class="form-check-input" type="checkbox" name="collaborators[]" id="user'.$user['id'].'" value="'.$user['id'].'">';
                        }
                        
                            echo '<label class="form-check-label" for="user'.$user['id'].'">'.$user['username'].'</label>';
                    echo '</div>';
                }
            }
                
            
            ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="hidden" name="addCollaborator" value="1" />
                    <input type="hidden" id="article_id" name="article_id" value="<?php 
        $id = isset($_GET['id']) ? $_GET['id'] : '';
        echo htmlspecialchars($id); ?>" />
                    <input type="hidden" name="addCollaborator" value="1" />
                    <button type="submit" class="btn btn-primary">Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php articleEditingfooterTemplate(); ?>
<?php include_once 'inc/end.php'; ?>