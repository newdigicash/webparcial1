<?php

class Vehiculo
{
    private int $vehiculoId;
    private string $marca;
    private string $modelo;
    private int $anio;
    private bool $disponible;

    public function getVehiculoId(): int
    {
        return $this->vehiculoId;
    }

    public function setVehiculoId(int $vehiculoId): void
    {
        $this->vehiculoId = $vehiculoId;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function setAnio(int $anio): void
    {
        $this->anio = $anio;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }
}
