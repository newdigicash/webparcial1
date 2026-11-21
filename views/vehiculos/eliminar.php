<?php
// Prepara los parametros
$tituloPagina = 'Eliminar Vehículo';
$tituloH1 = 'Eliminar los datos del vehículo';
$actionUrl = 'index.php?controller=vehiculos&action=eliminar&id=' . ($vehiculo ? $vehiculo->getVehiculoId() : '');
$botonTexto = 'Eliminar';
$isReadOnly = true;

include __DIR__ . '/formulario.php';
