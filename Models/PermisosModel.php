<?php
	class PermisosModel extends Mysql
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
			$sql = "SELECT * FROM modulo WHERE status != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectPermisosRol(int $idRol)
		{
			$this->intRolId = $idRol;
			$sql = "SELECT * FROM permisos WHERE rolid = $this->intRolId";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function DeletePermisos(int $idRol)
		{
			$this->intRolId = $idRol;
			$sql = "DELETE FROM permisos WHERE rolid = $this->intRolId";
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

			$queryInsert = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES (?,?,?,?,?,?)";
			$arrData = array($this->intRolId, $this->intModuloId, $this->r, $this->w, $this->u, $this->d);
			$return = $this->Insert($queryInsert,$arrData);
			return $return;
		}

		public function PermisosModulo(int $idRol)
		{
			$this->intRolId=$idRol;
			$sql = "SELECT p.rolid, p.moduloid, m.titulo as modulo, p.r, p.w, p.u, p.d FROM permisos p INNER JOIN modulo m ON p.moduloid = m.idmodulo WHERE p.rolid = $this->intRolId";
			$request = $this->SelectAll($sql);

			$arrPermisos = array();
			for ($i=0; $i < count($request); $i++) { 
				$arrPermisos[$request[$i]['modulo']] = $request[$i];
			}
			return $arrPermisos;
		}
	}

?>