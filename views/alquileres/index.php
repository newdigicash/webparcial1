<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimiento de Alquiler</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <section class="header-section">
            <h1>Alquiler de vehículos</h1>
            <a href="index.php?controller=clientes&action=index" class="btn-addOtro">Clientes</a>
            <a href="index.php?controller=vehiculos&action=index" class="btn-addOtro">Vehículos</a>
            <a href="index.php?action=crear" class="btn-add">Nuevo Alquiler</a>
        </section>

        <hr>

        <section class="table-container">
            <table class="client-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Fecha Entrega</th>
                        <th>Devolución Estimada</th>
                        <th>Devolución Real</th>
                        <th>Tarifa/Hora</th>
                        <th>Abono</th>
                        <th>Total Pagado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alquileres)): ?>
                        <?php foreach ($alquileres as $alquiler): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $alquiler->getAlquilerId()) ?></td>
                                <td><?= htmlspecialchars(method_exists($alquiler, 'getDetalleCliente') ? $alquiler->getDetalleCliente() : (string) $alquiler->getClienteId()) ?></td>
                                <td><?= htmlspecialchars(method_exists($alquiler, 'getDetalleVehiculo') ? $alquiler->getDetalleVehiculo() : (string) $alquiler->getVehiculoId()) ?></td>
                                <td><?= htmlspecialchars($alquiler->getFechaEntrega()) ?></td>
                                <td><?= htmlspecialchars($alquiler->getFechaDevolucionEstimada()) ?></td>
                                <td><?= htmlspecialchars((string) ($alquiler->getFechaDevolucion() ?? '-')) ?></td>
                                <td><?= htmlspecialchars((string) $alquiler->getTarifaHora()) ?></td>
                                <td><?= htmlspecialchars((string) $alquiler->getAbono()) ?></td>
                                <td><?= htmlspecialchars((string) $alquiler->getTotalPagado()) ?></td>
                                <?php
                                $codigoEstado = strtoupper(trim($alquiler->getEstado()));
                                $txtEstado = match ($codigoEstado) {
                                    'A' => 'Activo',
                                    'F' => 'Finalizado',
                                    'C' => 'Cancelado',
                                    default => $alquiler->getEstado(),
                                };
                                ?>
                                <td><?= htmlspecialchars($txtEstado) ?></td>
                                <td>
                                    <a href="index.php?action=actualizar&id=<?= $alquiler->getAlquilerId() ?>" class="btn-edit">Editar</a>

                                    <a href="index.php?action=eliminar&id=<?= $alquiler->getAlquilerId() ?>" class="btn-delete" onclick="return confirm('¿Está seguro de eliminar el alquiler?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="text-center">No hay alquileres registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
