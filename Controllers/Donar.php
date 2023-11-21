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

    }
?>
