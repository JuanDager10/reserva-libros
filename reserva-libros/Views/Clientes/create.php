<?php
include '../Templates/header.php';
include_once BASE_URL."/Controllers/ClienteController.php";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if ($_POST['opcion']=='create')
  {
    $cliente = new ClienteController();
    $msg = $cliente->CrearCliente($_POST);
  }
}
?>
<div class="container">
  <form name="crear" action="<?= $_SERVER['PHP_SELF'];?>" method="POST">
  <input type="hidden" name="opcion" value="create">
  
    <div class="mb-1">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" class="form-control" name="nombre">
    </div>
    <div class="mb-1">
      <label for="correo" class="form-label">Correo</label>
      <input type="text" class="form-control" name="correo">
    </div>
    <div class="mb-1">
      <label for="cedula" class="form-label">Cedula</label>
      <input type="number" class="form-control" name="cedula">
    </div>
    <div class="mb-4">
      <label for="edad" class="form-label">Edad</label>
      <input type="number" class="form-control" name="edad">
    </div>
    <?php if (isset($msg)){ ?>
      <div class="alert alert-<?= $msg->status ?>" role="alert"> <?= $msg->msj ?> </div>
    <?php } ?>
    <div class="mb-3">
      <a href="index.php" class="btn btn-danger"><i class="fa fa-close "></i> Cancelar</a>
      <button type="submit" class="btn btn-success"><i class="fa fa-cloud-upload"></i> Guardar</button>
    </div>
  </form>
</div>

<?php include '../Templates/footer.php'; ?>
