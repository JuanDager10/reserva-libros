<?php
include_once BASE_URL . "/Conexion/Conexion.php";

class Libro extends Conexion
{
    public $id;
    public $categoria;
    public $titulo;
    public $autor;
    public $resumen;
    public $fotos;
    public $existencia;

    public function store()
    {
        $this->conectar();
        
        $pre = mysqli_prepare($this->con, "INSERT INTO Libros ( `Categoria_idCategoria`, `titulo`, `autor`, `resumen`, `fotos`, `precio`) VALUES (?,?,?,?,?,?)");
        $pre->bind_param('issssi', $this->categoria, $this->titulo, $this->autor, $this->resumen, $this->fotos, $this->precio);
        $pre->execute();

        $id = $pre->insert_id;

        $pre = mysqli_prepare($this->con, "INSERT INTO `Existencia`(`Libros_idLibros`, `cantidad`, `disponibilidad`) VALUES (?, ?, ?);");
        $pre->bind_param('iii', $id, $this->existencia, $this->existencia);
        $pre->execute();

        $alert = new stdClass();

        if ($pre->error) {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->msj = "Datos Guardados...";
            $alert->data = $pre->insert_id;
            $alert->status = 'success';
        }
        return $alert;
    }

    public function index()
    {
        $this->conectar();

        $result = mysqli_query($this->con, "SELECT L.idLibros, L.titulo, L.resumen, E.disponibilidad, L.precio, C.nombre AS Categoria, L.fotos FROM Libros AS L INNER JOIN Categoria AS C ON C.idCategoria = L.Categoria_idCategoria INNER JOIN Existencia AS E ON E.Libros_idLibros = L.idLibros");
        $data = $result->fetch_all(MYSQLI_ASSOC);


        $alert = new stdClass();

        if (!$result) {
            $alert->msj = mysqli_errno($this->con);
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->data = $data;
            $alert->msj = "consulta de libro exitosa";
            $alert->status = 'success';
        }
        return $alert;
    }




}
