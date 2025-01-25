<?php
include_once 'inc/ini.php';



session_start();

define("TITLE", "Editar artículo");

noSesionHeaderTemplate();


?>

<?php
if (isset($_SESSION['error_message'])) {
    echo "<p style='color: red;'>" . $_SESSION['error_message'] . "</p>";
    unset($_SESSION['error_message']); // Limpia el mensaje para que no se muestre en la siguiente carga
}
?>

<div class="d-flex justify-content-center align-items-center vh-100 mt-5 mb-5">
    <div class="card" style="width: 35rem; height: auto;">
        <div class="card-body">
            <h5 class="card-title text-center">Crear Artículo</h5>
            <form action="controller-articles.php" class="articleForm" enctype="multipart/form-data" method="post">
                <!-- Input para la imagen -->
                <div class="mb-3">
                    <img id="preview" class="card-img-top articleCover" style="object-fit: cover; height: 250px;"
                        role="img" aria-label="Thumbnail" src="assets/img/default.jpg" alt="Portada del artículo" />
                    <input type="file" class="form-control mt-2" id="cover" name="cover" onchange="previewImage(event)">
                </div>
                <!-- Input para el título -->
                <div class="mb-3">
                    <input type="text" class="form-control" value="Título" id="title" name="title">
                </div>
                <!-- Input para la descripción -->
                <div class="mb-3">
                    <input type="text" class="form-control" value="Descripción" id="description" name="description">
                </div>
                <!-- Select para la categoría -->
                <div class="mb-3">
                    <label for="category" class="form-label">Categoría</label>
                    <select id="category" name="category" class="form-select">
                        <option value="Sin categoría">Sin categoría</option>
                        <option value="Tecnología">Tecnología</option>
                        <option value="Cultura y Entrenimiento">Cultura y Entretenimiento</option>
                        <option value="Deportes">Deportes</option>
                        <option value="Salud y Bienestar">Salud y Bienestar</option>
                        <option value="Ciencia">Ciencia</option>
                        <option value="Otros">Otros</option>
                        <option value="Internacional">Internacional</option>
                        <option value="Economía">Economía</option>
                        <option value="Política">Política</option>
                        <option value="Educación">Educación</option>
                        <option value="Medio Ambiente">Medio Ambiente</option>
                        <option value="Covid-19">Covid-19</option>
                    </select>
                </div>
                <!-- Input para el contenido -->
                <div class="mb-3">
                    <label for="content" class="form-label">Contenido</label>
                    <textarea id="content" name="content" class="form-control" rows="4"></textarea>
                </div>
                <!-- Campo oculto -->
                <input type="hidden" name="newArticle" value="1" />
                <!-- Botón de envío -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        // Encuentra el elemento de imagen con id "preview" y actualiza su atributo src
        const preview = document.getElementById('preview');
        preview.src = reader.result;
    };
    // Lee el archivo seleccionado como una URL de datos
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?php footerTemplate(); ?>
<?php include_once 'inc/end.php'; ?>