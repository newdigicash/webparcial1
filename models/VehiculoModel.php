<?php

require_once __DIR__ . '/Vehiculo.php';
require_once __DIR__ . '/../config/database.php';

class VehiculoModel
{
    private ?PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conectar();
        $this->validarTabla();
    }

    /**
     * Valida que exista conexión y que la tabla Vehiculos esté disponible.
     *
     * @throws Exception si falla la conexión o la consulta de validación
     */
    private function validarTabla(): void
    {
        if ($this->db === null) {
            throw new Exception("Error de conexión: No se ha podido conectar a la base de datos. ");
        }

        try {
            $stmt = $this->db->query("SHOW TABLES LIKE 'Vehiculos'");
            if ($stmt->rowCount() === 0) {
                throw new Exception("La tabla Vehiculos no existe en la base de datos. ");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al verificar la tabla en la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la lista de vehículos.
     *
     * @return Vehiculo[]
     */
    public function getAllVehiculos(): array
    {
        $query = 'SELECT * FROM Vehiculos';
        $stmt = $this->db->query($query);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $vehiculos = [];
        foreach ($filas as $fila) {
            $vehiculos[] = $this->convertirVehiculo($fila);
        }

        return $vehiculos;
    }

    /**
     * Obtiene un vehículo por su ID.
     */
    public function getById(int $id): ?Vehiculo
    {
        $query = 'SELECT * FROM Vehiculos WHERE vehiculo_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila === false) {
            return null;
        }

        return $this->convertirVehiculo($fila);
    }

    /**
     * Guarda un nuevo vehículo en la base de datos.
     */
    public function crear(Vehiculo $vehiculo): bool
    {
        $query = 'INSERT INTO Vehiculos (marca, modelo, anio, disponible) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);

        $ok = $stmt->execute([
            $vehiculo->getMarca(),
            $vehiculo->getModelo(),
            $vehiculo->getAnio(),
            $vehiculo->isDisponible() ? 1 : 0,
        ]);

        if ($ok) {
            $lastId = (int) $this->db->lastInsertId();
            if ($lastId > 0) {
                $vehiculo->setVehiculoId($lastId);
            }
        }

        return $ok;
    }

    /**
     * Actualiza los datos de un vehículo existente.
     */
    public function actualizar(Vehiculo $vehiculo): bool
    {
        $query = 'UPDATE Vehiculos SET marca = ?, modelo = ?, anio = ?, disponible = ? WHERE vehiculo_id = ?';
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $vehiculo->getMarca(),
            $vehiculo->getModelo(),
            $vehiculo->getAnio(),
            $vehiculo->isDisponible() ? 1 : 0,
            $vehiculo->getVehiculoId(),
        ]);
    }

    /**
     * Elimina un vehículo por su ID.
     */
    public function eliminar(int $id): bool
    {
        $query = 'DELETE FROM Vehiculos WHERE vehiculo_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    /**
    * Actualiza únicamente el estado de disponibilidad de un vehículo.
    */
    public function actualizarDisponibilidad(int $vehiculoId, bool $disponible): bool
    {
        $query = 'UPDATE Vehiculos SET disponible = ? WHERE vehiculo_id = ?';
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $disponible ? 1 : 0,
            $vehiculoId,
        ]);
    }

    private function convertirVehiculo(array $fila): Vehiculo
    {
        $vehiculo = new Vehiculo();
        $vehiculo->setVehiculoId((int) $fila['vehiculo_id']);
        $vehiculo->setMarca((string) $fila['marca']);
        $vehiculo->setModelo((string) $fila['modelo']);
        $vehiculo->setAnio((int) $fila['anio']);
        $vehiculo->setDisponible((bool) $fila['disponible']);

        return $vehiculo;
    }

}
