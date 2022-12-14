<?php
include_once BASE_URL . "/Conexion/Conexion.php";

class Libro extends Conexion
{
    public $id;
    public $idExistencia;
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

    public function destroy()
    {
        $this->conectar();
        
        $pre = mysqli_prepare($this->con, "DELETE FROM `Libros` WHERE `idLibros` = ?");
        $pre->bind_param('i', $this->id);
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


    public function get()
    {
        $this->conectar();

        $pre = mysqli_prepare($this->con, "SELECT L.idLibros,L.autor, L.titulo, L.resumen, E.idExistencia, E.disponibilidad, L.precio, C.idCategoria, C.nombre AS Categoria, L.fotos FROM Libros AS L INNER JOIN Categoria AS C ON C.idCategoria = L.Categoria_idCategoria INNER JOIN Existencia AS E ON E.Libros_idLibros = L.idLibros WHERE L.idLibros = ?");
        $pre->bind_param('i', $this->id);
        $pre->execute();

        $result = $pre->get_result();
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


    public function update()
    {
        
        $this->conectar();
        
        $pre = mysqli_prepare($this->con, "UPDATE `Existencia` SET `disponibilidad`= ? WHERE idExistencia = ?");
        $pre->bind_param('ii', $this->disponibilidad, $this->idExistencia);
        $pre->execute();

        $pre = mysqli_prepare($this->con, "UPDATE `Libros` SET `titulo`= ? ,`autor`= ?,`resumen`= ?,`fotos`= ?,`precio`= ?  WHERE `idLibros` = ?");
        $pre->bind_param('sssssi', $this->titulo, $this->autor, $this->resumen, $this->fotos, $this->precio, $this->id);
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


}
