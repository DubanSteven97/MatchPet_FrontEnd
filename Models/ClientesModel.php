<?php
	class ClientesModel extends Mysql
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

		public function InsertCliente(int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status, int $strnit, string $strrazon, string $strdireccion )
		{
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $rolId;
			$this->intStatus = $status;
			$this->strNit = $strnit;
			$this->strNombreFiscal = $strrazon;
			$this->intDireccionFiscal = $strdireccion;
			$return = 0;
			$sql = "SELECT * FROM persona WHERE
					email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO persona (identificacion, nombres, apellidos, telefono, email_user, password, rolid, status, nit, nombrefiscal, direccionfiscal) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombres,
								$this->strApellidos,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intRolId,
								$this->intStatus,
								$this->strNit,
								$this->strNombreFiscal,
								$this->intDireccionFiscal);
				$request_insert = $this->Insert($query_insert, $arrData);
				$return = $request_insert;
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function SelectClientes()
		{	
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1)
			{
				$whereAdmin = "  AND p.idpersona != 1 ";
			}
			$cliente = '  AND r.nombrerol =  "Cliente"';
			$sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.status, r.idrol, r.nombrerol FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.status != 0".$whereAdmin.$cliente;
			$request = $this->SelectAll($sql);

			return $request;
		}

		public function SelectCliente(int $idPersona)
		{
			$this->intIdUsuario = $idPersona;
			$sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.nit,  p.nit,p.nombrefiscal, p.direccionfiscal, r.idrol, r.nombrerol, p.status, DATE_FORMAT(p.datecreated,'%d-%m-%Y') as fechaRegistro FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.idpersona = $this->intIdUsuario";
			$request = $this->Select($sql);
			return $request;
		}

		public function UpdateCliente(int $idUsuario, int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status,int $strnit, string $strrazon, string $strdireccion )
		{
			$this->intIdUsuario = $idUsuario;
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $rolId;
			$this->intStatus = $status;
			$this->strNit = $strnit;
			$this->strNombreFiscal = $strrazon;
			$this->intDireccionFiscal = $strdireccion;

			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idPersona != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND idPersona != $this->intIdUsuario)";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				if($this->strPassword == "")
				{
					$queryUpdate = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, rolid = ?, status = ? , nit = ? , nombrefiscal = ? , direccionfiscal = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->intRolId,$this->intStatus,$this->strNit,$this->strNombreFiscal,$this->intDireccionFiscal);
				}else
				{
					$queryUpdate = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, password = ?, rolid = ?, status = ? , nit = ? , nombrefiscal = ? , direccionfiscal = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->strPassword,$this->intRolId,$this->intStatus,$this->strNit,$this->strNombreFiscal,$this->intDireccionFiscal);
				}
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteCliente(int $idUsuario)
		{
			$this->intIdUsuario = intval($idUsuario);
			$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario";
			$arrData = array(0);
			$request = $this->Update($sql,$arrData);
			return $request;
		}

	}

?>