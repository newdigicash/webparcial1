<?php

require_once __DIR__ . '/controllers/ClienteController.php';
require_once __DIR__ . '/controllers/VehiculoController.php';
require_once __DIR__ . '/controllers/AlquilerController.php';

$controllerPrincipal = strtolower(trim((string) ($_GET['controller'] ?? 'alquileres')));
$action = strtolower(trim((string) ($_GET['action'] ?? 'index')));
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

switch ($controllerPrincipal) {
    case 'clientes':
        $controller = new ClienteController();
        break;

    case 'vehiculos':
        $controller = new VehiculoController();
        break;

    case 'alquileres':
    default:
        $controller = new AlquilerController();
        break;
}

switch ($action) {
    case 'crear':
        $controller->crear();
        break;

    case 'actualizar':
    case 'editar':
        $controller->actualizar($id);
        break;

    case 'eliminar':
        $controller->eliminar($id);
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
