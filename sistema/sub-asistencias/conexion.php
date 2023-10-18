<?php

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $entorno = 'local';
} else {
    $entorno = 'produccion';
}

if ($entorno == 'local') {
    $db_host = 'localhost';
    $db_port = '3316';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'naxsan';
} else {
    $db_host = 'localhost';
    $db_user = 'airsoftb_naxsan';
    $db_password = '71811452Ale*';
    $db_name = 'airsoftb_naxsan2';
}

try {
    $conexion = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_password);
    // Configurar PDO para que lance excepciones en caso de error.
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
