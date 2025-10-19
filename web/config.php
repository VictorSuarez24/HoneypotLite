<?php
//ajustes del dashboard
date_default_timezone_set('Europe/London');

// Ruta absoluta o relativa al fichero CSV de logs
$LOGFILE = __DIR__ . '/var/honeypot/logs/connections.log';

// Clave simple para añadir entradas (solo para pruebas en lab).
$ADMIN_KEY = 'cambia_esta_clave_por_una_muy_segura';
// Maximas entradas que te va a mostrar
$MAX_ROWS = 200;