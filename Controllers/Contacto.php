<?php
	class Contacto extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			GetPermisos('Paginas');
		}
		public function Contacto()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "matchpet";
			$data['page'] = GetPageRout('contacto');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			$this->views->GetView($this,"contacto",$data);
		}

		public function SetContacto()
		{
			if($_POST)
			{
				$nombre = ucwords(strtolower(StrClean($_POST['nombreContacto'])));
				$email = strtolower(StrClean($_POST['emailContacto']));
				$mensaje = StrClean($_POST['mensaje']);

				$userAgent = $_SERVER['HTTP_USER_AGENT'];
				$ip = $_SERVER['REMOTE_ADDR'];
				$dispositivo = 'PC';

				if(preg_match("/mobile/i", $userAgent))
				{
					$dispositivo = "Movil";
				}
				if(preg_match("/tablet/i", $userAgent))	
				{
					$dispositivo = "Tablet";
				}
				if(preg_match("/iPad/i", $userAgent))	
				{
					$dispositivo = "iPad";
				}	
				if(preg_match("/iPhone/i", $userAgent))	
				{
					$dispositivo = "iPhone";
				}

				$userContact = $this->model->SetContacto($nombre, $email, $mensaje, $ip, $dispositivo, $userAgent);
				if($userContact > 0)
				{
					$arrResponse = array(	'status'=> true,
											'msg'	=> 'Gracias por tu mensaje.');
					//Enviar Correo
					$dataUsuario = array('asunto' => "Nuevo contacto",
											'email' => EMAIL_CONTACTO,
											'cliente' => EMAIL_CONTACTO,
											'nombreContacto' => $nombre,
											'emailContacto' => $email,
											'mensaje' => $mensaje);

					SendEmailPhpMailer($dataUsuario,'Contacto');
				}
				else
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible enviar el mensaje.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>