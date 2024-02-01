<?php

include("conexion.php");
include("funciones.php");

require 'phpqrcode/qrlib.php';




if ($_POST["operacion"] == "Crear") {
    $imagen = '';
    /* $ficha = '';
    $certificado = ''; */
    if ($_FILES["foto"]["name"] != '') {
        $imagen = subir_imagen();
    }
   /*  if ($_FILES["ficha"]["name"] != '') {
        $ficha = subir_ficha();
    }
    if ($_FILES["certificado"]["name"] != '') {
        $certificado = subir_certificado();
    } */
    $stmt = $conexion->prepare("INSERT INTO activos_fijos(nombre, categoria, responsable, ubicacion, estado, observacion, foto)
                                VALUES(:nombre, :categoria, :responsable, :ubicacion, :estado, :observacion, :foto )");

    $resultado = $stmt->execute(
        array(
            ':nombre'           => $_POST["nombre"],
            ':categoria'            => $_POST["categoria"],
            ':responsable'           => $_POST["responsable"],
            ':ubicacion'               => $_POST["ubicacion"],
            ':estado'               => $_POST["estado"],
            ':observacion'             => $_POST["observacion"],
            ':foto'             => $imagen
        )
    );

    if (!empty($resultado)) {

       // Obtener el ID del activo fijo recién insertado
       $lastInsertedID = $conexion->lastInsertId();

       // Crear una cadena de datos para el QR
       $qrData = "ID: $lastInsertedID\nNombre: {$_POST["nombre"]}\nCategoria: {$_POST["categoria"]}\nResponsable: {$_POST["responsable"]}\nUbicacion: {$_POST["ubicacion"]}\nObservacion: {$_POST["observacion"]}";

       // Directorio donde se almacenarán los códigos QR (asegúrate de tener permisos de escritura)
       $dir = 'qr/';

       // Nombre del archivo QR
       $qrFileName = $dir . 'qr_' . $lastInsertedID . '.png';

       // Generar el código QR
       if (QRcode::png($qrData, $qrFileName)) {
           echo 'Código QR generado y guardado correctamente.<br>';
       } else {
           echo 'Error al generar el código QR.<br>';
       }


       // Actualizar la base de datos con el nombre del archivo QR
       $stmt = $conexion->prepare("UPDATE activos_fijos SET qr = :qr WHERE id_activo = :id");
       $stmt->execute(array(':qr' => $qrFileName, ':id' => $lastInsertedID));

       echo 'Registro creado y código QR generado.';

   } else {
       echo 'Error al insertar el registro en la base de datos.';
   }
}



	




if ($_POST["operacion"] == "Editar") {
    $imagen = obtener_nombre_imagen($_POST["id_activo"]);
    /* $ficha = obtener_nombre_ficha($_POST["id_activo"]);
    $certificados = obtener_nombre_certificado($_POST["id_activo"]); */

    /* if ($_FILES["ficha"]["name"] != '') {
        unlink("fichas/" . $ficha);
        $ficha = subir_ficha();
    } 
    else {
        $ficha = @$_POST['ficha_o'];    
    } 

    if ($_FILES["certificado"]["name"] != '') {
        unlink("certificados/" . $certificados); 
        $certificado =  subir_certificado();
    }
    else {
        $certificado = @$_POST['certificado_o'];
    } */


    if ($_FILES["foto"]["name"] != '') {
        unlink("productos/" . $imagen);
         $imagen = subir_imagen();
    }
    else {

        $imagen = @$_POST['img_o'];     
    }
    




    $stmt = $conexion->prepare("UPDATE activos_fijos SET nombre=:nombre, categoria=:categoria, responsable=:responsable, ubicacion=:ubicacion, estado=:estado, observacion=:observacion, 
    foto=:foto WHERE id_activo = :id_activo");

    $resultado = $stmt->execute(
        array(
            ':id_activo'      => $_POST["id_activo"],
            ':nombre'           => $_POST["nombre"],
            ':categoria'            => $_POST["categoria"],
            ':responsable'           => $_POST["responsable"],
            ':ubicacion'               => $_POST["ubicacion"],
            ':estado'               => $_POST["estado"],
            ':observacion'             => $_POST["observacion"],
            ':foto'             => $imagen

        )

        

        
    );

    if (!empty($resultado)) {
        echo 'Registro actualizado';
    }
}