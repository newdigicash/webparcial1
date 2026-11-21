<?php

require_once __DIR__ . '/Alquiler.php';

class AlquilerDetalle extends Alquiler
{
    private string $detalleCliente;
    private string $detalleVehiculo;

    public function getDetalleCliente(): string
    {
        return $this->detalleCliente;
    }

    public function setDetalleCliente(string $detalleCliente): void
    {
        $this->detalleCliente = $detalleCliente;
    }

    public function getDetalleVehiculo(): string
    {
        return $this->detalleVehiculo;
    }

    public function setDetalleVehiculo(string $detalleVehiculo): void
    {
        $this->detalleVehiculo = $detalleVehiculo;
    }
}
