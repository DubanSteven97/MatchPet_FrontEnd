<?php
	require_once("Models/TProducto.php");
	require_once("Models/TCliente.php");

	require_once("Models/LoginModel.php");
	class Adoptables extends Controllers
	{
		use TProducto, TCliente;
		public $login;
		public function __construct()
		{
			session_start();
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Adoptables()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "adoptable";
			$data['animales'] = $this->GetAnimales();
			$data['page'] = GetPageRout('adoptables');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			$this->views->GetView($this,"adoptables",$data);
		}


		public function GetAnimales()
		{
			$idOrhanizacion = 0;
			$url = APP_URL . "/Animal/GetAnimales/" . $idOrhanizacion;
			$arrData = PeticionGet($url, "application/json", "");
			$ahora = new DateTime(date("Y-m-d"));
		
			$animalesFiltrados = [];
		
			for ($p = 0; $p < count($arrData); $p++) {
				if ($arrData[$p]->estado > 0) {
					$nacimiento = new DateTime($arrData[$p]->fecha_nacimiento);
					$diferencia = $ahora->diff($nacimiento);
					$arrData[$p]->edad = $diferencia->format("%y");
					$intidAnimal = $arrData[$p]->idAnimal;
					$url_img = APP_URL . "/Animal/GetImgByAnimal/" . $intidAnimal;
					$requestImg = PeticionGet($url_img, "application/json", "");
		
					if (count($requestImg) > 0) {
						for ($i = 0; $i < count($requestImg); $i++) {
							$requestImg[$i]->url_image = $requestImg[$i]->img;
						}
					}
		
					$arrData[$p]->images = $requestImg;
		
					// Agregar el animal al array resultante
					$animalesFiltrados[] = $arrData[$p];
				}
			}
			return $animalesFiltrados;
		}

		public function TipoAnimal($params)
		{
			if(empty($params))
			{
				header("Location: ".BaseUrl());
			}else
			{
				$arrParams = explode(",",$params);
				$idTipoAnimal = intval($arrParams[0]);
				$ruta = StrClean($arrParams[1]);
				$infoTipoAnimal = $this->GetAnimalesByTipoAnimal($idTipoAnimal, $ruta);
				$tipoAnimal = $infoTipoAnimal->tipoAnimal;
				$data['page_tag'] = NOMBRE_EMPRESA . " - " .$tipoAnimal;
				$data['page_title'] = $tipoAnimal;
				$data['page_name'] = "tipoAnimal";
				$data['animales'] = $infoTipoAnimal->animales;
				$this->views->GetView($this,"tipoAnimal",$data);
			}
		}

		public function GetAnimalesByTipoAnimal($idTipoAnimal, $ruta)
		{
			$url = APP_URL."/Animal/GetAnimalesByTipo/".$idTipoAnimal;
			$arrData = PeticionGet($url, "application/json", "");
			$ahora = new DateTime(date("Y-m-d"));
			for($p=0;$p<count($arrData);$p++){
				$nacimiento = new DateTime($arrData[$p]->fecha_nacimiento);
				$diferencia = $ahora->diff($nacimiento);
				$arrData[$p]->edad = $diferencia->format("%y");
				$intidAnimal = $arrData[$p]->idAnimal; 
				$url_img = APP_URL."/Animal/GetImgByAnimal/".$intidAnimal;
				$requestImg = PeticionGet($url_img, "application/json", "");
				if(count($requestImg)>0)
				{
					for ($i=0; $i < count($requestImg); $i++) { 
						$requestImg[$i]->url_image = $requestImg[$i]->img;
					}
				}
				$arrData[$p]->images = $requestImg;
			}
			$resp = (object) array('idTipoAnimal' => $idTipoAnimal,
									'tipoAnimal' => $arrData[0]->tipoAnimal,
								'animales' => $arrData);
			return $resp;
		}

		public function Animal($params)
		{
			if(empty($params))
			{
				header("Location: ".BaseUrl());
			}else
			{
				$arrParams = explode(",",$params);
				$idAnimal = intval($arrParams[0]);
				$ruta = StrClean($arrParams[1]);
				$animal = $this->GetAnimal($idAnimal, $ruta);
				if(empty($animal))
				{
					header("Location: ".BaseUrl());
				}
				$data['page_tag'] = NOMBRE_EMPRESA . " - " .$animal->nombre;
				$data['page_title'] = $animal->nombre;
				$data['page_name'] = "animal";
				$data['animal'] = $animal;
				#$data['productos'] = $this->GetProductosRandomT($data['producto']['categoriaid'],8, "r");
				$this->views->GetView($this,"animal",$data);
			}
		}

		public function GetAnimal(int $idAnimal,string $ruta)
		{
			$url = APP_URL."/Animal/GetAnimal/".$idAnimal;
			$arrData = PeticionGet($url, "application/json", "");
			$ahora = new DateTime(date("Y-m-d"));
			if(!empty($arrData))
			{
				$nacimiento = new DateTime($arrData->fecha_nacimiento);
				$diferencia = $ahora->diff($nacimiento);
				$arrData->edad = $diferencia->format("%y");
				$url_org = APP_URL."/Organizacion/GetOrganizacion/".$arrData->idOrganizacion;
				$arrData_org = PeticionGet($url_org, "application/json", "");
				$arrData->organizacionNombre = $arrData_org->nombre;
				$intidAnimal = $arrData->idAnimal; 
				$url_img = APP_URL."/Animal/GetImgByAnimal/".$intidAnimal;
				$requestImg = PeticionGet($url_img, "application/json", "");
				if(count($requestImg)>0)
				{
					for ($i=0; $i < count($requestImg); $i++) { 
						$requestImg[$i]->url_image = $requestImg[$i]->img;
					}
				}
				$arrData->images = $requestImg;
				
			}

			return $arrData;
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
				$intTipoId = intval($this->GetIdRolT('Amigo'));
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
				if($request>0 && $request != "exist")
				{
					
					$arrResponse = array(	'status'=> true,
											'msg'	=> 'Datos guardados correctamente.');
					$nombreUsuario = $strNombres.' '.$strApellidos;
					
					$dataUsuario = array('nombreUsuario' => $nombreUsuario,
									'email' => $strEmail,
									"cliente" => $strEmail,
									"emailCopia" => $strEmail,
									'password' => $strPassword,
									'asunto' => '¡Bienvenido a MatchPet!');
					$_SESSION['idUser'] = $request;
					$_SESSION['login'] = true;	
					$this->login->SessionLogin($request);
					SendEmailPhpMailer($dataUsuario,'Bienvenida');

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