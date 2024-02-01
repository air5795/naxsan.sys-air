<?php

    function subir_imagen(){
        if (isset($_FILES["foto"])) {
            
            $extension = explode('.', $_FILES["foto"]['name']);
            $nuevo_nombre = 'Producto-'.date('d-m-y').'-'.rand() . '.' . $extension[1];
            $ubicacion = './productos/' . $nuevo_nombre;
            move_uploaded_file($_FILES["foto"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

 /*    function subir_ficha(){
        if (isset($_FILES["ficha"])) {
            
            $extension = explode('.', $_FILES["ficha"]['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './fichas/' . $nuevo_nombre;
            move_uploaded_file($_FILES["ficha"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    }

    function subir_certificado(){
        if (isset($_FILES["certificado"])) {
            
            $extension = explode('.', $_FILES["certificado"]['name']);
            $nuevo_nombre = rand() . '.' . $extension[1];
            $ubicacion = './certificados/' . $nuevo_nombre;
            move_uploaded_file($_FILES["certificado"]['tmp_name'], $ubicacion);
            return $nuevo_nombre;
        }
    } */

    function obtener_nombre_imagen($id_activo){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT foto FROM activos_fijos WHERE id_activo = '$id_activo'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["foto"];
        }
    }

    function obtener_nombre_qr($id_activo){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT qr FROM activos_fijos WHERE id_activo = '$id_activo'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["qr"];
        }
    }

 /*    function obtener_nombre_ficha($id_producto){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT pdf FROM productos WHERE id_producto = '$id_producto'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["pdf"];
        }
    }

    function obtener_nombre_certificado($id_producto){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT certificado FROM productos WHERE id_producto = '$id_producto'");
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        foreach($resultado as $fila){
            return $fila["certificado"];
        }
    } */

    function obtener_todos_registros(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM activos_fijos");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }

    function obtener_todos_registros2(){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT * FROM categoria_i");
        $stmt->execute();
        $resultado = $stmt->fetchAll(); 
        return $stmt->rowCount();       
    }