<?php include '../Templates/header.php';
include_once BASE_URL . "/Controllers/UsuarioController.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST['opcion'] == 'iniciarSesion') {

    $usuario = new UsuarioController();
    $msg = $usuario->iniciarSesion($_POST);

    if($msg->msj == "sesion iniciada"){
      session_start();
      $_SESSION['activeUser'] = $msg->data;
      $test = "bienvenido";
      header('location: ../Home/index.php');
    }
  }
}


?>


<!-- Pills content -->
<div class="row d-flex justify-content-center">

  <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" class="col-md-4 mt-4">

    <div class="text-center mb-5 mt-3">
      <h1>Sign in</h1>
    </div>

    <input type="hidden" name="opcion" value="iniciarSesion">
    <?php if (isset($msg)) { ?>
      <div class="alert alert-<?= $msg->status ?>" role="alert"> <?= $msg->msj; ?> </div>
    <?php }?>

    <!-- Email input -->
    <div class="form-outline mb-4">
      <label class="form-label" for="loginName">Email</label>
      <input name="email" type="email" id="loginName" class="form-control" />
    </div>

    <!-- Password input -->
    <div class="form-outline mb-4">
      <label class="form-label" for="loginPassword">Password</label>
      <input name="password" type="password" id="loginPassword" class="form-control" />
    </div>


    <!-- Submit button -->
    <div class="text-center">
      <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
    </div>

    <!-- Register buttons -->
    <div class="text-center">
      <p>No tienes una cuenta? <a href="register.php">Register</a></p>
    </div>
  </form>
</div>