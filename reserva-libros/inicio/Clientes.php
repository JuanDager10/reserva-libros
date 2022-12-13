<?php
include_once "Conexion.php";

class Clientes extends Conexion
{
    public $nombre;
    public $telefono;

    public function create()
    {
        $this->conectar();
        $pre = mysqli_prepare($this->con,"INSERT INTO `clientes`(`nombre`, `telefono`) VALUES (?,?)");
        $pre->bind_param('ss',$this->nombre,$this->telefono);
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
}