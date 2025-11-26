<?php
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../config/db.php';

class ReservaController
{
    public static function obtenerTodas()
    {
        return Reserva::obtenerReservas();
    }

    public static function obtenerPorUsuario($id_usuario)
    {
        return Reserva::obtenerReservasPorUsuario($id_usuario);
    }

    public static function crear($id_usuario, $fecha, $hora, $cantidad_personas, $comentario)
    {
        return Reserva::crearReserva($id_usuario, $fecha, $hora, $cantidad_personas, $comentario);
    }

    public static function eliminar($id)
    {
        return Reserva::eliminarReserva($id);
    }
}