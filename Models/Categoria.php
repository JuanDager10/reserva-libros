<?php
include_once BASE_URL."/Conexion/Conexion.php";

class Categoria extends Conexion
{
    public $nombre;

    public function store()
    {
        $this->conectar();
        $pre = mysqli_prepare($this->con,"INSERT INTO `Categoria`(`nombre`) VALUES (?)");
        $pre->bind_param('s',$this->nombre);
        $alert = new stdClass();
        try {
            $pre->execute();
            $alert->msj = "Datos Guardados...";
            $alert->data = $pre->insert_id;
            $alert->status = 'success';
        } catch (Exception $e) {
            $alert->msj = $e->getMessage();
            $alert->data = 0;
            $alert->status = 'danger';
        }
        return $alert;
    }

    public function index()
    {
        $this->conectar();

        $result = mysqli_query($this->con, "SELECT nombre, idCategoria FROM `Categoria` ");
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