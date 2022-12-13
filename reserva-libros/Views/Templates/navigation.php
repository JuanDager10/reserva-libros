<div class="bg-dark">
  <div class="container">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between">
      <a class="navbar-brand" href="#">
        <div class="mb-2">

          <img src="../../Resource/img/logo-book.png" width="30" height="30" class="d-inline-block align-top" alt="">
          Reserva de Libros
        </div>
          <p style="color: white; margin: 0px;font-size: 14px"><strong>Usuario: </strong><?=$user['nombre']?></p>
      </a>
      <div class="form-inline">
        <form action="<?php echo $cerrarSesion?>" method="POST">
        <?php echo $cerrarSesion ?>
        <input type="submit" class="btn btn-primary btn-lg" name="logout" value="Cerrar Sesion">
        </form>
      </div>
    </nav>
  </div>
</div>