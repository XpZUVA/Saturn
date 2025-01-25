<?php //HEADERS TEMPLATES ?>

<?php function simpleHeaderTemplate(){ ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php print constant('TITLE');?> </title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid ">
            <a class="navbar-brand saturn-title" href="index.php">
                <img src="assets/img/SATURN.png" alt="saturn" width="70" height="64"
                    class="d-inline-block align-text-middle">
                SATURN
            </a>
        </div>
    </nav>

</html>

<?php } ?>

<?php function noSesionHeaderTemplate(){ ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php print constant('TITLE');?> </title>
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">




    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A1E21;">
        <div class="container-fluid ">
            <a class="navbar-brand saturn-title" href="index.php">
                <img src="assets/img/SATURN.png" alt="saturn" width="70" height="64"
                    class="d-inline-block align-text-middle">
                SATURN
            </a>
        </div>
    </nav>

    <?php } ?>
    <?php function articleEditingHeaderTemplate(){ ?>

    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> <?php print constant('TITLE');?> </title>
        <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">





        <link href="css/styles.css" rel="stylesheet">
    </head>

    <body class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A1E21;">
            <div class="container-fluid ">
                <a class="navbar-brand saturn-title" href="index.php">
                    <img src="assets/img/SATURN.png" alt="saturn" width="70" height="64"
                        class="d-inline-block align-text-middle">
                    SATURN
                </a>
            </div>
        </nav>

        <?php } ?>

        <?php function sesionHeaderTemplate(){ ?>

        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title> <?php print constant('TITLE');?> </title>
            <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="css/styles.css" rel="stylesheet">
        </head>

        <body>
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A1E21;">
                <div class="container-fluid">
                    <!-- Logo y título -->
                    <a class="navbar-brand saturn-title" href="index.php">
                        <img src="assets/img/SATURN.png" alt="saturn" width="70" height="64"
                            class="d-inline-block align-text-middle">
                        SATURN
                    </a>
                    <!-- Botón toggle -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <!-- Contenido del navbar -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $_SESSION['username']; ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li><a class="dropdown-item text-primary" href="account.php">Perfil</a></li>
                                    <li><a class="dropdown-item text-danger" href="inc/logout.php">Cerrar
                                            sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- Formulario de búsqueda -->
                        <form action="controller-articles.php" method="post" class="d-flex ms-auto">
                            <input class="form-control me-2" type="search" name="search" placeholder="Título"
                                aria-label="Search">
                            <input type="hidden" name="searchArticles" value="1">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            </nav>


            <?php } ?>

            <?php function accountHeaderTemplate(){ ?>

            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title> <?php print constant('TITLE');?> </title>
                <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                <link href="css/styles.css" rel="stylesheet">
            </head>

            <body>
                <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1A1E21;">
                    <div class="container-fluid">
                        <!-- Logo y título -->
                        <a class="navbar-brand saturn-title" href="index.php">
                            <img src="assets/img/SATURN.png" alt="saturn" width="70" height="64"
                                class="d-inline-block align-text-middle">
                            SATURN
                        </a>
                        <!-- Botón toggle -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <!-- Contenido del navbar -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item text-success" href="article.php">Crear artículo</a>
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="inc/logout.php">Cerrar
                                                sesión</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <?php } ?>

                <?php //FOOTERS TEMPLATES ?>

                <?php function noSesionfooterTemplate(){ ?>

                <section class="">
                    <!-- Footer -->
                    <footer class="text-center text-white bg-dark">
                        <!-- Grid container -->
                        <div class="container p-4 pb-0">
                            <!-- Section: CTA -->
                            <section class="">
                                <p class="d-flex justify-content-center align-items-center">
                                    <span class="me-3">Registrate gratis</span>
                                    <a href="register.php" class="btn btn-outline-light btn-rounded">¡Regístrate!</a>

                                </p>
                            </section>
                        </div>


                        <!-- Copyright -->
                        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                            © 2024 Copyright:
                            <a class="text-white" href="#">Saturn</a>
                        </div>

                    </footer>

                </section>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            </body>

            </html>

            <?php } ?>
            <?php function articleEditingfooterTemplate(){ ?>

            <section class="">
                <!-- Footer -->
                <footer class="text-center text-white bg-dark">
                    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                        © 2024 Copyright:
                        <a class="text-white" href="#">Saturn</a>
                    </div>

                </footer>

            </section>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



        </body>

        </html>

        <?php } ?>
        <?php function footerTemplate(){ ?>

        <section class="">
            <!-- Footer -->
            <footer class="text-center text-white bg-dark">
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © 2024 Copyright:
                    <a class="text-white" href="#">Saturn</a>
                </div>

            </footer>

        </section>
        <!-- Popper.js -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>





    </body>

    </html>

    <?php } ?>