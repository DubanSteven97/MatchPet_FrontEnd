<?php
	class UsuariosModel extends Mysql
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

		public function SelectUsuarios()
		{	
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1)
			{
				$whereAdmin = "  AND p.idpersona != 1 ";
			}
			$sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.status, r.idrol, r.nombrerol FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.status != 0".$whereAdmin;
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectUsuario(int $idPersona)
		{
			$this->intIdUsuario = $idPersona;
			$sql = "SELECT p.idpersona, p.identificacion, p.nombres, p.apellidos, p.telefono, p.email_user, p.nit, p.nombrefiscal, p.direccionfiscal, r.idrol, r.nombrerol, p.status, DATE_FORMAT(p.datecreated,'%d-%m-%Y') as fechaRegistro FROM persona p INNER JOIN rol r ON p.rolid = r.idrol WHERE p.idpersona = $this->intIdUsuario";
			$request = $this->Select($sql);
			return $request;
		}

		public function UpdateUsuario(int$idUsuario, int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status)
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

			$sql = "SELECT * FROM persona WHERE (email_user = '{$this->strEmail}' AND idPersona != $this->intIdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND idPersona != $this->intIdUsuario)";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				if($this->strPassword == "")
				{
					$queryUpdate = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, rolid = ?, status = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->intRolId,$this->intStatus);
				}else
				{
					$queryUpdate = "UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email_user = ?, password = ?, rolid = ?, status = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->strPassword,$this->intRolId,$this->intStatus);
				}
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteUsuario(int $idUsuario)
		{
			$this->intIdUsuario = intval($idUsuario);
			$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario";
			$arrData = array(0);
			$request = $this->Update($sql,$arrData);
			return $request;
		}

		public function UpdatePerfil(int $idUsuario, string $nombres, string $apellidos, int $telefono, string $password)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strPassword = $password;

			if($this->strPassword == "")
			{
				$queryUpdate = "UPDATE persona SET nombres = ?, apellidos = ?, telefono = ? WHERE idPersona = $this->intIdUsuario";
				$arrData = array($this->strNombres,$this->strApellidos,$this->intTelefono);
			}else
			{
				$queryUpdate = "UPDATE persona SET nombres = ?, apellidos = ?, telefono = ?, password = ?  WHERE idPersona = $this->intIdUsuario";
				$arrData = array($this->strNombres,$this->strApellidos,$this->intTelefono,$this->strPassword);
			}
			$return = $this->Update($queryUpdate,$arrData);
			return $return;
		}

		public function UpdateDataFiscal(int $idUsuario, string $nit, string $nombreFiscal, string $direccionFiscal)
		{
			$this->intIdUsuario = $idUsuario;
			$this->strNit = $nit;
			$this->strNombreFiscal = $nombreFiscal;
			$this->strDireccionFiscal = $direccionFiscal;
			$sql = "UPDATE persona SET nit = ?, nombrefiscal = ?, direccionfiscal = ?  WHERE idpersona = $this->intIdUsuario";
			$arrData = array($this->strNit,$this->strNombreFiscal,$this->strDireccionFiscal);
			$request = $this->Update($sql,$arrData);
			return $request;
		}

	}

?>