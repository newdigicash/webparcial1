<?php

class Cliente
{
    private int $clienteId;
    private string $nombre;
    private string $apellido;
    private string $licencia;
    private string $telefono;

    public function getClienteId(): int
    {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): void
    {
        $this->clienteId = $clienteId;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getLicencia(): string
    {
        return $this->licencia;
    }

    public function setLicencia(string $licencia): void
    {
        $this->licencia = $licencia;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }
}
