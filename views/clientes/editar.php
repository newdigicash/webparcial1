<?php
// Prepara los parametros
$tituloPagina = 'Modificar Cliente';
$tituloH1 = 'Modificar Cliente';
$actionUrl = 'index.php?controller=clientes&action=actualizar&id=' . ($cliente ? $cliente->getClienteId() : '');
$botonTexto = 'Actualizar ';

include __DIR__ . '/formulario.php';
