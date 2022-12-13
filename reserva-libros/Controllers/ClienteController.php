<?php

include_once BASE_URL."/Models/Cliente.php";

class ClienteController extends Conexion
{
  public function CrearCliente(){
    $cliente = new Cliente();
    $cliente->nombre = $_POST['nombre'];
    $cliente->correo = $_POST['correo'];
    $cliente->cedula = $_POST['cedula'];
    $cliente->edad = $_POST['edad'];
    return $cliente->create();
  }

}