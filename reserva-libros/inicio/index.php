<?php
include_once "Clientes.php";

$cliente = new Clientes();
$cliente->nombre = 'rodrigo';
$cliente->telefono = '8888';
$msg = $cliente->create();
var_dump($msg);


/*
BEGIN
	INSERT INTO log(evento) VALUE(CONCAT('Nuevo Registro ',NEW.NOMBRE));
END
*/