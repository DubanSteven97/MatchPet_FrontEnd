<?php
	class RolesModel extends Mysql
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
				$whereAdmin = "  AND nombrerol != 'Administrador' ";
			}
			$sql = "SELECT * FROM rol WHERE status != 0".$whereAdmin;
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectRol(int $rolId)
		{
			$this->intIdRol = $rolId;
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdRol";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertRol(string $rol, string $descripcion, int $status)
		{
			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$queryInsert = "INSERT INTO rol(nombrerol,descripcion,status) VALUES (?,?,?)";
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

			$sql = "SELECT * FROM rol WHERE nombrerol = '{$this->strRol}' AND idrol != {$this->intIdRol}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE rol SET nombrerol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdRol";
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
			$sql = "SELECT * FROM persona WHERE rolid = {$this->intIdRol}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE rol SET status = ? WHERE idrol = $this->intIdRol";
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