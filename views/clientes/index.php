<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mantenimiento de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <section class="header-section">
            <h1>Listado de Clientes</h1>
            <a href="index.php" class="btn-addOtro">Regresar</a>
            <a href="index.php?controller=clientes&action=crear" class="btn-add">Nuevo Cliente</a>
        </section>

        <hr>

        <section class="table-container">
            <table class="client-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Licencia</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $cliente->getClienteId()) ?></td>
                                <td><?= htmlspecialchars($cliente->getNombre()) ?></td>
                                <td><?= htmlspecialchars($cliente->getApellido()) ?></td>
                                <td><?= htmlspecialchars($cliente->getLicencia()) ?></td>
                                <td><?= htmlspecialchars($cliente->getTelefono()) ?></td>
                                <td>
                                    <a href="index.php?controller=clientes&action=actualizar&id=<?= $cliente->getClienteId() ?>" class="btn-edit">Editar</a>

                                    <a href="index.php?controller=clientes&action=eliminar&id=<?= $cliente->getClienteId() ?>" class="btn-delete" onclick="return confirm('¿Está seguro de eliminar el cliente?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay clientes registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>
