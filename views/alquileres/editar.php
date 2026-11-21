<?php
// Prepara los parametros
$tituloPagina = 'Modificar Alquiler';
$tituloH1 = 'Modificar Alquiler';
$actionUrl = 'index.php?action=actualizar&id=' . ($alquiler ? $alquiler->getAlquilerId() : '');
$botonTexto = 'Actualizar';
$bloquearCampos = false;

include __DIR__ . '/formulario.php';
