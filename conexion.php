<?php

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    $entorno = 'local';
} else {
    $entorno = 'produccion';
}

if ($entorno == 'local') {
    $db_host = 'localhost:3316';
    $db_user = 'root';
    $db_password = '';
    $db_name = 'naxsan';
} else {
    $db_host = 'localhost';
    $db_user = 'admin-81de';
    $db_password = 'naxsan2023abc*';
    $db_name = 'naxsan-35303337ab1d';
}

$conexion = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}



    
    /* $host = 'localhost:3316';
    $user = 'root';
    $password = '';
    $db = 'naxsan';

    $conexion = @mysqli_connect($host,$user,$password,$db);

    

    if (!$conexion) {
        echo "Error en la conexion";
    }  */

?>