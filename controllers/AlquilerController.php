<?php

require_once __DIR__ . '/../models/AlquilerModel.php';
require_once __DIR__ . '/../models/Alquiler.php';
//require_once __DIR__ . '/../models/AlquilerDetalle.php';
require_once __DIR__ . '/../models/ClienteModel.php';
require_once __DIR__ . '/../models/VehiculoModel.php';

class AlquilerController
{
    private AlquilerModel $modelo;
    private ClienteModel $clienteModel;
    private VehiculoModel $vehiculoModel;

    public function __construct()
    {
        $this->modelo = new AlquilerModel();
        $this->clienteModel = new ClienteModel();
        $this->vehiculoModel = new VehiculoModel();
    }

    /**
     * Recupera la lista de alquileres con detalle
     *
     * @return AlquilerDetalle[]
     */
    /*public function listarDetalleAlquileres(): array
    {
        $alquileres = $this->modelo->getAllDetalleAlquiler();

        if (file_exists(__DIR__ . '/../views/alquileres/index.php')) {
            include __DIR__ . '/../views/alquileres/index.php';
        }
    }*/

    /**
     * Muestra la lista de alquileres.
     */
    public function index(): void
    {
        //$alquileres = $this->modelo->getAllAlquileres();
        $alquileres = $this->modelo->getAllDetalleAlquiler();

        if (file_exists(__DIR__ . '/../views/alquileres/index.php')) {
            include __DIR__ . '/../views/alquileres/index.php';
        }
    }

    /**
     * Guarda un nuevo alquiler.
     */
    public function crear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $alquiler = new Alquiler();
            $alquiler->setVehiculoId((int) ($_POST['vehiculo_id'] ?? 0));
            $alquiler->setClienteId((int) ($_POST['cliente_id'] ?? 0));
            $alquiler->setFechaEntrega(trim((string) ($_POST['fecha_entrega'] ?? '')));
            $alquiler->setFechaDevolucionEstimada(trim((string) ($_POST['fecha_devolucion_estimada'] ?? '')));

            //$fechaDev = isset($_POST['fecha_devolucion']) && trim((string) $_POST['fecha_devolucion']) !== ''
            //    ? trim((string) $_POST['fecha_devolucion'])
            //    : null;
            //$alquiler->setFechaDevolucion($fechaDev);

            $alquiler->setTarifaHora((float) ($_POST['tarifa_hora'] ?? 0));
            $alquiler->setAbono((float) ($_POST['abono'] ?? 0));
            $alquiler->setTotalPagado((float) (0));
            $alquiler->setEstado(trim((string) ('A')));

            if ($this->modelo->crear($alquiler) && $alquiler->getVehiculoId() > 0) {
                $disponible = ($alquiler->getEstado() !== 'A');
                $this->vehiculoModel->actualizarDisponibilidad($alquiler->getVehiculoId(), $disponible);
            }

