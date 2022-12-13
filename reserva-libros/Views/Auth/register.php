<?php include '../Templates/header.php';

include_once BASE_URL . "/Controllers/UsuarioController.php";


ini_set('display_errors', 1);
error_reporting(E_ALL);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['opcion'] == 'create') {

        $usuario = new UsuarioController();
        $msg = $usuario->CrearUsuario($_POST);
        
    }
}

?>


<div class="row d-flex justify-content-center ">

    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="col-md-4 mt-4">
        <div class="text-center mb-3">
            <h1>Sign up</h1>
        </div>

        <input type="hidden" name="opcion" value="create">

        <?php if (isset($msg)) { ?>
            <div class="alert alert-<?= $msg->status ?>" role="alert"> <?= $msg->msj?> </div>
        <?php } ?>

        <!-- Name input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="registerName">Name</label>
            <input name="nombre" type="text" id="registerName" class="form-control" />
        </div>

        <!-- Email input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="registerEmail">Email</label>
            <input name="email" type="email" id="registerEmail" class="form-control" />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="registerPassword">Password</label>
            <input name="password" type="password" id="registerPassword" class="form-control" />
        </div>

        <!-- Repeat Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="registerRepeatPassword">Repeat password</label>
            <input type="password" id="registerRepeatPassword" class="form-control" />
        </div>


        <!-- Submit button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block mb-3 text-center">Sign in</button>
        </div>


        <div class="text-center">
            <p>Ya tienes una cuenta? <a href="login.php">Login</a></p>
        </div>
    </form>

</div>