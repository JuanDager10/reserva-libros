<?php

include '../Templates/header.php';
include_once BASE_URL . "/Controllers/LibroController.php";
include_once BASE_URL . "/Controllers/ReservaController.php";
include_once BASE_URL . "/Controllers/CategoriaController.php";


ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

$user = $_SESSION['activeUser'];

$inicio = '../Auth/login.php';
$cerrarSesion = $_SERVER['PHP_SELF'];


$libro = new LibroController();
$categoria = new CategoriaController();


$libroSave;


if (!empty($user['nombre'])) {
    
    if ($user['nombre'] == 'admin') {
        include '../Templates/navigation.php';
        
        if (isset($_POST['logout'])) {
            session_destroy();
            header('location: ../Auth/login.php');
        }

        if (isset($_POST['guardarLibro'])) {
            $libroSave = $libro->store($_POST);
        }

        if(isset($_POST['guardarCategoria'])){
            $categoria->store($_POST);
        }

        if(isset($_POST['eliminarLibro'])){
            $libroSave = $libro->destroy($_POST);
        }

        if(isset($_POST['actualizar'])){
            $libroSave = $libro->update($_POST);
            
        }


    } else {
        session_destroy();
        header('location: ../Auth/login.php');
    }

} else {
    header('location: ../Auth/login.php');
}

$librosData = $libro->index()->data;
$categoriaData = $categoria->index()->data;


