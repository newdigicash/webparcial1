<?php
// Prepara los parametros
$tituloPagina = 'Modificar Vehículo';
$tituloH1 = 'Modificar Vehículo';
$actionUrl = 'index.php?controller=vehiculos&action=actualizar&id=' . ($vehiculo ? $vehiculo->getVehiculoId() : '');
$botonTexto = 'Actualizar';

include __DIR__ . '/formulario.php';
