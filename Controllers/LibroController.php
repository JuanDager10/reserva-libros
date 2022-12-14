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

  public function destroy(){
    $libro = new Libro();
    
    $libro->id = $_POST['idLibros'];
   return $libro->destroy();
   
  }

  public function get(){
    $libro = new Libro();
    $libro->id = $_POST['idLibros'];
   return $libro->get();
   
  }

  public function update(){
    $libro = new Libro();
    $libro->id = $_POST['id'];
    $libro->titulo = $_POST['titulo'];
    $libro->resumen = $_POST['resumen'];
    $libro->categoria = $_POST['categoria'];
    $libro->precio = $_POST['precio'];
    $libro->autor = $_POST['autor'];
    $libro->disponibilidad = $_POST['existencia'];
    $libro->idExistencia = $_POST['idExistencia'];

    



    if(!empty($_FILES['foto']['name'])){
    $libro->fotos = $_FILES['foto']['name'];
    
    $name = $_SERVER['DOCUMENT_ROOT'] ."/reserva-libros/Resource/img/". $libro->fotos;
    $tmp_name = $_FILES['foto']['tmp_name'];
    
    move_uploaded_file($tmp_name, $name);
  } 
    else {
      $libro->fotos = $libro->get()->data[0]['fotos'];
    }



   return $libro->update();
   
  }


 

}