<?php 
session_start();
include "../conexion.php";

$id_producto = $_GET['id'];

if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['idP']) ) {
        $alert = '<p class="alert alert-danger w-50"> Todos los Campos Son Obligatorios </p> ';
    } else {
        
        $idPI = $_POST['idP'];
        $pdf = $_FILES['pdf'];

        //imagen 1
        

        $nombre_image = $pdf['name'];
        $type = $pdf['type'];
        $url_temp = $pdf['tmp_name'];

        $imgProducto = 'nodisponible.png';

        if ($nombre_image != '') {
            $destino = 'img/fichas_tecnicas_s/';
            $img_nombre = 'FichaTecnica'.date("Y-m-d H-i-s").'_'.$id_producto;
            //$img_nombre = 'acta_'.$ubicacion.'-'.$fecha_ejecucion.date('H:m:s');
            $imgActa = $img_nombre . '.pdf';
            $src = $destino . $imgActa;
        }


            $query = mysqli_query($conexion,"SELECT * FROM productos_s");  
                                                  
            $resul = mysqli_fetch_array($query);
          
            $sql_update = mysqli_query($conexion,"UPDATE productos_s
                                                  SET s_pdf = '$imgActa' 
                                                  WHERE id_producto_s = $id_producto");

        

        if ($sql_update) {
            if ($nombre_image != '') {
                move_uploaded_file($url_temp, $src);
            }
            $alert = '<p class="alert alert-success"> Guardado Correctamente </p> ';
            header("Location: productos_old.php");
        } else {
            $alert = '<p class="alert alert-danger "> El registro fallo </p> ';
        }
   
                
        }
    
    }
    








?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <?php include "includes/scripts.php";?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SISPONCELET</title>
        
    </head>
    <body class="sb-nav-fixed">
    <?php include "includes/header.php";?>
    

        <!-- contenido del sistema-->

        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                    <div>
                    <h1 class="mt-4">Editar Imagen del Producto</h1>
                        
                        <ol class="breadcrumb mb-2 ">
                            <li class="breadcrumb-item active">Poncelet / Editar la Ficha Tecnica del producto de base de datos</li> 
                        </ol>
                    
                        
                    </div>   
                        
                        <hr>
                       <!-- contenido del sistema 2--> 
                        <!-- formulario de registro de usuarios-->



                        <?php

                    

                        $query = mysqli_query($conexion, "SELECT * from productos_s where id_producto_s = '$id_producto';");

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                            while ($data = mysqli_fetch_array($query)) {
                                if ($data['s_foto'] != 'nodisponible.png') {
                                    $image = 'img/fichas_tecnicas_s/' . $data['s_pdf'];
                                } else {
                                    $image = $data['s_pdf'];
                                }
                                
                            }
                        }
                            

                        ?>
                        



                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                            <div class="col">
                                <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0 fw-normal">Actualiza la Ficha</h4>
                                </div>
                                <div class="card-body">
                                <form action="" method="post" class="fields was-validated " enctype="multipart/form-data" novalidate>

                                    <input type="hidden" name="idP" value="<?php echo $id_producto;?>">

                                    <span for="inputFirstName">Suba el Archivo</span>
                                    <input type="file" class="form-control form-control-sm" name="pdf" id="files"> 
                                    <hr class="w-100">
                                    <!-- selector--> 
                                    <hr class="w-100">     
                                    <center><input type="submit" value="Actualizar Ficha Tecnica" class="btn btn-success  border-0 w-50   " data-dismiss="alert" ></center>
                                    <div class=" form-text text-center " role="alert" style=""> <?php echo isset ($alert) ? $alert :''; ?></div>
                                    
                                    </form>
                                    
                                    
                                </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-header py-3">
                                    <h4 class="my-0 fw-normal">Ficha Tecnica Actual</h4>
                                    

                                </div>
                                <div class="card-body">

                                <?php 
                                if($image == 0){

                                ?>
                                    
                                    <img src="img/nodisponible2.png" >

                                <?php 

                                

                                }
                                else{

                                ?>
                                
                                <object class="pdfview" data="<?php echo $image;?>" type="application/pdf" height="400px" ></object>

                                <?php 
                            
                                }
                                ?>
                                
                                </div>
                                </div>
                            </div>
                            </div>

                    
                        

                        
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; poncelet.bo@gmail.com @leiglesSoft</div>
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>