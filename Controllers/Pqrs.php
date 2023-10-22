<?php
	class Pqrs extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}

		}
		public function Clientes()
		{

		}

		public function sendEmail()
		{
			if(empty($_POST['tipoPQRS']) ||
			    empty($_POST['razonPQRS']) ||
			    empty($_POST['txtNombre']) ||
			    empty($_POST['txtApellidos']) ||
			    empty($_POST['txtEmail']) ||
			    empty($_POST['txtTelefono']))

		   	{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{
				$strRazon = ucwords(StrClean($_POST['tipoPQRS']));
                $strRazon = ucwords(StrClean($_POST['razonPQRS']));
                $strNombres = ucwords(StrClean($_POST['txtNombre']));
				$strApellidos = ucwords(StrClean($_POST['txtApellidos']));
				$intTelefono = intval(StrClean($_POST['txtTelefono']));
				$strEmail = strtolower(StrClean($_POST['txtEmail']));
               
                $data = array(
                    "asunto" => "Se genero una".$strRazon,
                    "emailCopia" => $strEmail,
                    "cliente" => $strNombres.$strApellidos
                );
				
                
				$request_user = SendEmailPqrs($data,"Pqrs");
	
				if($request_user=="true")
				{
                    $arrResponse = array(	'status'=> true,
                                            'msg'	=> 'Se envió su PQRS correctamente.');

				}else if($request_user == 'false')
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> '¡Atención! Hubo un problema con el envío, por favor intenté nuevamente.');
				}
		   	}
		   	echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
		
	}
?>