<?php
include_once BASE_URL."/Conexion/Conexion.php";

class Cliente extends Conexion
{
    public $correo;
    public $cedula;
    public $nombre;
    public $edad;
    public $usuario;

    public function create()
    {
        $this->conectar();
        $pre = mysqli_prepare($this->con,"INSERT INTO `clientes`(`correo`, `cedula`, `nombre`, `edad`) VALUES (?,?,?,?)");
        $pre->bind_param('sssi',$this->correo,$this->cedula,$this->nombre,$this->edad);
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