<?php

require_once __DIR__ . '/../models/VehiculoModel.php';
require_once __DIR__ . '/../models/Vehiculo.php';

class VehiculoController
{
    private VehiculoModel $modelo;

    public function __construct()
    {
        $this->modelo = new VehiculoModel();
    }

    /**
     * Muestra la lista de vehículos.
     */
    public function index(): void
    {
        $vehiculos = $this->modelo->getAllVehiculos();

        if (file_exists(__DIR__ . '/../views/vehiculos/index.php')) {
            include __DIR__ . '/../views/vehiculos/index.php';
        }
    }

    /**
     * Guarda un nuevo vehículo.
     */
    public function crear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehiculo = new Vehiculo();
            $vehiculo->setMarca(trim((string) ($_POST['marca'] ?? '')));
            $vehiculo->setModelo(trim((string) ($_POST['modelo'] ?? '')));
            $vehiculo->setAnio((int) ($_POST['año'] ?? $_POST['anio'] ?? 0));
            $vehiculo->setDisponible(isset($_POST['disponible']) && ($_POST['disponible'] === '1' || $_POST['disponible'] === 'true' || $_POST['disponible'] === 'on'));

            $this->modelo->crear($vehiculo);
            header('Location: index.php');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/vehiculos/crear.php')) {
            include __DIR__ . '/../views/vehiculos/crear.php';
        }
    }

    /**
     * Actualiza un vehículo existente.
     */
    public function actualizar(int $id): void
    {
        $vehiculo = $this->modelo->getById($id);

        if (!$vehiculo) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehiculo->setMarca(isset($_POST['marca']) ? trim((string) $_POST['marca']) : $vehiculo->getMarca());
            $vehiculo->setModelo(isset($_POST['modelo']) ? trim((string) $_POST['modelo']) : $vehiculo->getModelo());
            $vehiculo->setAnio((int) $_POST['anio']);
            $vehiculo->setDisponible(isset($_POST['disponible']) && ($_POST['disponible'] === '1' || $_POST['disponible'] === 'true' || $_POST['disponible'] === 'on'));

            $this->modelo->actualizar($vehiculo);
            header('Location: index.php');
            exit;
        }

        if (file_exists(__DIR__ . '/../views/vehiculos/editar.php')) {
            include __DIR__ . '/../views/vehiculos/editar.php';
        }
    }

    /**
     * Elimina un vehículo por ID.
     */
    public function eliminar(int $id): void
    {
        $this->modelo->eliminar($id);
        header('Location: index.php');
        exit;
    }
}
