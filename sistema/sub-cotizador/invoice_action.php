<?php
  include 'Invoice.php';
  include 'conexion.php';
  //require ('conexion.php');
  $invoice = new Invoice();
  

  if (!empty($_POST['action']) && $_POST['action'] == 'loadItemsList') {
	  $invoice->loadItemsList();
  }
  
  if (!empty($_POST['action']) && $_POST['action'] == 'loadItems') {
	  $invoice->loadItems();
  }
  
  if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
	  $invoice = new Invoice();
  
	  if (isset($_POST['action'])) {
		  switch ($_POST['action']) {
			  case 'loadInvoiceData':
				  $start = $_POST['start'];
				  $length = $_POST['length'];
				  $searchValue = $_POST['search']['value'];
  
				  $invoiceData = $invoice->getInvoiceList($length, $start, $searchValue);
				  if ($invoiceData === false) {
					echo json_encode(array('error' => 'Error al obtener datos de la base de datos.'));
					exit();
				}
				  $totalRecords = $invoice->getTotalRecords($searchValue);
  
				  $data = array();
				  foreach ($invoiceData as $invoiceDetails) {
					  $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["fecha_cotizacion"]));
					  $printLink = '<a class="btn btn-sm btn-outline-danger w-100" target="_blank" href="print_invoice.php?invoice_id=' . $invoiceDetails["id_cotizacion"] . '" title="Imprimir Cotizacion" ><span <i class="bi bi-file-earmark-pdf"></i> PDF</a>';
					  $editLink = '<a style="background-color:beige; color:#646464" class="btn btn-sm btn-warning w-100" href="edit_invoice.php?update_id=' . $invoiceDetails["id_cotizacion"] . '"  title="Editar Cotizacion"><i class="bi bi-pencil-square"></i> </a>';
					  $deleteLink = '<a class="btn btn-sm btn-danger w-100 deleteInvoice" href="#" id="' . $invoiceDetails["id_cotizacion"] . '" class="deleteInvoice"  title="Eliminar Cotizacion"><i class="bi bi-trash-fill"></i> </a>';

					  	if ($invoiceDetails['id_usuario'] == 'Jazmin Velasco Diaz') {
						$user = '<span style="font-size:12px;background-color:#fbe9f4;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Jazmin Velasco   </span>'.'<br/>';
						} else {
						$user = '';
						}

						if ($invoiceDetails['id_usuario'] == 'Alejandro Iglesias Raldes') {
							$user2 = '<span style="font-size:12px;background-color:#e9ffca;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Alejandro Iglesias  </span>'.'<br/>';
						} else {
							$user2 = '';
						}

						if ($invoiceDetails['id_usuario'] == 'Deyci Eveling Colque Pacha') {
							$user3 = '<span style="font-size:12px;background-color:#cafbff;text-align: left; color:#5a5a5a;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Eveling Colque </span>'.'<br/>';
						} else {
							$user3 = '';
						}

						if ($invoiceDetails['id_usuario'] == 'Alberto Arispe Ponce') {
							$user4 = '<span style="font-size:12px;background-color:#2f2d2a;text-align: left; color:white;" class="btn  btn-sm w-100"><i class="bi bi-person-circle"></i> Alberto Arispe </span>'.'<br/>';
						} else {
							$user4 = '';
						}

  
					  $data[] = array(
						  'id_cotizacion' => $invoiceDetails["id_cotizacion"],
						  'fecha_cotizacion' => $invoiceDate,
						  'cliente_nombre' => $invoiceDetails["cliente_nombre"],
						  'nota' => $invoiceDetails["nota"],
						  'total_antes_impuestos' => number_format($invoiceDetails["total_antes_impuestos"], 2, '.', ',') . ' Bs',
						  'id_usuario' => $user.$user2.$user3.$user4,
						  'print_link' => $printLink,
						  'edit_link' => $editLink,
						  'delete_link' => $deleteLink
					  );
				  }
  
				
					// Ordenar los datos por la columna 'fecha_cotizacion' en orden ascendente
					usort($data, function ($a, $b) {
						$dateA = strtotime($a['fecha_cotizacion']);
						$dateB = strtotime($b['fecha_cotizacion']);
						return $dateA - $dateB;
					});

  
				  $response = array(
					  'draw' => intval($_POST['draw']),
					  'recordsTotal' => intval($totalRecords),
					  'recordsFiltered' => intval($totalRecords),
					  'data' => $data
				  );
  
				  echo json_encode($response);
				  break;
		  }
	  }
  }
  ?>
  
  
  