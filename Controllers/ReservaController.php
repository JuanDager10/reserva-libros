<?php

use LDAP\Result;

include_once BASE_URL."/Models/Reserva.php";

class ReservaController extends Conexion
{

  public function create(){
    $reserva = new Reserva();
    $reserva->idUsuario = $_POST['idUsuario'];
    $reserva->idLibro = $_POST['idLibro'];
    $reserva->cantidad = $_POST['cantidad'];
    return $reserva->create();
  }


  public function index($idUsuario)
  {
    $reserva = new Reserva();
    $reserva->idUsuario = $idUsuario;
    return $reserva->index();
  }

  public function delete()
  {
    $reserva = new Reserva();
    $reserva->id = $_POST['idReserva'];
    $reserva->idLibro = $_POST['idLibro'];
    $reserva->cantidad = $_POST['cantidad'];
    return $reserva->delete();
  }

  

  public function getTotalPayment($idUsuario)
  {
    $reserva = new Reserva();
    $reserva->idUsuario = $idUsuario;
    return $reserva->getTotalPayment();
  }

}