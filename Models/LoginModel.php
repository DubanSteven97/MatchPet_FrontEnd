<?php
	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}

		public function LoginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT idpersona, status FROM persona WHERE email_user = '$this->strUsuario' AND password = '$this->strPassword' AND status != 0";
			$request = $this->Select($sql);
			return $request;
		}

		public function SessionLogin(int $idUser)
		{
			$this->intIdUsuario = $idUser;
			$sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.nit, p.nombrefiscal, p.direccionfiscal, r.idrol, r.nombrerol, p.status FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.idpersona = $this->intIdUsuario";
			$request = $this->Select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

		public function GetUserEmail(string $strEmail)
		{
			$this->strUsuario = $strEmail;
			$sql = "SELECT idpersona, nombres, apellidos, status FROM persona WHERE email_user = '$this->strUsuario' AND status = 1";
			$request = $this->Select($sql);
			return $request;
		}

		public function SetTokenUser(int $idPersona, string $token)
		{
			$this->intIdUsuario = $idPersona;
			$this->strToken = $token;
			$sql = "UPDATE persona SET token = ? WHERE idpersona = $this->intIdUsuario";
			$arrData = array($this->strToken);
			$request = $this->Update($sql,$arrData);
			return $request;
		}

		public function GetUsuario(string $email, string $token)
		{
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT idpersona FROM persona WHERE email_user = '$this->strUsuario' AND token = '$this->strToken' AND status = 1";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertPassword(int $idPersona, string $password)
		{
			$this->intIdUsuario = intval($idPersona);
			$this->strPassword = $password;
			$sql = "UPDATE persona SET password = ?, token = ? WHERE idpersona = $this->intIdUsuario";
			$arrData = array($this->strPassword, '');
			$request = $this->Update($sql,$arrData);
			return $request;
		}
	}

?>