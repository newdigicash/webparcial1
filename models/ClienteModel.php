<?php
require_once 'Cliente.php';
require_once __DIR__ . '/../config/database.php';

class ClienteModel {
    private ?PDO $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar();
        $this->validarTabla();
    }

    /**
    Valida que se conecte y que la tabla este creada
    @throws Exception si falla la conexión o no existe la tabla
    */
    private function validarTabla(): void {
        if ($this->db === null) {
            throw new Exception("Error de conexión: No se ha podido conectar a la base de datos. ");
        }

        try {
            $stmt = $this->db->query("SHOW TABLES LIKE 'Clientes'");
            if ($stmt->rowCount() === 0) {
                throw new Exception("La tabla clientes no existe en la base de datos. ");
            }
        } catch (PDOException $e) {
            throw new Exception("Error al verificar la tabla en la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Devuelve la lista de clientes
     * @return Cliente[]
     */
    public function getAllClientes(): array {
        $query = "SELECT * FROM Clientes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $clientes = [];
        foreach ($filas as $registro) {
            $clientes[] = $this->convertirCliente($registro);
        }
        return $clientes;
    }

    /**
     * Obtiene el cliente por codigo
     */
    public function getById(int $id): ?Cliente {
        $query = "SELECT * FROM Clientes WHERE cliente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            return $this->convertirCliente($registro);
        }
        return null;
    }

    /**
     * Guarda un cliente
     */
    public function crear(Cliente $cliente): void {
        $query = 'INSERT INTO Clientes (nombre, apellido, licencia, telefono) VALUES (?, ?, ?, ?)';
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            $cliente->getNombre(),
            $cliente->getApellido(),
            $cliente->getLicencia(),
            $cliente->getTelefono(),
        ]);

        $cliente->setClienteId((int)$this->db->lastInsertId());
    }

    /**
     * Actualiza un cliente
     */
    public function actualizar(Cliente $cliente): bool {
        $query = 'UPDATE Clientes SET nombre = ?, apellido = ?, licencia = ?, telefono = ? WHERE cliente_id = ?';
        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $cliente->getNombre(),
            $cliente->getApellido(),
            $cliente->getLicencia(),
            $cliente->getTelefono(),
            $cliente->getClienteId(),
        ]);
    }

    /**
     * Elimina un cliente
     */
    public function eliminar(int $id): bool {
        $query = "DELETE FROM Clientes WHERE cliente_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    private function convertirCliente(array $fila): Cliente {
        $cliente = new Cliente();
        $cliente->setClienteId((int) $fila['cliente_id']);
        $cliente->setNombre((string) $fila['nombre']);
        $cliente->setApellido((string) $fila['apellido']);
        $cliente->setLicencia((string) $fila['licencia']);
        $cliente->setTelefono((string) $fila['telefono']);

        return $cliente;
    }
}
