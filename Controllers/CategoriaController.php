<?php

include_once BASE_URL."/Models/Categoria.php";

class CategoriaController extends Conexion
{
  public function store(){
    $categoria = new Categoria();
    $categoria->nombre = $_POST['categoria'];
    return $categoria->store();
  }

  public function index()
  {
    $categoria = new Categoria();
    return $categoria->index();
  }

}