<?php
	class RegistroModel extends Mysql
	{

		private $intIdUsuario;
		private $strIdentificacion;
		private $strNombres;
		private $strApellidos;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intRolId;
		private $intStatus;
		private $strNit;
		private $strNombreFiscal;
		private $intDireccionFiscal;
		
		
		public function __construct()
		{
			parent::__construct();
		}

		public function InsertUsuario(int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status)
		{
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $rolId;
			$this->intStatus = $status;
			$return = 0;
			$sql = "SELECT * FROM persona WHERE
					email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO persona (identificacion, nombres, apellidos, telefono, email_user, password, rolid, status) VALUES (?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombres,
								$this->strApellidos,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intRolId,
								$this->intStatus);
				$request_insert = $this->Insert($query_insert, $arrData);
				$return = $request_insert;
			}else
			{
				$return = "exist";
			}
			return $return;
		}
	}

?>