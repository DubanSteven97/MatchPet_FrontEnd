<?php
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");

	require_once("Models/LoginModel.php");
	class Tienda extends Controllers
	{
		use TProducto, TCliente;
		public $login;
		public function __construct()
		{
			session_start();
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Tienda()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "tienda";
			$data['productos'] = $this->GetProductosT();
			$this->views->GetView($this,"tienda",$data);
		}

		public function Categoria($params)
		{
			if(empty($params))
			{
				header("Location: ".BaseUrl());
			}else
			{
				$arrParams = explode(",",$params);
				$idCategoria = intval($arrParams[0]);
				$ruta = StrClean($arrParams[1]);
				$infoCategoria = $this->GetProductosCategoriaT($idCategoria, $ruta);
				$categoria = $infoCategoria['categoria'];
				$data['page_tag'] = NOMBRE_EMPRESA . " - " .$categoria;
				$data['page_title'] = $categoria;
				$data['page_name'] = "categoria";
				$data['productos'] = $infoCategoria['productos'];
				$this->views->GetView($this,"categoria",$data);
			}
		}

		public function Producto($params)
		{
			if(empty($params))
			{
				header("Location: ".BaseUrl());
			}else
			{
				$arrParams = explode(",",$params);
				$idProducto = intval($arrParams[0]);
				$ruta = StrClean($arrParams[1]);
				$producto = $this->GetProductoT($idProducto, $ruta);
				if(empty($producto))
				{
					header("Location: ".BaseUrl());
				}
				$data['page_tag'] = NOMBRE_EMPRESA . " - " .$producto['nombre'];
				$data['page_title'] = $producto['nombre'];
				$data['page_name'] = "producto";
				$data['producto'] = $producto;
				$data['productos'] = $this->GetProductosRandomT($data['producto']['categoriaid'],8, "r");
				$this->views->GetView($this,"producto",$data);
			}
		}

		public function AddCarrito()
		{
			if($_POST)
			{
				$arrCarrito = array();
				$cantCarrito = 0;
				$idProducto = openssl_decrypt($_POST['id'],METHODENCRIPT, KEY);
				$cantidad = $_POST['cant'];
				if(is_numeric($idProducto) && is_numeric($cantidad))
				{
					$arrayInfoProducto = $this->GetProductoIdT($idProducto);
					if(!empty($arrayInfoProducto))
					{
						$arrProducto = array('idproducto' => $idProducto,
											'producto' => $arrayInfoProducto['nombre'],
											'cantidad' => $cantidad,
											'precio' => $arrayInfoProducto['precio'],
											'imagen' => $arrayInfoProducto['images'][0]['url_image']
										);
						if(isset($_SESSION['arrCarrito']))
						{
							$on = true;
							$arrCarrito = $_SESSION['arrCarrito'];
							for ($pr=0; $pr < count($arrCarrito); $pr++) { 
								if($arrCarrito[$pr]['idproducto'] == $idProducto)
								{
									$arrCarrito[$pr]['cantidad']+=$cantidad;
									$on=false;
								}
							}
							if($on)
							{
								array_push($arrCarrito, $arrProducto);
							}
							$_SESSION['arrCarrito'] = $arrCarrito;		
						}else
						{
							array_push($arrCarrito, $arrProducto);
							$_SESSION['arrCarrito'] = $arrCarrito;
						}
						foreach ($_SESSION['arrCarrito'] as $pro) {
							$cantCarrito += $pro['cantidad'];
						}
						$htmlCarrito = GetFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);
						$arrResponse = array(	'status'=> true,
												'msg'	=> '¡Se agregó al carrito!',
												'cantCarrito' => $cantCarrito,
												'htmlCarrito' => $htmlCarrito);
					}else
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Producto no existente.');
					}
				}else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function DelCarrito()
		{
			if($_POST)
			{
				$arrCarrito = array();
				$cantCarrito = 0;
				$subTotal = 0;
				$idProducto = openssl_decrypt($_POST['id'],METHODENCRIPT, KEY);
				$option = $_POST['option'];
				if(is_numeric($idProducto) && ($option == 1 || $option == 2))
				{
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($pr=0; $pr < count($arrCarrito); $pr++) { 
						if($arrCarrito[$pr]['idproducto'] == $idProducto)
						{
							unset($arrCarrito[$pr]);
						}
					}
					sort($arrCarrito);
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$cantCarrito += $pro['cantidad'];
						$subTotal += $pro['cantidad']*$pro['precio'];
					}
					$htmlCarrito = "";
					if($option == 1)
					{
						$htmlCarrito = GetFile('Template/Modals/modalCarrito',$_SESSION['arrCarrito']);	
					}
					
					$arrResponse = array(	'status'=> true,
											'msg'	=> '¡Producto eliminado!',
											'cantCarrito' => $cantCarrito,
											'htmlCarrito' => $htmlCarrito,
											'subTotal' => FormatMoney($subTotal),
											'total' => FormatMoney($subTotal + COSTOENVIO)
											);
				}else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function UpdCarrito()
		{
			if($_POST){
				$arrCarrito = array();
				$totalProducto = 0;
				$subTotal = 0;
				$total = 0;
				$cantCarrito = 0;
				$idProducto = openssl_decrypt($_POST['id'],METHODENCRIPT, KEY);
				$cantidad = intval($_POST['cant']);
				if(is_numeric($idProducto) && $cantidad > 0)
				{
					$arrCarrito = $_SESSION['arrCarrito'];
					for ($p=0; $p < count($arrCarrito); $p++) { 
						if($arrCarrito[$p]['idproducto'] == $idProducto)
						{
							$arrCarrito[$p]['cantidad'] = $cantidad;
							$totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
							break;
						}
					}					
					$_SESSION['arrCarrito'] = $arrCarrito;
					foreach ($_SESSION['arrCarrito'] as $pro) {
						$subTotal += $pro['cantidad']*$pro['precio'];
					}
					$arrResponse = array(	'status'=> true,
											'msg'	=> '¡Producto actualizado!',
											'totalProducto' => FormatMoney($totalProducto),
											'subTotal' => FormatMoney($subTotal),
											'total' => FormatMoney($subTotal + COSTOENVIO));
				}else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function Registro()
		{
			if( empty($_POST['txtNombre']) ||
			    empty($_POST['txtApellido']) ||
			    empty($_POST['txtTelefono']) ||
			    empty($_POST['txtEmailCliente']))
		   	{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{
				$strNombres = ucwords(StrClean($_POST['txtNombre']));
				$strApellidos = ucwords(StrClean($_POST['txtApellido']));
				$intTelefono = intval(StrClean($_POST['txtTelefono']));
				$strEmail = strtolower(StrClean($_POST['txtEmailCliente']));
				$intTipoId = intval($this->GetIdRolT('Cliente'));

				$request = "";
				$strPassword = PassGenerator();
				$strPasswordEncript = hash("SHA256",$strPassword);
				$request = $this->InsertClienteT(
												$strNombres,
												$strApellidos,
												$intTelefono,
												$strEmail,
												$strPasswordEncript,
												$intTipoId
												);
				if($request>0)
				{
					$arrResponse = array(	'status'=> true,
											'msg'	=> 'Datos guardados correctamente.');
					$nombreUsuario = $strNombres.' '.$strApellidos;

					$dataUsuario = array('nombreUsuario' => $nombreUsuario,
									'email' => $strEmail,
									'password' => $strPassword,
									'asunto' => 'Bienvenido a tu tienda en línea');
					$_SESSION['idUser'] = $request;
					$_SESSION['login'] = true;	
					$this->login->SessionLogin($request);
					//SendEmail($dataUsuario,'Bienvenida');

				}else if($request == 'exist')
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> '¡Atención! El email ya existe.');
				}else 
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar los datos');
				}
		   	}
		   	echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function procesarVenta(){
			if($_POST)
			{
				$idtransaccion = NULL;
				$datostransaccion = NULL;
				$personaid = $_SESSION['idUser'];
				$monto = 0;
				$tipopagoid = intval($_POST['inttipopago']);
				$direccionenvio = StrClean($_POST['direccion']). ', '. StrClean($_POST['ciudad']);
				$status = "Pendiente";
				$subTotal = 0;
				$costo_envio = COSTOENVIO;

				if(!empty($_SESSION['arrCarrito']))
				{
					foreach ($_SESSION['arrCarrito'] as $producto) 
					{
						$subTotal += $producto['precio']*$producto['cantidad'];
					}
					$monto = $subTotal + $costo_envio;

					if(empty($_POST['datapay']))
					{
						$request_pedido = $this->InsertPedidoT(	$idtransaccion,
																$datostransaccion,
																$personaid,
																$costo_envio,
																$monto,
																$tipopagoid,
																$direccionenvio,
																$status);
						if($request_pedido>0)
						{
							foreach ($_SESSION['arrCarrito'] as $producto) 
							{
								$productoid = $producto['idproducto'];
								$precio = $producto['precio'];
								$cantidad = $producto['cantidad'];
								$this->InsertDetalle($request_pedido, $productoid, $precio, $cantidad);
							}
							$infoOrden = $this->GetPedido($request_pedido);
							$dataEmailOrden = array('asunto' => "Se ha creado la orden No. ".$request_pedido,
													'email' => $_SESSION['userData']['email_user'],
													'emailCopia' => EMAIL_PEDIDOS,
													'pedido' => $infoOrden);

//							SendEmail($dataEmailOrden,'ConfirmarOrden');

							$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
							$transaccion = openssl_encrypt($idtransaccion, METHODENCRIPT, KEY);
							$arrResponse = array(	'status'=> true,
													'orden' => $orden,
													'transaccion' => $transaccion,
													'msg'	=> 'Pedido realizado.');
							$_SESSION['dataOrden'] = $arrResponse;
							unset($_SESSION['arrCarrito']);
							session_regenerate_id(true);
						}else
						{
							$arrResponse = array(	'status'=> false,
													'msg'	=> 'No es posible almacenar el pedido.');
						}
					}else
					{
						$jsonpaypal = $_POST['datapay'];
						$objPaypal = json_decode($jsonpaypal);
						$status = "Aprobado";

						if(is_object($objPaypal))
						{
							$datostransaccion = $jsonpaypal;
							$idtransaccion = $objPaypal->purchase_units[0]->payments->captures[0]->id;
							if($objPaypal->status == "COMPLETED")
							{
								$totalPaypal = $objPaypal->purchase_units[0]->amount->value;
								if($monto == $totalPaypal)
								{
									$status = "Completo";
								}

								$request_pedido = $this->InsertPedidoT(	$idtransaccion,
																		$datostransaccion,
																		$personaid,
																		$costo_envio,
																		$monto,
																		$tipopagoid,
																		$direccionenvio,
																		$status);
								if($request_pedido>0)
								{
									foreach ($_SESSION['arrCarrito'] as $producto) 
									{
										$productoid = $producto['idproducto'];
										$precio = $producto['precio'];
										$cantidad = $producto['cantidad'];
										$this->InsertDetalle($request_pedido, $productoid, $precio, $cantidad);
									}

									$infoOrden = $this->GetPedido($request_pedido);
									$dataEmailOrden = array('asunto' => "Se ha creado la orden No. ".$request_pedido,
															'email' => $_SESSION['userData']['email_user'],
															'emailCopia' => EMAIL_PEDIDOS,
															'pedido' => $infoOrden);

//									SendEmail($dataEmailOrden,'ConfirmarOrden');

									$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
									$transaccion = openssl_encrypt($idtransaccion, METHODENCRIPT, KEY);
									$arrResponse = array(	'status'=> true,
															'orden' => $orden,
															'transaccion' => $transaccion,
															'msg'	=> 'Pedido realizado.');
									$_SESSION['dataOrden'] = $arrResponse;
									unset($_SESSION['arrCarrito']);
									session_regenerate_id(true);
								}else
								{
									$arrResponse = array(	'status'=> false,
															'msg'	=> 'No es posible almacenar el pedido.');
								}
							}else
							{
								$arrResponse = array(	'status'=> false,
														'msg'	=> 'No es posible completar el pago.');
							}
						}else
						{
							$arrResponse = array(	'status'=> false,
													'msg'	=> 'Hubo un error en la transacción.');
						}
					}
				}else
				{
					$arrResponse = array(	'status'=> false,
												'msg'	=> 'No es posible almacenar el pedido');		
				}
			}else
			{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar el pedido');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function ConfirmarPedido()
		{
			if (empty($_SESSION['dataOrden'])) 
			{
				header("Location: ".BaseUrl());	
			}else
			{
				$dataOrden = $_SESSION['dataOrden'];
				$idpedido = openssl_decrypt($dataOrden['orden'], METHODENCRIPT, KEY);
				$idtransaccion = openssl_decrypt($dataOrden['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Pedido";
				$data['page_title'] = "Confirmar Pedido";
				$data['page_name'] = "confirmar_pedido";
				$data['orden'] = $idpedido;
				$data['transaccion'] = $idtransaccion;
				$this->views->GetView($this,"confirmarPedido",$data);
				unset($_SESSION['dataOrden']);
			}
		}

		public function ResponsePedido()
		{
			$url = URLGETPAYMENTMP .'/'.$_GET['payment_id'];
			$pago = CurlConnectionGet($url, 'application/json', ACCESSTOKENMERCADOPAGO);

			$tipopagoid = 2;
			$personaid = $_SESSION['idUser'];
			if($_GET['collection_status']=="pending"){
				$status = "Pendiente";
			}else if ($_GET['collection_status']=="approved"){
				$status = "Aprobado";
			}
			else{
				$status = "Fallido";			
			}
			$this->ProcesaVentaMP($personaid, $tipopagoid, $status, json_encode($pago));
		}

		public function ProcesaVentaMP(int $personaid, int $tipopagoid, string $status, string $jsonmp)
		{
			
			$idtransaccion = NULL;
			$datostransaccion = NULL;
			$monto = 0;
			$direccionenvio = "";
			$subTotal = 0;
			$costo_envio = COSTOENVIO;

			if(!empty($_SESSION['arrCarrito']))
			{
				foreach ($_SESSION['arrCarrito'] as $producto) 
				{
					$subTotal += $producto['precio']*$producto['cantidad'];
				}
				$monto = $subTotal + $costo_envio;
				
				$objMp = json_decode($jsonmp);
				if(is_object($objMp))
				{
					$datostransaccion = $jsonmp;
					$idtransaccion = $objMp->id;

					$totalMp = $objMp->transaction_amount;
					if($monto == $totalMp)
					{
						$status = "Completo";
					}

					$request_pedido = $this->InsertPedidoT(	$idtransaccion,
															$datostransaccion,
															$personaid,
															$costo_envio,
															$monto,
															$tipopagoid,
															$direccionenvio,
															$status);
					if($request_pedido>0)
					{
						foreach ($_SESSION['arrCarrito'] as $producto) 
						{
							$productoid = $producto['idproducto'];
							$precio = $producto['precio'];
							$cantidad = $producto['cantidad'];
							$this->InsertDetalle($request_pedido, $productoid, $precio, $cantidad);
						}

						$infoOrden = $this->GetPedido($request_pedido);
						$dataEmailOrden = array('asunto' => "Se ha creado la orden No. ".$request_pedido,
												'email' => $_SESSION['userData']['email_user'],
												'emailCopia' => EMAIL_PEDIDOS,
												'pedido' => $infoOrden);

//						SendEmail($dataEmailOrden,'ConfirmarOrden');

						$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
						$transaccion = openssl_encrypt($idtransaccion, METHODENCRIPT, KEY);
						$arrResponse = array(	'status'=> true,
												'orden' => $orden,
												'transaccion' => $transaccion,
												'msg'	=> 'Pedido realizado.');
						$_SESSION['dataOrden'] = $arrResponse;
						unset($_SESSION['arrCarrito']);
						session_regenerate_id(true);
					}else
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'No es posible almacenar el pedido.');
					}
				}else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Hubo un error en la transacción.');
				}
			}else
			{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar el pedido');		
			}
			$this->ConfirmarPedido();
		}
	}
?>