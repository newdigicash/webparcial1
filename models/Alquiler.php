<?php

class Alquiler
{
    private int $alquilerId;
    private int $vehiculoId;
    private int $clienteId;
    private string $fechaEntrega;
    private string $fechaDevolucionEstimada;
    private ?string $fechaDevolucion = null;
    private float $tarifaHora;
    private float $abono;
    private float $totalPagado;
    private string $estado;

    public function getAlquilerId(): int
    {
        return $this->alquilerId;
    }

    public function setAlquilerId(int $alquilerId): void
    {
        $this->alquilerId = $alquilerId;
    }

    public function getVehiculoId(): int
    {
        return $this->vehiculoId;
    }

    public function setVehiculoId(int $vehiculoId): void
    {
        $this->vehiculoId = $vehiculoId;
    }

    public function getClienteId(): int
    {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): void
    {
        $this->clienteId = $clienteId;
    }

    public function getFechaEntrega(): string
    {
        return $this->fechaEntrega;
    }

    public function setFechaEntrega(string $fechaEntrega): void
    {
        $this->fechaEntrega = $fechaEntrega;
    }

    public function getFechaDevolucionEstimada(): string
    {
        return $this->fechaDevolucionEstimada;
    }

    public function setFechaDevolucionEstimada(string $fechaDevolucionEstimada): void
    {
        $this->fechaDevolucionEstimada = $fechaDevolucionEstimada;
    }

    public function getFechaDevolucion(): ?string
    {
        return $this->fechaDevolucion;
    }

    public function setFechaDevolucion(?string $fechaDevolucion): void
    {
        $this->fechaDevolucion = $fechaDevolucion;
    }

    public function getTarifaHora(): float
    {
        return $this->tarifaHora;
    }

    public function setTarifaHora(float $tarifaHora): void
    {
        $this->tarifaHora = $tarifaHora;
    }

    public function getAbono(): float
    {
        return $this->abono;
    }

    public function setAbono(float $abono): void
    {
        $this->abono = $abono;
    }

    public function getTotalPagado(): float
    {
        return $this->totalPagado;
    }

    public function setTotalPagado(float $totalPagado): void
    {
        $this->totalPagado = $totalPagado;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }
}
