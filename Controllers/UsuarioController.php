<?php

include_once BASE_URL."/Models/Usuario.php";

class UsuarioController extends Conexion
{
  public function CrearUsuario(){
    $cliente = new Usuario();
    $cliente->nombre = $_POST['nombre'];
    $cliente->email = $_POST['email'];
    $cliente->password = $_POST['password'];
    return $cliente->create();
  }

  public function iniciarSesion(){
    $cliente = new Usuario();
    $cliente->email = $_POST['email'];
    $cliente->password = $_POST['password'];
    return $cliente->iniciarSesion();
  }



}