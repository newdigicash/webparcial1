<?php
// Prepara los parametros
$tituloPagina = 'Eliminar Cliente';
$tituloH1 = 'Eliminar los datos del cliente';
$actionUrl = 'index.php?controller=clientes&action=eliminar&id=' . ($cliente ? $cliente->getClienteId() : '');
$botonTexto = 'Eliminar ';
$isReadOnly = true;

include __DIR__ . '/formulario.php';
