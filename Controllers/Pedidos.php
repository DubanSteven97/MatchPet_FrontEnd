<?php
	require_once("Models/TTipoPago.php");
	class Pedidos extends Controllers
	{
		use TTipoPago;
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Pedidos');
		}
		public function Pedidos()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Pedidos";
			$data['page_name'] = "pedidos";
			$data['page_title'] = "Pedidos <small> Tienda Virtual</smal>";
			$data['page_functions_js'] = "functions_pedidos.js";
			$this->views->GetView($this,"pedidos",$data);
		}

		public function GetPedidos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idPersona = "";
				if($_SESSION['userData']['nombrerol'] == "Cliente")
				{
					$idPersona = $_SESSION['userData']['idpersona'];
				}
				$arrData = $this->model->SelectPedidos($idPersona);
				for($i=0;$i<count($arrData);$i++){
					$btnEdit = '';
					$btnDelete = '';

					$arrData[$i]['transaccion'] = $arrData[$i]['referenciacobro'];

					if($arrData[$i]['idtransaccion'] != "")
					{
						$arrData[$i]['transaccion'] = $arrData[$i]['idtransaccion'];
					}

					$arrData[$i]['monto'] = FormatMoney($arrData[$i]['monto']);

					if($_SESSION['permisosMod']['r']){
						$btnView = '<a href="'.BaseUrl().'/Pedidos/Orden/'.$arrData[$i]['idpedido'].'" target="_balnck" class="btn btn-info btn-sm" title="Ver Detalle"> <i class="far fa-eye"></i></a>

							<a href="'.BaseUrl().'/Factura/GenerarFactura/'.$arrData[$i]['idpedido'].'" target="_balnck" class="btn btn-danger btn-sm" title="Generar PDF"> <i class="fas fa-file-pdf"></i></a> ';
						if($arrData[$i]['tipopago'] == "PayPal")
						{
							$btnView .= '<a href="'.BaseUrl().'/Pedidos/TransaccionPP/'.$arrData[$i]['idtransaccion'].'" target="_balnck" class="btn btn-info btn-sm" title="Ver transacción"> <i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i></a>';
						}else if($arrData[$i]['tipopago'] == "Mercado Pago"){
							$btnView .= '<a href="'.BaseUrl().'/Pedidos/TransaccionMP/'.$arrData[$i]['idtransaccion'].'" target="_balnck" class="btn btn-info btn-sm" title="Ver transacción"> <i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i></a>';
						}else{
							$btnView .= '<button class="btn btn-info btn-sm" disabled> <i class="fa-solid fa-money-check-dollar" aria-hidden="true"></i></button>';
						}
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditProducto" onClick="fntEditProducto(this,'.$arrData[$i]['idpedido'].')" title="Editar Pedido"><i class="fas fa-pencil-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function Orden($idPedido)
		{
			if(!is_numeric($idPedido)){
				header('Location: ' . BaseUrl(). '/Pedidos');
			}
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}

			$idPersona = "";
			if($_SESSION['userData']['nombrerol'] == "Cliente")
			{
				$idPersona = $_SESSION['userData']['idpersona'];
			}
			$pedido = $this->model->SelectPedido($idPedido, $idPersona);

			$data['page_tag'] ="Pedido";
			$data['page_name'] = "pedido";
			$data['page_title'] = "Pedido <small> Tienda Virtual</smal>";
			$data['arrPedido'] = $pedido;
			$this->views->GetView($this,"orden",$data);
		}

		public function TransaccionPP($transaccion)
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}

			$idPersona = "";
			if($_SESSION['userData']['nombrerol'] == "Cliente")
			{
				$idPersona = $_SESSION['userData']['idpersona'];
			}

			$requestTransaccion = $this->model->SelectTransaccionPaypal($transaccion, $idPersona);
			$data['page_tag'] ="Detalle transacción";
			$data['page_name'] = "detalle_transaccion";
			$data['page_title'] = "Detalle transacción <small> Tienda Virtual</smal>";
			$data['tipopago'] = "paypal";
			$data['objTransaccion'] = $requestTransaccion;
			$data['page_functions_js'] = "functions_pedidos.js";
			$this->views->GetView($this,"transaccion",$data);
		}

		public function TransaccionMP($transaccion)
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}

			$idPersona = "";
			if($_SESSION['userData']['nombrerol'] == "Cliente")
			{
				$idPersona = $_SESSION['userData']['idpersona'];
			}

			$requestTransaccion = $this->model->SelectTransaccionMercadoPago($transaccion, $idPersona);
			$data['page_tag'] ="Detalle transacción";
			$data['page_name'] = "detalle_transaccion";
			$data['page_title'] = "Detalle transacción <small> Tienda Virtual</smal>";
			$data['tipopago'] = "mercadopago";
			$data['objTransaccion'] = $requestTransaccion;
			$data['page_functions_js'] = "functions_pedidos.js";
			$this->views->GetView($this,"transaccion",$data);
		}

		public function GetTransaccionPP(string $transaccion)
		{
			if($_SESSION['permisosMod']['r'] && $_SESSION['userData']['nombrerol'] != "Cliente")
			{
				if($transaccion == "")
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else
				{
					$transaccion = StrClean($transaccion);
					$requestTransaccion = $this->model->SelectTransaccionPaypal($transaccion);
					if(empty($requestTransaccion))
					{
						$arrResponse = array("status" => false, "msg" => 'Datos no disponibles.');
					}else
					{	
						$htmlModal = GetFile("Template/Modals/modalReembolso", $requestTransaccion);
						$arrResponse = array("status" => true, "html" => $htmlModal);
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetTransaccionMP(string $transaccion)
		{
			if($_SESSION['permisosMod']['r'] && $_SESSION['userData']['nombrerol'] != "Cliente")
			{
				if($transaccion == "")
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else
				{
					$transaccion = StrClean($transaccion);
					$requestTransaccion = $this->model->SelectTransaccionMercadoPago($transaccion);
					if(empty($requestTransaccion))
					{
						$arrResponse = array("status" => false, "msg" => 'Datos no disponibles.');
					}else
					{	
						$htmlModal = GetFile("Template/Modals/modalReembolso", $requestTransaccion);
						$arrResponse = array("status" => true, "html" => $htmlModal);
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function SetReembolso()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['nombrerol'] != "Cliente")
				{
					$transaccion = StrClean($_POST['idtransaccion']);
					$observacion = StrClean($_POST['observacion']);
					$requestTransaccion = $this->model->Reembolso($transaccion,$observacion);
					if($requestTransaccion)
					{
						$arrResponse = array("status" => true, "msg" => 'El reembolso se ha procesado.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible procesar el reembolso.');
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No tiene permisos para realizar esta acción.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetPedido(string $pedido)
		{
			if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['nombrerol'] != "Cliente")
			{
				if($pedido == "")
				{
					$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
				}else
				{
					$requestPedido = $this->model->SelectPedido($pedido,"");
					if(empty($requestPedido))
					{
						$arrResponse = array("status" => false, "msg" => 'Datos no disponibles.');
					}else
					{
						$requestPedido['tipospago'] = $this->getTiposPagosT();
						$htmlModal = GetFile("Template/Modals/modalPedido",$requestPedido);
						$arrResponse = array("status" => true, "html" => $htmlModal);
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function SetPedido(){
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'] && $_SESSION['userData']['nombrerol'] != "Cliente")
				{
					$idpedido = !empty($_POST['idPedido']) ? intval($_POST['idPedido']) : "";
				    $transaccion = !empty($_POST['txtTransaccion']) ? StrClean($_POST['txtTransaccion']) : "";
				    $idtipopago = !empty($_POST['listTipopago']) ? intval($_POST['listTipopago']) : "";
				    $estado = !empty($_POST['listEstado']) ? StrClean($_POST['listEstado']) : "";

				    if($idpedido == ""){
				    	$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
				    }else
				    {
				    	if($idtipopago == "")
				    	{
				    		if($estado == "")
				    		{
				    			$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');		
				    		}else
				    		{
				    			$requestPedido = $this->model->UpdatePedido($idpedido, "", "", $estado);
				    			if($requestPedido)
				    			{
				    				$arrResponse = array("status" => true, "msg" => 'Datos actualizados correctamente.');			
				    			}else
				    			{
				    				$arrResponse = array("status" => false, "msg" => 'No es posible actualizar la información.');		
				    			}
				    		}
				    	}else
				    	{
				    		if($estado == "" || $idtipopago == "" || $estado == "")
				    		{
								$arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');		
				    		}else
				    		{
				    			$requestPedido = $this->model->UpdatePedido($idpedido, $transaccion, $idtipopago, $estado);
				    			if($requestPedido)
				    			{
				    				$arrResponse = array("status" => true, "msg" => 'Datos actualizados correctamente.');			
				    			}else
				    			{
				    				$arrResponse = array("status" => false, "msg" => 'No es posible actualizar la información.');		
				    			}
				    		}
				    	}
				    }
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>