<?php
// Prepara los parametros
$cliente = $cliente ?? null;
$id = $cliente ? $cliente->getClienteId() : '';
$nombre = $cliente ? $cliente->getNombre() : '';
$apellido = $cliente ? $cliente->getApellido() : '';
$licencia = $cliente ? $cliente->getLicencia() : '';
$telefono = $cliente ? $cliente->getTelefono() : '';

$soloLectura = (isset($isReadOnly) && $isReadOnly) ? 'readonly disabled' : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($tituloPagina ?? 'Mantenimiento de Cliente') ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1><?= htmlspecialchars($tituloH1 ?? 'Formulario de Cliente') ?></h1>

        <form action="<?= htmlspecialchars($actionUrl ?? 'index.php') ?>" method="POST">
            <div>
                <label for="id">Código:</label><br>
                <input type="text" id="id" name="id" value="<?= htmlspecialchars((string) $id) ?>" readonly disabled>
            </div>
            <br>

            <div>
                <label for="nombre">Nombre:</label><br>
                <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="apellido">Apellido:</label><br>
                <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="licencia">Licencia:</label><br>
                <input type="text" id="licencia" name="licencia" value="<?= htmlspecialchars($licencia) ?>" <?= $soloLectura ?> required>
            </div>
            <br>

            <div>
                <label for="telefono">Teléfono:</label><br>
                <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" <?= $soloLectura ?> required>
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
