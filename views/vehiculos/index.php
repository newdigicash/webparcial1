<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimiento de Vehículos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <section class="header-section">
            <h1>Listado de Vehículos</h1>
            <a href="index.php" class="btn-addOtro">Regresar</a>
            <a href="index.php?controller=vehiculos&action=crear" class="btn-add">Nuevo Vehículo</a>
        </section>

        <hr>

        <section class="table-container">
            <table class="client-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($vehiculos)): ?>
                        <?php foreach ($vehiculos as $vehiculo): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $vehiculo->getVehiculoId()) ?></td>
                                <td><?= htmlspecialchars($vehiculo->getMarca()) ?></td>
                                <td><?= htmlspecialchars($vehiculo->getModelo()) ?></td>
                                <td><?= htmlspecialchars((string) $vehiculo->getAnio()) ?></td>
                                <td><?= $vehiculo->isDisponible() ? 'Disponible' : 'No disponible' ?></td>
                                <td>
                                    <a href="index.php?controller=vehiculos&action=actualizar&id=<?= $vehiculo->getVehiculoId() ?>" class="btn-edit">Editar</a>

                                    <a href="index.php?controller=vehiculos&action=eliminar&id=<?= $vehiculo->getVehiculoId() ?>" class="btn-delete" onclick="return confirm('¿Está seguro de eliminar el vehículo?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay vehículos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
