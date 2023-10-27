<?php
	class ModulosModel extends Mysql
	{
		private $intIdModulo;
		private $strTitulo;
		private $strDescripcion;
		private $strIcono;
		private $intStatus;
		private $strRuta;

		public function __construct()
		{
			parent::__construct();
		}

		public function InsertModulo(string $titulo, string $descripcion, string $icono, int $status, string $ruta)
		{
			$this->strTitulo = $titulo;
			$this->strDescripcion = $descripcion;
			$this->strIcono = $icono;
			$this->intStatus = $status;
			$this->strRuta = $ruta;
			$return = 0;
			$sql = "SELECT * FROM modulo WHERE
					titulo = '{$this->strTitulo}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO modulo (titulo, descripcion, icono, status, ruta) VALUES (?,?,?,?,?)";
				$arrData = array($this->strTitulo,
								$this->strDescripcion,
								$this->strIcono,
								$this->intStatus,
								$this->strRuta
							);
				$request_insert = $this->Insert($query_insert, $arrData);
				$return = $request_insert;
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function SelectModulos()
		{	
			$sql = "SELECT m.idmodulo, m.titulo, m.descripcion, m.icono, m.ruta, m.estado FROM modulo m WHERE m.estado != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectModulo(int $idModulo)
		{
			$this->intIdModulo = $idModulo;
			$sql = "SELECT m.idmodulo, m.titulo, m.descripcion, m.icono, m.ruta, m.estado FROM modulo m WHERE m.idmodulo = $this->intIdModulo";
			$request = $this->Select($sql);
			return $request;
		}

		public function UpdateModulo(int $idModulo, string $titulo, string $descripcion, string $icono, int $status, string $ruta)
		{
			$this->intIdModulo = $idModulo;
			$this->strTitulo = $titulo;
			$this->strDescripcion = $descripcion;
			$this->strIcono = $icono;
			$this->intStatus = $status;
			$this->strRuta = $ruta;

			$sql = "SELECT * FROM modulo WHERE titulo = '{$this->strTitulo}' AND idModulo != $this->intIdModulo";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE modulo SET titulo = ?, descripcion = ?, icono = ?, estado = ?, ruta = ? WHERE idModulo = $this->intIdModulo";
				$arrData = array($this->strTitulo,$this->strDescripcion,$this->strIcono,$this->intStatus,$this->strRuta);
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteModulo(int $idModulo)
		{
			$this->intIdModulo = intval($idModulo);
			$sql = "UPDATE modulo SET status = ? WHERE idmodulo = $this->intIdModulo";
			$arrData = array(0);
			$request = $this->Update($sql,$arrData);
			return $request;
		}
	}
?>