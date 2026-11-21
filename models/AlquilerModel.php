<?php

require_once __DIR__ . '/Alquiler.php';
require_once __DIR__ . '/AlquilerDetalle.php';
require_once __DIR__ . '/../config/database.php';

class AlquilerModel
{
    private ?PDO $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->conectar();
        $this->validarTabla();
    }

    /**
     * Valida que exista conexión y que la tabla Alquileres esté disponible.
     *
     * @throws Exception si falla la conexión o la consulta de validación
     */
    private function validarTabla(): void
    {
        if ($this->db === null) {
            throw new Exception("Error de conexión: No se ha podido conectar a la base de datos. ");
        }

        try {
            $stmt = $this->db->query("SHOW TABLES LIKE 'Alquileres'");
            if ($stmt->rowCount() === 0) {
                throw new Exception("La tabla Alquileres no existe en la base de datos. ");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al verificar la tabla en la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la lista de alquileres.
     *
     * @return Alquiler[]
     */
    public function getAllAlquileres(): array
    {
        //alquiler_id, vehiculo_id, cliente_id, fecha_entrega, fecha_devolucion_estimada, fecha_devolucion, tarifa_hora, abono, total_pagado, estado
        $query = 'SELECT * FROM Alquileres';
        $stmt = $this->db->query($query);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $alquileres = [];
        foreach ($filas as $fila) {
            $alquileres[] = $this->convertirAlquiler($fila);
        }

        return $alquileres;
    }

    /**
     ** Devuelve la lista de alquileres con detalle de cliente y vehículo.
     * @return AlquilerView[]
     */
    public function getAllDetalleAlquiler(): array {
        $query = 'SELECT a.alquiler_id,
        a.vehiculo_id,
        a.cliente_id,
        a.fecha_entrega,
        a.fecha_devolucion_estimada,
        a.fecha_devolucion,
        a.tarifa_hora,
        a.abono,
        a.total_pagado,
        a.estado,
        c.nombre,
        c.apellido,
        v.marca,
        v.modelo,
        v.anio
        FROM Alquileres a
        INNER JOIN Clientes c ON a.cliente_id = c.cliente_id
        INNER JOIN Vehiculos v ON a.vehiculo_id = v.vehiculo_id';

        $stmt = $this->db->query($query);
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $detalles = [];
        foreach ($filas as $fila) {
            $view = new AlquilerDetalle();
            $view->setAlquilerId((int) $fila['alquiler_id']);
            $view->setVehiculoId((int) $fila['vehiculo_id']);
            $view->setClienteId((int) $fila['cliente_id']);
            $view->setFechaEntrega((string) $fila['fecha_entrega']);
            $view->setFechaDevolucionEstimada((string) $fila['fecha_devolucion_estimada']);
            $view->setFechaDevolucion($fila['fecha_devolucion'] !== null ? (string) $fila['fecha_devolucion'] : null);
            $view->setTarifaHora((float) $fila['tarifa_hora']);
            $view->setAbono((float) $fila['abono']);
            $view->setTotalPagado((float) $fila['total_pagado']);
            $view->setEstado((string) $fila['estado']);
            $view->setDetalleCliente((string) $fila['nombre'] . ' ' . (string) $fila['apellido']);
            $view->setDetalleVehiculo((string) $fila['marca'] . ' ' . (string) $fila['modelo'] . ' ' . (string) $fila['anio']);

            $detalles[] = $view;
        }

        return $detalles;
    }

    /**
     * Obtiene un alquiler por su ID.
     */
    public function getById(int $id): ?Alquiler
    {
        $query = 'SELECT * FROM Alquileres WHERE alquiler_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila === false) {
            return null;
        }

        return $this->convertirAlquiler($fila);
    }

    /**
     * Guarda un nuevo alquiler en la base de datos.
     */
    public function crear(Alquiler $alquiler): bool
    {
        $query = 'INSERT INTO Alquileres (vehiculo_id, cliente_id, fecha_entrega, fecha_devolucion_estimada, fecha_devolucion, tarifa_hora, abono, total_pagado, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);

        $ok = $stmt->execute([
            $alquiler->getVehiculoId(),
            $alquiler->getClienteId(),
            $alquiler->getFechaEntrega(),
            $alquiler->getFechaDevolucionEstimada(),
            $alquiler->getFechaDevolucion(),
            $alquiler->getTarifaHora(),
            $alquiler->getAbono(),
            $alquiler->getTotalPagado(),
            $alquiler->getEstado(),
        ]);

        if ($ok) {
            $lastId = (int) $this->db->lastInsertId();
            if ($lastId > 0) {
                $alquiler->setAlquilerId($lastId);
            }
        }

        return $ok;
    }

    /**
     * Actualiza un alquiler existente.
     */
    public function actualizar(Alquiler $alquiler): bool
    {
        $query = 'UPDATE Alquileres SET vehiculo_id = ?, cliente_id = ?, fecha_entrega = ?, fecha_devolucion_estimada = ?, fecha_devolucion = ?, tarifa_hora = ?, abono = ?, total_pagado = ?, estado = ? WHERE alquiler_id = ?';
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $alquiler->getVehiculoId(),
            $alquiler->getClienteId(),
            $alquiler->getFechaEntrega(),
            $alquiler->getFechaDevolucionEstimada(),
            $alquiler->getFechaDevolucion(),
            $alquiler->getTarifaHora(),
            $alquiler->getAbono(),
            $alquiler->getTotalPagado(),
            $alquiler->getEstado(),
            $alquiler->getAlquilerId(),
        ]);
    }

    /**
     * Elimina un alquiler por su ID.
     */
    public function eliminar(int $id): bool
    {
        $query = 'DELETE FROM Alquileres WHERE alquiler_id = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    private function convertirAlquiler(array $fila): Alquiler
    {
        $alquiler = new Alquiler();
        $alquiler->setAlquilerId((int) $fila['alquiler_id']);
        $alquiler->setVehiculoId((int) $fila['vehiculo_id']);
        $alquiler->setClienteId((int) $fila['cliente_id']);
        $alquiler->setFechaEntrega((string) $fila['fecha_entrega']);
        $alquiler->setFechaDevolucionEstimada((string) $fila['fecha_devolucion_estimada']);
        $alquiler->setFechaDevolucion($fila['fecha_devolucion'] !== null ? (string) $fila['fecha_devolucion'] : null);
        $alquiler->setTarifaHora((float) $fila['tarifa_hora']);
        $alquiler->setAbono((float) $fila['abono']);
        $alquiler->setTotalPagado((float) $fila['total_pagado']);
        $alquiler->setEstado((string) $fila['estado']);

        return $alquiler;
    }

    /*private function convertirArray(Alquiler $alquiler): array
    {
        return [
            'alquiler_id' => $alquiler->getAlquilerId(),
            'vehiculo_id' => $alquiler->getVehiculoId(),
            'cliente_id' => $alquiler->getClienteId(),
            'fecha_entrega' => $alquiler->getFechaEntrega(),
            'fecha_devolucion_estimada' => $alquiler->getFechaDevolucionEstimada(),
            'fecha_devolucion' => $alquiler->getFechaDevolucion(),
            'tarifa_hora' => $alquiler->getTarifaHora(),
            'abono' => $alquiler->getAbono(),
            'total_pagado' => $alquiler->getTotalPagado(),
            'estado' => $alquiler->getEstado(),
        ];
        }*/
}
