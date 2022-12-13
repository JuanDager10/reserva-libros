<?php
include_once BASE_URL . "/Conexion/Conexion.php";

class Usuario extends Conexion
{
    public $nombre;
    public $email;
    public $password;



    public function create()
    {
        $this->conectar();

        $alert = new stdClass();

        try{

            $pass = password_hash($this->password, PASSWORD_DEFAULT);
            $pre = mysqli_prepare($this->con, "INSERT INTO `Usuarios`(`nombre`, `email`, `password_`) VALUES (?,?,?)");
            $pre->bind_param('sss', $this->nombre, $this->email, $pass);
            $pre->execute();

            if ($pre->error) {
                $alert->msj = $pre->error;
                $alert->data = 0;
                $alert->status = 'danger';
            } else {
                $alert->msj = "Datos Guardados...";
                $alert->data = $pre->insert_id;
                $alert->status = 'success';
            }

        } catch (Exception $e) {
            $alert->msj = '¡Usuario no disponible!';
            $alert->data = 0;
            $alert->status = 'danger';
        }
        

        return $alert;
    }

    public function iniciarSesion()
    {
        $this->conectar();

        $pre = mysqli_prepare($this->con, "SELECT * FROM `Usuarios` WHERE `email` LIKE ?");
        $pre->bind_param('s', $this->email);
        $pre->execute();
        $result = $pre->get_result();
        $user = $result->fetch_assoc();

        $alert = new stdClass();

        if ($pre->error) {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->data = $user;

            if (!empty($user['nombre'])) {

                if (password_verify($this->password, $user['password_'])) {
                    $alert->msj = "sesion iniciada";
                    $alert->status = "success";
                } else {
                    $alert->msj = "credenciales incorrectas!";
                    $alert->status = "danger";
                }
            } else {
                $alert->msj = "Usuario no existe!";
                $alert->status = 'danger';
            }
        }
        return $alert;
    }
}
