<?php
// Prepara los parametros
$alquiler = $alquiler ?? null;
$clientes = $clientes ?? [];
$vehiculos = $vehiculos ?? [];

$id = $alquiler ? $alquiler->getAlquilerId() : '';
$vehiculoId = $alquiler ? $alquiler->getVehiculoId() : 0;
$clienteId = $alquiler ? $alquiler->getClienteId() : 0;
$fechaEntrega = $alquiler ? $alquiler->getFechaEntrega() : date('Y-m-d\TH:i');
$fechaDevolucionEstimada = $alquiler ? $alquiler->getFechaDevolucionEstimada() : date('Y-m-d\TH:i');
$fechaDevolucion = ($alquiler && $alquiler->getFechaDevolucion() !== null) ? $alquiler->getFechaDevolucion() : '';
$tarifaHora = $alquiler ? $alquiler->getTarifaHora() : 0;
$abono = $alquiler ? $alquiler->getAbono() : 0;
$totalPagado = $alquiler ? $alquiler->getTotalPagado() : 0;
$estado = $alquiler ? $alquiler->getEstado() : 'activo';

$soloLectura = (isset($isReadOnly) && $isReadOnly) ? 'readonly disabled' : '';
$selectDeshabilitado = (isset($isReadOnly) && $isReadOnly) ? 'disabled' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina ?? 'Mantenimiento de Alquiler') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1><?= htmlspecialchars($tituloH1 ?? 'Formulario de Alquiler') ?></h1>

        <form action="<?= htmlspecialchars($actionUrl ?? 'index.php') ?>" method="POST">
            <div>
                <label for="id">Código:</label><br>
                <input type="text" id="id" name="id" value="<?= htmlspecialchars((string) $id) ?>" readonly disabled>
            </div>
            <br>

            <div>
                <label for="cliente_id">Cliente:</label><br>
                <select id="cliente_id" name="cliente_id" <?= $selectDeshabilitado ?> required>
                    <option value="">Seleccione un cliente</option>
                    <?php foreach ($clientes as $cliente): ?>
                        <?php
                        $cId = $cliente->getClienteId();
                        $detalleCliente = $cliente->getNombre() . ' ' . $cliente->getApellido();
                        ?>
                        <option value="<?= htmlspecialchars((string) $cId) ?>" <?= ((int) $clienteId === (int) $cId) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($detalleCliente) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>

            <div>
                <label for="vehiculo_id">Vehículo:</label><br>
                <select id="vehiculo_id" name="vehiculo_id" <?= $selectDeshabilitado ?> required>
                    <option value="">Seleccione un vehículo</option>
                    <?php foreach ($vehiculos as $vehiculo): ?>
                        <?php
                        $vId = $vehiculo->getVehiculoId();
                        $detalleVehiculo = $vehiculo->getMarca() . ' ' . $vehiculo->getModelo() . ' ' . $vehiculo->getAnio();
                        ?>
                        <option value="<?= htmlspecialchars((string) $vId) ?>" <?= ((int) $vehiculoId === (int) $vId) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($detalleVehiculo) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br>

            <div>
                <label for="fecha_entrega">Fecha de Entrega:</label><br>
                <input type="datetime-local" id="fecha_entrega" name="fecha_entrega" value="<?= htmlspecialchars((string) $fechaEntrega) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="fecha_devolucion_estimada">Fecha Devolución Estimada:</label><br>
                <input type="datetime-local" id="fecha_devolucion_estimada" name="fecha_devolucion_estimada" value="<?= htmlspecialchars((string) $fechaDevolucionEstimada) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="fecha_devolucion">Fecha Devolución Real:</label><br>
                <input type="datetime-local" id="fecha_devolucion" name="fecha_devolucion" value="<?= htmlspecialchars((string) $fechaDevolucion) ?>" <?= $soloLectura ?>>
            </div>
            <br>

            <div>
                <label for="tarifa_hora">Tarifa por Hora:</label><br>
                <input type="number" step="0.01" min="0" id="tarifa_hora" name="tarifa_hora" value="<?= htmlspecialchars((string) $tarifaHora) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="abono">Abono:</label><br>
                <input type="number" step="0.01" min="0" id="abono" name="abono" value="<?= htmlspecialchars((string) $abono) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="total_pagado">Total Pagado:</label><br>
                <input type="number" step="0.01" id="total_pagado" name="total_pagado" value="<?= htmlspecialchars((string) $totalPagado) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="estado">Estado:</label><br>
                <select id="estado" name="estado" <?= $selectDeshabilitado ?>>
                    <option value="A" <?= $estado === 'A' ? 'selected' : '' ?>>Activo</option>
                    <option value="F" <?= $estado === 'F' ? 'selected' : '' ?>>Finalizado</option>
                    <option value="C" <?= $estado === 'C' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
            <br>

            <div>
                <button type="submit"><?= htmlspecialchars($botonTexto ?? 'Guardar') ?></button>
                <a href="index.php" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
