<?php
// Prepara los parametros
$vehiculo = $vehiculo ?? null;
$id = $vehiculo ? $vehiculo->getVehiculoId() : '';
$marca = $vehiculo ? $vehiculo->getMarca() : '';
$modelo = $vehiculo ? $vehiculo->getModelo() : '';
$anio = $vehiculo ? $vehiculo->getAnio() : '';
$disponible = $vehiculo ? $vehiculo->isDisponible() : true;

$soloLectura = (isset($isReadOnly) && $isReadOnly) ? 'readonly disabled' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina ?? 'Mantenimiento de Vehículo') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1><?= htmlspecialchars($tituloH1 ?? 'Formulario de Vehículo') ?></h1>

        <form action="<?= htmlspecialchars($actionUrl ?? 'index.php') ?>" method="POST">
            <div>
                <label for="id">Código:</label><br>
                <input type="text" id="id" name="id" value="<?= htmlspecialchars((string) $id) ?>" readonly disabled>
            </div>
            <br>

            <div>
                <label for="marca">Marca:</label><br>
                <input type="text" id="marca" name="marca" value="<?= htmlspecialchars($marca) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="modelo">Modelo:</label><br>
                <input type="text" id="modelo" name="modelo" value="<?= htmlspecialchars($modelo) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="anio">Año:</label><br>
                <input type="number" id="anio" name="anio" value="<?= htmlspecialchars((string) $anio) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="disponible">Disponible:</label><br>
                <select id="disponible" name="disponible" <?= (isset($isReadOnly) && $isReadOnly) ? 'disabled' : '' ?>>
                    <option value="1" <?= $disponible === true ? 'selected' : '' ?>>Disponible</option>
                    <option value="0" <?= $disponible === false ? 'selected' : '' ?>>No disponible</option>
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
