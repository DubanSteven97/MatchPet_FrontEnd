<?php
	class Suscriptores extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Suscriptores');
		}
		public function Suscriptores()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Suscriptores";
			$data['page_name'] = "suscriptores";
			$data['page_title'] = "Suscriptores <small> Tienda Virtual</smal>";
			$data['page_functions_js'] = "functions_suscriptores.js";
			$this->views->GetView($this,"suscriptores",$data);
		}

		public function GetSuscriptores()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectSuscriptores();
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function SetSuscripcion()
		{
			if($_POST)
			{
				$nombre = ucwords(strtolower(StrClean($_POST['nombreSuscripcion'])));
				$email = strtolower(StrClean($_POST['emailSuscripcion']));

				$suscripcion = $this->model->SetSuscripcion($nombre, $email);
				if($suscripcion > 0)
				{
					$arrResponse = array(	'status'=> true,
											'msg'	=> 'Gracias por tu suscripción.');
					//Enviar Correo
					$dataEmailSuscripcion = array('asunto' => "Nueva Suscripción",
											'email' => EMAIL_SUSCRIPCION,
											'cliente' => EMAIL_CONTACTO,
											'nombreSuscriptor' => $nombre,
											'emailSuscriptor' => $email);

					SendEmailPhpMailer($dataEmailSuscripcion,'Suscripcion');
				}
				else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'El email ya fue registrado.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
	}
?>