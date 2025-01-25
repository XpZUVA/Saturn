<?php include_once 'inc/ini.php'; 

session_start();

?>

<?php define("TITLE", "Iniciar Sesión"); ?>

<?php simpleHeaderTemplate(); 

if (isset($_SESSION['error_message'])) {?>
<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
    <?php echo $_SESSION['error_message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<?php unset($_SESSION['error_message']);}?>





<section class="vh-100 bg-image" style="background-image: url('assets/img/bg.png'); background-size: cover;">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-5">Inicie sesión</h2>

                            <form action="controller-persons.php" method="post" class="registerForm">

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="email" class="form-control form-control-lg" name="email"
                                        required />
                                    <label class="form-label" for="email">Tu Email</label>
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="password" class="form-control form-control-lg" required
                                        name="password" />
                                    <label class="form-label" for="password">Contraseña</label>
                                </div>
                                <input type="hidden" name="getPerson" value="1">
                                <div class="d-flex justify-content-center">
                                    <input type="submit" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-success btn-block btn-lg gradient-custom-4 text-white loginButton"
                                        value="Iniciar sesión" />
                                </div>
                            </form>

                            <p class="text-center text-muted mt-5 mb-0">¿No tienes una cuenta? <a href="register.php"
                                    class="fw-bold text-body"><u>Regístrese aquí</u></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php footerTemplate(); ?>

<?php include_once 'inc/end.php'; ?>