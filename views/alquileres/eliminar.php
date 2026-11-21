<?php
// Prepara los parametros
$tituloPagina = 'Eliminar Alquiler';
$tituloH1 = 'Eliminar los datos del alquiler';
$actionUrl = 'index.php?action=eliminar&id=' . ($alquiler ? $alquiler->getAlquilerId() : '');
$botonTexto = 'Eliminar';
$isReadOnly = true;
$bloquearCampos = false;

include __DIR__ . '/formulario.php';
