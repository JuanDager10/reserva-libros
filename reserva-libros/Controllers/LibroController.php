<?php

include_once BASE_URL."/Models/Libro.php";

class LibroController extends Conexion
{

  public function index(){
    $libros = new Libro();
    return $libros->index();
  }

  public function store(){
    $libro = new Libro();
    $libro->titulo = $_POST['titulo'];
    $libro->resumen = $_POST['resumen'];
    $libro->categoria = $_POST['categoria'];
    $libro->precio = $_POST['precio'];
    $libro->autor = $_POST['autor'];
    $libro->existencia = $_POST['existencia'];

    $libro->fotos = $_FILES['foto']['name'];

    $name = $_SERVER['DOCUMENT_ROOT'] ."/reserva-libros/Resource/img/". $libro->fotos;
    $tmp_name = $_FILES['foto']['tmp_name'];

    move_uploaded_file($tmp_name, $name);

   return $libro->store();
   
  }

}