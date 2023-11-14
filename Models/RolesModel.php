<?php
	class RolesModel extends SqlServer
	{
		public $intIdRol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
		public function __construct()
		{
			parent::__construct();
		}

		public function SelectRoles()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1)
			{
				$whereAdmin = "  AND nombreRol != 'Administrador' ";
			}
			$sql = "SELECT * FROM Rol WHERE estado != 0".$whereAdmin;
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectRol(int $rolId)
		{
			$this->intIdRol = $rolId;
			$sql = "SELECT * FROM Rol WHERE idRol = $this->intIdRol";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertRol(string $rol, string $descripcion, int $status)
		{
			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombreRol = '{$this->strRol}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$queryInsert = "INSERT INTO rol(nombreRol,descripcion,estado) VALUES (?,?,?)";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$return = $this->Insert($queryInsert,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function UpdateRol(int $idRol, string $rol, string $descripcion, int $status)
		{
			$return = "";
			$this->intIdRol = $idRol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM Rol WHERE nombreRol = '{$this->strRol}' AND idRol != {$this->intIdRol}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE Rol SET nombreRol = ?, descripcion = ?, estado = ? WHERE idRol = $this->intIdRol";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteRol(int $idRol)
		{
			$this->intIdRol = $idRol;
			$sql = "SELECT * FROM persona WHERE idRol = {$this->intIdRol}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE rol SET estado = ? WHERE idrol = $this->intIdRol";
				$arrData = array(0);
				$request = $this->Update($queryUpdate,$arrData);
				if($request)
				{
					$return = 'ok';
				}else
				{
					$return = 'error';
				}
			}else
			{
				$return = 'exist';
			}
			return $return;
		}
	}

?>