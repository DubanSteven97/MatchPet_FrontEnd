<?php

	require_once("Models/LoginModel.php");
	class Donar extends Controllers
	{
		public $login;
		public function __construct()
		{
			session_start();
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Donar()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "donar";
			//$data['animales'] = $this->GetAnimales();
			$data['organizaciones'] = $this->GetOrganizaciones();
			$data['page'] = GetPageRout('donar');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			
			$this->views->GetView($this,"donar",$data);
		}

		public function GetOrganizaciones()
		{
			$url = APP_URL."/Organizacion/GetOrganizaciones";
			$arrData = PeticionGet($url, "application/json","");
			return $arrData;
		}

		public function GetOrganizacion($id)
		{
			$url = APP_URL."/Organizacion/GetOrganizacion/".$id;
			$arrData = PeticionGet($url, "application/json","");
			return $arrData;
		}

		public function procesoDonacion()
		{
			if(empty($_POST))
			{
				header("Location: ".BaseUrl());
			}
			$data['page_tag'] = NOMBRE_EMPRESA. ' - Donación';
			$data['page_title'] = 'Proceso de Donación';
			$data['page_name'] = "donacion";
			$data['monto'] = $_POST["monto"];
			$data['organizacion'] = $this->GetOrganizacion($_POST["radioOrg"]);
			$this->views->GetView($this,"ProcesoDonacion",$data);
		}

		public function ResponseTransaccion()
		{
			
			$url = URLGETPAYMENTMP .'/'.$_GET['payment_id'];
			$pago = CurlConnectionGet($url, 'application/json', ACCESSTOKENMERCADOPAGO);
			$tipopagoid = 4;
			$personaid = $_SESSION['idUser'];
			if($_GET['collection_status']=="pending"){
				$status = "Pendiente";
			}else if ($_GET['collection_status']=="approved"){
				$status = "Aprobado";
			}
			else{
				$status = "Fallido";			
			}
			$this->ProcesaDoncacionMP($personaid, $tipopagoid, $status, json_encode($pago));
		}

		public function ProcesaDoncacionMP(int $personaid, int $tipopagoid, string $status, string $jsonmp)
		{
			
			$idtransaccion = NULL;
			$datostransaccion = NULL;
			$monto = 0;
			$direccionenvio = "";

			$objMp = json_decode($jsonmp);
			if(is_object($objMp))
			{
				$datostransaccion = $jsonmp;
				$idtransaccion = $objMp->id;

				$monto = $objMp->additional_info->items[0]->unit_price;
				$idOrganizacion = $objMp->additional_info->items[0]->id;
				$status = "Completo";
				$request_pedido = $this->model->InsertDonacion($idtransaccion,
														$datostransaccion,
														$personaid,
														$monto,
														$tipopagoid,
														$idOrganizacion,
														$status);
				if($request_pedido>0)
				{
					$dataEmailOrden = array('asunto' => "Se ha realizado la donación No. ".$request_pedido,
											'email' => $_SESSION['userData']['email_user'],
											'emailCopia' => EMAIL_DONACIONES,
											'pedido' => $request_pedido);

					//SendEmail($dataEmailOrden,'ConfirmarOrden');

					$orden = openssl_encrypt($request_pedido, METHODENCRIPT, KEY);
					$transaccion = openssl_encrypt($idtransaccion, METHODENCRIPT, KEY);
					$arrResponse = array(	'status'=> true,
											'orden' => $orden,
											'transaccion' => $transaccion,
											'msg'	=> 'Donación realizada.');
					$_SESSION['dataDonacion'] = $arrResponse;
					session_regenerate_id(true);
				}else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible realizar la donación.');
				}
			}else
			{
				$arrResponse = array(	'status'=> false,
										'msg'	=> 'Hubo un error en la transacción.');
			}
			$this->ConfirmarDonacion();
		}

		public function ConfirmarDonacion()
		{
			if (empty($_SESSION['dataDonacion'])) 
			{
				header("Location: ".BaseUrl());	
			}else
			{
				$dataDonacion = $_SESSION['dataDonacion'];
				$idpedido = openssl_decrypt($dataDonacion['orden'], METHODENCRIPT, KEY);
				$idtransaccion = openssl_decrypt($dataDonacion['transaccion'], METHODENCRIPT, KEY);
				$data['page_tag'] = "Confirmar Donación";
				$data['page_title'] = "Confirmar Donación";
				$data['page_name'] = "confirmar_donacions";
				$data['orden'] = $idpedido;
				$data['transaccion'] = $idtransaccion;
				$this->views->GetView($this,"confirmarDonacion",$data);
				unset($_SESSION['dataDonacion']);
			}
		}

    }
?>
