<?php
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController {
    private ClienteModel $modelo;

    public function __construct() {
        $this->modelo = new ClienteModel();
    }

    /**
     * Muestra la lista de clientes
     */
    public function index(): void {
        $clientes = $this->modelo->getAllClientes();
        //carga la vista principal
        if (file_exists(__DIR__ . '/../views/clientes/index.php')) {
            include __DIR__ . '/../views/clientes/index.php';
        }
    }

    /**
     * Guarda el cliente
     */
    public function crear(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = new Cliente();
            $cliente->setNombre(trim((string) ($_POST['nombre'] ?? '')));
            $cliente->setApellido(trim((string) ($_POST['apellido'] ?? '')));
            $cliente->setLicencia(trim((string) ($_POST['licencia'] ?? '')));
            $cliente->setTelefono(trim((string) ($_POST['telefono'] ?? '')));

            $this->modelo->crear($cliente);
            header('Location: index.php');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/clientes/crear.php')) {
            include __DIR__ . '/../views/clientes/crear.php';
        }
    }

    /**
     * Actualiza el cliente
     */
    public function actualizar(int $id): void {
        $cliente = $this->modelo->getById($id);

        if (!$cliente) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente->setNombre(isset($_POST['nombre']) ? trim((string) $_POST['nombre']) : $cliente->getNombre());
            $cliente->setApellido(isset($_POST['apellido']) ? trim((string) $_POST['apellido']) : $cliente->getApellido());
            $cliente->setLicencia(isset($_POST['licencia']) ? trim((string) $_POST['licencia']) : $cliente->getLicencia());
            $cliente->setTelefono(isset($_POST['telefono']) ? trim((string) $_POST['telefono']) : $cliente->getTelefono());

            $this->modelo->actualizar($cliente);
            header('Location: index.php');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/clientes/editar.php')) {
            include __DIR__ . '/../views/clientes/editar.php';
        }
    }

    /**
     * elimina el cliente
     */
    public function eliminar(int $id): void {
        $this->modelo->eliminar($id);
        header('Location: index.php');
        exit;
    }
}
