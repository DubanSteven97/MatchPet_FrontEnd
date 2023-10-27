<?php
	class PermisosModel extends SqlServer
	{
		public $intIdPermiso;
		public $intRolId;
		public $intModuloId;
		public $r;
		public $w;
		public $u;
		public $d;

		public function __construct()
		{
			parent::__construct();
		}

		public function SelectModulos()
		{
			$sql = "SELECT * FROM Modulo WHERE estado != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectPermisosRol(int $idRol)
		{
			$this->intRolId = $idRol;
			$sql = "SELECT * FROM Permiso WHERE idRol = $this->intRolId";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function DeletePermisos(int $idRol)
		{
			$this->intRolId = $idRol;
			$sql = "DELETE FROM Permiso WHERE idRol = $this->intRolId";
			$request = $this->Delete($sql);
			return $request;	
		}

		public function InsertPermisos(int $idRol, int $idModulo, int $r, int $w, int $u, int $d)
		{
			$return = "";
			$this->intRolId=$idRol;
			$this->intModuloId=$idModulo;
			$this->r=$r;
			$this->w=$w;
			$this->u=$u;
			$this->d=$d;

			$queryInsert = "INSERT INTO permiso(idRol,idModulo,r,w,u,d) VALUES (?,?,?,?,?,?)";
			$arrData = array($this->intRolId, $this->intModuloId, $this->r, $this->w, $this->u, $this->d);
			$return = $this->Insert($queryInsert,$arrData);
			return $return;
		}

		public function PermisosModulo(int $idRol)
		{
			$this->intRolId=$idRol;
			$sql = "SELECT p.idRol, p.idModulo, m.titulo as modulo, m.descripcion, m.icono, m.ruta, p.r, p.w, p.u, p.d FROM permiso p INNER JOIN modulo m ON p.idModulo = m.idModulo WHERE p.idRol = $this->intRolId ORDER BY m.idModulo ASC";
			$request = $this->SelectAll($sql);
			$arrPermisos = array();
			for ($i=0; $i < count($request); $i++) { 
				$arrPermisos[$request[$i]['modulo']] = $request[$i];
			}
			return $arrPermisos;
		}
	}

?>