<?php
include_once BASE_URL . "/Conexion/Conexion.php";

class Reserva extends Conexion
{
    public $id;
    public $idLibro;
    public $idUsuario;
    public $cantidad;


    public function create()
    {

        $this->conectar();
        $alert = new stdClass();

        try {
            $pre = mysqli_prepare($this->con, "CALL RESTAR_DISPONIBILIDAD(?, ?)");
            $pre->bind_param('ii', $this->idLibro, $this->cantidad);
            $pre->execute();

            $pre = mysqli_prepare($this->con, "INSERT INTO `Reserva`(`Libros_idLibros`, `Usuarios_idUsuarios`, `cantidad`) VALUES (?, ?, ?)");
            $pre->bind_param('iii', $this->idLibro, $this->idUsuario, $this->cantidad);
            $pre->execute();
    
    
            if ($pre->error) {
                $alert->msj = $pre->error;
                $alert->data = 0;
                $alert->status = 'danger';
            } else {
                $alert->msj = "Reserva Realizada...";
                $alert->data = $pre->insert_id;
                $alert->status = 'success';
            }

    
            
        } catch (Exception $e) {
            $alert->msj = '¡disponibilidad insuficiente!';
            $alert->data = 0;
            $alert->status = 'danger';
        }
        
        return $alert;
    }


    public function index()
    {
        $this->conectar();

        $pre = mysqli_prepare($this->con, "SELECT R.idReserva, L.idLibros, R.cantidad, L.titulo, R.fecha_entrega, L.fotos FROM Reserva AS R INNER JOIN Libros AS L ON L.idLibros = R.Libros_idLibros WHERE R.Usuarios_idUsuarios = ?");
        $pre->bind_param("i", $this->idUsuario);
        $pre->execute();
        $result = $pre->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $alert = new stdClass();

        if ($pre->error) {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->data = $data;
            $alert->msj = 'consulta de reserva exitosa';
            $alert->status = 'success';
        }
        return $alert;
    }


    public function getTotalPayment()
    {
        $this->conectar();

        $pre = mysqli_prepare($this->con, "SELECT TOTAL_A_PAGAR(?) AS total");
        $pre->bind_param("i", $this->idUsuario);
        $pre->execute();
        $result = $pre->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);

        $alert = new stdClass();

        if ($pre->error) {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->data = $data;
            $alert->msj = 'consulta de reserva exitosa';
            $alert->status = 'success';
        }
        return $alert;
    }


    public function delete()
    {
        $this->conectar();
        $pre = mysqli_prepare($this->con, "DELETE FROM Reserva WHERE idReserva = ?");
        $pre->bind_param('i', $this->id);
        $pre->execute();


        $alert = new stdClass();

        if ($pre->error) {
            $alert->msj = $pre->error;
            $alert->data = 0;
            $alert->status = 'danger';
        } else {
            $alert->msj = "Reserva Realizada...";
            $alert->data = $pre->insert_id;
            $alert->status = 'success';
        }


        $pre = mysqli_prepare($this->con, "CALL AUMENTAR_DISPONIBILIDAD(?, ?)");
        $pre->bind_param('ii', $this->idLibro, $this->cantidad);
        $pre->execute();

        return $alert;
    }
}
