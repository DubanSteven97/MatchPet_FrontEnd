<?php
	class UsuariosModel extends SqlServer
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
		private $intIdOrganizacion;

		public function __construct()
		{
			parent::__construct();
		}

		public function InsertUsuario(int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status, int $idOrganizacion)
		{
			$this->strIdentificacion = $identificacion;
			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $rolId;
			$this->intStatus = $status;
			if($idOrganizacion == 0){
				$this-> intIdOrganizacion =Null;
			}else{
				$this-> intIdOrganizacion =$idOrganizacion;
			}
			$fechaCreacion= date('Y-m-d');
			$return = 0;
			$sql = "SELECT * FROM Persona WHERE
					email = '{$this->strEmail}' or numero_identificacion = '{$this->strIdentificacion}'";

		
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO Persona (numero_identificacion, nombres, apellidos, telefono, email, password, idRol, estado, idOrganizacion,fecha_creacion) VALUES (?,?,?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombres,
								$this->strApellidos,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intRolId,
								$this->intStatus,
								$this-> intIdOrganizacion,
								$fechaCreacion
							);

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
				$whereAdmin = "  AND p.idPersona != 1  AND o.idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			$sql = "SELECT p.idPersona, p.numero_identificacion, p.nombres, p.apellidos, p.telefono, p.email, p.estado, r.idRol, r.nombreRol, o.idOrganizacion, o.nombre  FROM Persona p INNER JOIN Rol r ON p.idRol = r.idRol FULL OUTER JOIN  Organizacion o ON P.idOrganizacion = o.idOrganizacion WHERE p.estado != 0".$whereAdmin;
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectUsuario(int $idPersona)
		{
			$this->intIdUsuario = $idPersona;
			$sql = "SELECT p.idpersona, p.numero_identificacion, p.nombres, p.apellidos, p.telefono, p.email, p.nit, p.nombrefiscal, p.direccionfiscal, r.idrol, r.nombrerol, p.estado, FORMAT(p.fecha_creacion,'dd-MM-yyyy') as fechaRegistro,o.idOrganizacion, o.nombre FROM Persona p INNER JOIN Rol r ON p.idRol = r.idRol FULL OUTER JOIN  Organizacion o ON P.idOrganizacion = o.idOrganizacion WHERE p.idPersona = $this->intIdUsuario";
			$request = $this->Select($sql);
			return $request;
		}

		public function UpdateUsuario(int $idUsuario, int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status, int $organizacionId)
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
			$this->intIdOrganizacion = $organizacionId;

			$sql = "SELECT * FROM Persona WHERE (email = '{$this->strEmail}' AND idPersona != $this->intIdUsuario) OR (numero_identificacion = '{$this->strIdentificacion}' AND idPersona != $this->intIdUsuario)";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				if($this->strPassword == "")
				{
					$queryUpdate = "UPDATE persona SET numero_identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, idRol = ?, estado = ?, idOrganizacion = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->intRolId,$this->intStatus,$this->intIdOrganizacion);
				}else
				{
					$queryUpdate = "UPDATE persona SET numero_identificacion = ?, nombres = ?, apellidos = ?, telefono = ?, email = ?, password = ?, idRol = ?, estado = ?, idOrganizacion = ?  WHERE idPersona = $this->intIdUsuario";
					$arrData = array($this->strIdentificacion,$this->strNombres,$this->strApellidos,$this->intTelefono,$this->strEmail,$this->strPassword,$this->intRolId,$this->intStatus,$this->intIdOrganizacion);
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
			$sql = "UPDATE persona SET estado = ? WHERE idPersona = $this->intIdUsuario";
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