            header('Location: index.php');
            exit;
        }

        $clientes = $this->clienteModel->getAllClientes();
        $vehiculos = array_values(array_filter(
            $this->vehiculoModel->getAllVehiculos(),
            static fn(Vehiculo $v): bool => $v->isDisponible()
        ));

        if (file_exists(__DIR__ . '/../views/alquileres/crear.php')) {
            include __DIR__ . '/../views/alquileres/crear.php';
        }
    }

    /**
     * Actualiza un alquiler existente.
     */
    public function actualizar(int $id): void
    {
        $alquiler = $this->modelo->getById($id);

        if (!$alquiler) {
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $vehiculoAnterior = $alquiler->getVehiculoId();
            $estadoAnterior = strtoupper(trim($alquiler->getEstado()));
            $alquiler->setVehiculoId(isset($_POST['vehiculo_id']) ? (int) $_POST['vehiculo_id'] : $alquiler->getVehiculoId());
            $alquiler->setClienteId(isset($_POST['cliente_id']) ? (int) $_POST['cliente_id'] : $alquiler->getClienteId());
            $alquiler->setFechaEntrega(isset($_POST['fecha_entrega']) ? trim((string) $_POST['fecha_entrega']) : $alquiler->getFechaEntrega());
            $alquiler->setFechaDevolucionEstimada(isset($_POST['fecha_devolucion_estimada']) ? trim((string) $_POST['fecha_devolucion_estimada']) : $alquiler->getFechaDevolucionEstimada());

            if (array_key_exists('fecha_devolucion', $_POST)) {
                $fechaDev = trim((string) $_POST['fecha_devolucion']);
                $alquiler->setFechaDevolucion($fechaDev !== '' ? $fechaDev : null);
            }

            $alquiler->setTarifaHora(isset($_POST['tarifa_hora']) ? (float) $_POST['tarifa_hora'] : $alquiler->getTarifaHora());
            $alquiler->setAbono(isset($_POST['abono']) ? (float) $_POST['abono'] : $alquiler->getAbono());
            $nuevoEstado = isset($_POST['estado']) ? strtoupper(trim((string) $_POST['estado'])) : strtoupper(trim($alquiler->getEstado()));
            $alquiler->setEstado($nuevoEstado);
            //$alquiler->setTotalPagado(isset($_POST['total_pagado']) ? (float) $_POST['total_pagado'] : $alquiler->getTotalPagado());
            //$alquiler->setEstado(isset($_POST['estado']) ? trim((string) $_POST['estado']) : $alquiler->getEstado());

            if ($alquiler->getFechaDevolucion() !== null && trim($alquiler->getFechaDevolucion()) !== '') {
                $alquiler->setTotalPagado($this->calcularTotalAPagar($alquiler));
            } elseif (isset($_POST['total_pagado'])) {
                //$alquiler->setTotalPagado((float) $_POST['total_pagado']);
                $alquiler->setTotalPagado(isset($_POST['total_pagado']) ? (float) $_POST['total_pagado'] : $alquiler->getTotalPagado());
            }

            if ($this->modelo->actualizar($alquiler)) {
                $vehiculoActual = $alquiler->getVehiculoId();

                if ($vehiculoAnterior !== $vehiculoActual && $vehiculoAnterior > 0 && $estadoAnterior === 'A') {
                    $this->vehiculoModel->actualizarDisponibilidad($vehiculoAnterior, true);
                }

                if ($vehiculoActual > 0) {
                    if ($nuevoEstado === 'F' || $nuevoEstado === 'C') {
                        $this->vehiculoModel->actualizarDisponibilidad($vehiculoActual, true);
                    } elseif ($nuevoEstado === 'A') {
                        $this->vehiculoModel->actualizarDisponibilidad($vehiculoActual, false);
                    }
                }
            }

            header('Location: index.php');
            exit;
        }

        $clientes = $this->clienteModel->getAllClientes();
        $vehiculos = $this->vehiculoModel->getAllVehiculos();

        if (file_exists(__DIR__ . '/../views/alquileres/editar.php')) {
            include __DIR__ . '/../views/alquileres/editar.php';
        }
    }

    /**
     * Elimina un alquiler por ID.
     */
    public function eliminar(int $id): void
    {
        $this->modelo->eliminar($id);
        header('Location: index.php');
        exit;
    }

    /**
    * Calcula el total a pagar a partir de la fecha de devolución real:
    * max(0, (horas * tarifa_hora) - abono).
    */
    private function calcularTotalAPagar(Alquiler $alquiler): float
    {
        $fechaDevolucion = $alquiler->getFechaDevolucion();
        if ($fechaDevolucion === null || trim($fechaDevolucion) === '') {
            return $alquiler->getTotalPagado();
        }

        try {
            $inicio = new DateTimeImmutable($alquiler->getFechaEntrega());
            $fin = new DateTimeImmutable($fechaDevolucion);
        } catch (Exception $e) {
            return $alquiler->getTotalPagado();
        }

        $segundos = $fin->getTimestamp() - $inicio->getTimestamp();
        $horas = max(0.0, $segundos / 3600);
        $subtotal = round($horas * $alquiler->getTarifaHora(), 2);
        $totalRestante = round($subtotal - $alquiler->getAbono(), 2);

        return max(0.0, $totalRestante);
    }
}
