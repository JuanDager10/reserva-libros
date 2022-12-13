<?php

include '../Templates/header.php';
include_once BASE_URL . "/Controllers/LibroController.php";
include_once BASE_URL . "/Controllers/ReservaController.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$user = $_SESSION['activeUser'];

$inicio = '../Auth/login.php';
$cerrarSesion = $_SERVER['PHP_SELF'];


$libro = new LibroController();
$reserva = new ReservaController();


if (!empty($user['nombre'])) {
    include '../Templates/navigation.php';

    if($user['nombre'] == 'admin'){
        header('location: ../Admin/index.php');
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('location: ../Auth/login.php');
    }

    if (isset($_POST['reservar'])) {
        $msg = $reserva->create($_POST);
    }

    if (isset($_POST['entregar'])) {
        $reserva->delete($_POST);
    }
} else {
    header('location: ../Auth/login.php');
}

$librosData = $libro->index()->data;
$reservaData = $reserva->index($user['idUsuarios']);
$totalAPagar = $reserva->getTotalPayment($user['idUsuarios'])

?>
<?php if (isset($msg)) { ?>
      <div class="alert alert-<?= $msg->status ?> mb-0" role="alert"> <?= $msg->msj; ?> </div>
    <?php }?>

<div class="d-flex">

    <div class="card bg-light mb-3" style="width: 20rem;max-width: 20rem;">
        <div class="card-header">Libros reservados</div>
        <div class="card-body">

            <?php
            foreach ($reservaData->data as $row) {
                echo "<h5 class='card-title'>{$row['titulo']}</h5>
                <img src='../../Resource/img/{$row['fotos']}' class='img-fluid img-thumbnail' alt='...'>
                <p class='card-text' style='text-align: left' ><strong>fecha entrega:  </strong>{$row['fecha_entrega']}</p>
                <p class='card-text' style='text-align: left' ><strong>reservados:  </strong>{$row['cantidad']}</p>

                <form action='{$_SERVER['PHP_SELF']}' method='POST'>
                <input type='text' name='idReserva' value='{$row['idReserva']}' style='display:none' >
                <input type='text' name='idLibro' value='{$row['idLibros']}' style='display:none' >
                <input type='text' name='cantidad' value='{$row['cantidad']}' style='display:none' >

                <input name='entregar'class='btn btn-success' type='submit' value='entregar'>
                </form>
                <hr>
            ";
            }
            ?>
            <p><Strong>Total a pagar: </Strong> $<?=$totalAPagar->data[0]['total']?></p>

        </div>
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
                            <form action='{$_SERVER['PHP_SELF']}' method='POST'>
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
                                            <p>Solicitar</p>
                                            <input id='form1' min='0' name='cantidad' value='2' type='number' class='form-control form-control-sm' />
    
                                        </div>
    
                                        <div class='col-md-3 col-lg-2 col-xl-2 offset-lg-1'>
                                            <h5 class='mb-0'>$ {$row['precio']}</h5>
                                            <br>
                                            <input type='text' name='idLibro' id='' style='display: none;' value='{$row['idLibros']}'>
                                            <input type='text' name='idUsuario' id='' style='display: none;' value='{$user['idUsuarios']}'>
                                            <input type='submit' name='reservar' class='btn btn-primary' value='reservar'>
                                        </div>
    
                                    </div>
                                </div>
                            </form>
                        </div>
                        ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</div>



    <!--

                <div class="card mb-4">
                    <div class="card-body p-4 d-flex flex-row">
                        <div class="form-outline flex-fill">
                            <input type="text" id="form1" class="form-control form-control-lg" />
                            <label class="form-label" for="form1">Discound code</label>
                        </div>
                        <button type="button" class="btn btn-outline-warning btn-lg ms-3">Apply</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-warning btn-block btn-lg">Proceed to Pay</button>
                    </div>
                </div>-->