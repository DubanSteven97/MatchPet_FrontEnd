<?php
	class Login extends Controllers
	{
		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/dashboard');
			}
			parent::__construct();
		}
		public function login()
		{
			$data['page_tag'] ="Login - Tienda Virtual";
			$data['page_title'] = "Login ". NombreApp()."</smal>";
			$data['page_name'] = "login";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->GetView($this,"login",$data);
		}

		public function LoginUser()
		{
			if($_POST)
			{
				if(empty($_POST['txtEmail']) || empty($_POST['txtPassword']))
				{
					$arrResponse = array('status' => false, 'msg' => 'Error de datos.');
				}else
				{
					$strUsuario = strtolower(StrClean($_POST['txtEmail']));
					$strPassword = hash("SHA256", $_POST['txtPassword']);
					$requestUser = $this->model->LoginUser($strUsuario, $strPassword);
					if(empty($requestUser))
					{
						$arrResponse = array('status' => false, 'msg' => 'Usuario o contraseña es incorrectos.');	
					}else
					{
						$arrData = $requestUser;
						if($arrData['status'] == 1)
						{
							$_SESSION['idUser'] = $arrData['idpersona'];
							$_SESSION['login'] = true;
							$_SESSION['timeout'] = true;
							$_SESSION['inicio'] = time();
							$arrData = $this->model->SessionLogin($_SESSION['idUser']);
							$_SESSION['userData'] = $arrData;
							$arrResponse = array('status' => true, 'msg' => 'ok');		
						}else{
							$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');		
						}
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function ResetPass()
		{
			if($_POST)
			{
				error_reporting(0);
				if(empty($_POST['txtEmailReset']))
				{
					$arrResponse = array('status' => false, 'msg' => 'Error de datos.');
				}else
				{
					$token = Token();
					$strEmail = strtolower(StrClean($_POST['txtEmailReset']));
					$arrData = $this->model->GetUserEmail($strEmail);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.');	
					}else
					{
						$idPersona = $arrData['idpersona'];
						$nombreUsuario = $arrData['nombres'] . ' ' . $arrData['apellidos'];

						$urlRecovery = BaseUrl().'/Login/ConfirmUser/'.$strEmail.'/'.$token;

						$requestUpdate = $this->model->SetTokenUser($idPersona, $token);

						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
						'email' => $strEmail,
						'asunto' => 'Recuperar cuenta - '. NOMBRE_REMITENTE,
						'urlRecovery' => $urlRecovery);


						if($requestUpdate)
						{
							//$sendEmail = SendEmail($dataUsuario,'CambioPassword');
							//if($sendEmail)
							//{
								$arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
							//}else
							//{
							//	$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');		
							//}
						}else
						{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
						}
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function ConfirmUser(string $params)
		{
			if(empty($params))
			{
				header('Location: '. BaseUrl());
			}else
			{
				$arrParams = explode(',', $params);
				$strEmail = StrClean($arrParams[0]);
				$strToken = StrClean($arrParams[1]);
				$arrResponse = $this->model->GetUsuario($strEmail, $strToken);
				if(empty($arrResponse))
				{
					header("Location: ".BaseUrl());
				}else
				{
					$data['page_tag'] ="Cambiar contrasela - Tienda Virtual";
					$data['page_title'] = "Cambiar Contraseña";
					$data['page_name'] = "cambiar_contrasenia";
					$data['idpersona'] = $arrResponse['idpersona'];
					$data['email'] = $strEmail;
					$data['token'] = $strToken;
					$data['page_functions_js'] = "functions_login.js";
					$this->views->GetView($this,"CambiarPassword",$data);
				}
			}
			die();
		}

		public function SetPassword()
		{
			if(empty($_POST['idUsuario']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']))
			{
				$arrResponse = array('status' => false, 'msg' => 'Error de datos.');
			}else
			{
				$intIdPersona = intval($_POST['idUsuario']);
				$strPassword = $_POST['txtPassword'];
				$strPasswordConfirm = $_POST['txtPasswordConfirm'];
				$strEmail = StrClean($_POST['txtEmail']);
				$strToken = StrClean($_POST['txtToken']);
				if($strPassword != $strPasswordConfirm)
				{
					$arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.');
				}else
				{
					$arrResponseUser = $this->model->GetUsuario($strEmail, $strToken);
					if(empty($arrResponseUser))
					{
						$arrResponse = array('status' => false, 'msg' => 'Error de datos.');
					}else
					{
						$strPassword = hash("SHA256", $strPassword);
						$requestPass = $this->model->InsertPassword($intIdPersona, $strPassword);
						if($requestPass)
						{
							$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con éxito.');
						}else
						{
							$arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
						}
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
?>