if(isset($_POST['actualizarLibro'])){
    $libroData = $libro->get($_POST);


?>



<?php if (isset($libroSave->msj)) { ?>
      <div class="alert alert-<?= $libroSave->status ?>" role="alert"> <?= $libroSave->msj; ?> </div>
    <?php }?>

<div class="row d-flex justify-content-center">

<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="col-md-4 mt-4">

        <div class="text-center mb-5 mt-3">
            <h1>Registro de libro</h1>
        </div>   

    <input name="idExistencia" style="display: none" value="<?= $libroData->data[0]['idExistencia']?>" />
    <input name="id" style="display: none" value="<?= $libroData->data[0]['idLibros']?>" />



        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Titulo</label>
            <input name="titulo" id="loginName" class="form-control" value="<?= $libroData->data[0]['titulo']?>" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Existencia</label>
            <input name="existencia" id="loginName" class="form-control" value="<?= $libroData->data[0]['disponibilidad']?>"/>
        </div>


        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Categoria</label>
            <select name="categoria" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option selected value="<?= $libroData->data[0]['idCategoria']?>">  <?= $libroData->data[0]['Categoria']?>  </option>
                <?php
                foreach ($categoriaData as $row) {
                    echo "<option value='{$row['idCategoria']}' >{$row['nombre']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="autor">autor</label>
            <input value="<?= $libroData->data[0]['autor']?>" name="autor" id="autor" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="precio">precio</label>
            <input name="precio" id="precio" class="form-control" value="<?= $libroData->data[0]['precio']?>"/>
        </div>


        <div class="form-outline mb-4">
            <label class="form-label" for="resumen">Resumen</label>
            <textarea maxlenght="200" name="resumen" id="resumen" cols="52" rows="10"><?= $libroData->data[0]['resumen']?></textarea>
        </div>

        <div class='col-md-2 col-lg-2 col-xl-2'>
        <label class="form-label" for="protada">Portada</label>
            <br>
                    <img src='../../Resource/img/<?= $libroData->data[0]['fotos']?>' class='img-fluid rounded-3' alt='Cotton T-shirt'>
                    </div>
                    <br>
        <div class="form-outline mb-4">
            
            <input name="foto" class="form-control" id='portada' type="file" >
        </div>

        <!-- Submit button -->
        <div class="text-center">
            <input name="actualizar" type='submit' class="btn btn-info btn-block mb-4" value='Actualizar libro'>
        </div>

    </form>
</div>

<?php } else {?>









<div class="row d-flex justify-content-center">

    
    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="col-md-4 mt-4">

        <div class="text-center mb-5 mt-3">
            <h1>Registro de libro</h1>
        </div>

  


        <?php if (isset($libroSave->msj)) { ?>
      <div class="alert alert-<?= $libroSave->status ?>" role="alert"> <?= $libroSave->msj; ?> </div>
    <?php }?>

      


        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Titulo</label>
            <input name="titulo" id="loginName" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Existencia</label>
            <input name="existencia" id="loginName" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="loginName">Categoria</label>
            <select name="categoria" class="form-select form-select-sm" aria-label=".form-select-sm example">

                <?php
                foreach ($categoriaData as $row) {
                    echo "<option value='{$row['idCategoria']}' selected>{$row['nombre']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="autor">autor</label>
            <input name="autor" id="autor" class="form-control" />
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="precio">precio</label>
            <input name="precio" id="precio" class="form-control" />
        </div>


        <div class="form-outline mb-4">
            <label class="form-label" for="resumen">Resumen</label>
            <textarea name="resumen" id="resumen" cols="52" rows="10"></textarea>
        </div>

        

        <div class="form-outline mb-4">
            <label class="form-label" for="protada">Portada</label>
            <br>
            <input name="foto" class="form-control" id='portada' type="file" >
        </div>

        <!-- Submit button -->
        <div class="text-center">
            <button name="guardarLibro" class="btn btn-primary btn-block mb-4">Guardar libro</button>
        </div>

    </form>

    <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="col-md-4 mt-4">

    <div class="form-outline mb-4">
        <div class="text-center mb-5 mt-3">
            <h1>Registro de categorias</h1>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="autor">Categoria</label>
            <input name="categoria" id="autor" class="form-control" />
        </div>  


        <div class="text-center">
            <button name="guardarCategoria" class="btn btn-primary btn-block mb-4">Guardar categoria</button>
        </div>
    </form>


</div>


<section class="h-100" style="background-color: #eee;">
    <div class="container h-100 py-5">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-10">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-normal mb-0 text-black">Libros</h3>
                </div>

                <?php
                foreach ($librosData as $row) {
                    echo "<div class='card rounded-3 mb-4'>
                    <div class='card-body p-4'>
                    <div class='row d-flex justify-content-between align-items-center'>
                    <div class='col-md-2 col-lg-2 col-xl-2'>
                    <img src='../../Resource/img/{$row['fotos']}' class='img-fluid rounded-3' alt='Cotton T-shirt'>
                    </div>
                    <div class='col-md-3 col-lg-3 col-xl-3'>
                    <p class='lead fw-normal mb-2'>{$row['titulo']}</p>
                    <p>{$row['resumen']}</p>
                    </div>
                    
                    
                    <div class='col-md-3 col-lg-3 col-xl-2 d-flex flex-column'>
                    
                    <p class='lead fw-normal'>Disponibilidad </p>
                    <p class='mb-5'>{$row['disponibilidad']}</p>
                    <form action='{$_SERVER['PHP_SELF']}' method='POST'>

                                            <input style='display:none' name='idLibros' type='text' value='{$row['idLibros']}'>
                                            <div class='text-center'>
                                                <input type='submit' name='eliminarLibro' class='btn btn-danger btn-block mb-4' value='Eliminar'>
                                            </div>
                                            </form>
                                            <form action='{$_SERVER['PHP_SELF']}' method='POST'>

                                            <input style='display:none' name='idLibros' type='text' value='{$row['idLibros']}'>
                                            <div class='text-center'>
                                                <input type='submit' name='actualizarLibro' class='btn btn-info btn-block mb-4' value='Actualizar'>
                                            </div>
                                            </form>
                                            
                                            </div>
                                            
                                            </div>
                                            </div>
                                            </div>
                        ";
                }
                ?>
            </div>
        </div>
    </div>
</section>
</div>

<?php } ?>