<?php
	class CategoriasModel extends Mysql
	{
		private $intIdCategoria;
		private $strCategoria;
		private $strDescripcion;
		private $strPortada;
		private $strRuta;
		private $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function SelectCategorias()
		{
			$sql = "SELECT * FROM categoria WHERE status != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectCategoria(int $idCategoria)
		{
			$this->intIdCategoria = $idCategoria;
			$sql = "SELECT * FROM categoria WHERE idcategoria = $this->intIdCategoria";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertCategoria(string $categoria, string $descripcion, string $portada, string $ruta,  int $status)
		{
			$return = "";
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$this->strRuta = $ruta;
			$this->strPortada = $portada;

			$sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$queryInsert = "INSERT INTO categoria(nombre,descripcion, portada, ruta, status) VALUES (?,?,?,?,?)";

				$arrData = array($this->strCategoria, $this->strDescripcion, $this->strPortada, $this->strRuta, $this->intStatus);
				$return = $this->Insert($queryInsert,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function UpdateCategoria(int $idCategoria, string $categoria, string $descripcion, string $portada, string $ruta,  int $status)
		{
			$return = "";
			$this->intIdCategoria = $idCategoria;
			$this->strCategoria = $categoria;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;
			$this->strRuta = $ruta;
			$this->strPortada = $portada;

			$sql = "SELECT * FROM categoria WHERE nombre = '{$this->strCategoria}' AND idcategoria != {$this->intIdCategoria}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE categoria SET nombre = ?, descripcion = ?, portada = ?, ruta = ?, status = ? WHERE idcategoria = $this->intIdCategoria";
				$arrData = array($this->strCategoria, $this->strDescripcion, $this->strPortada, $this->strRuta, $this->intStatus);
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteCategoria(int $idCategoria)
		{
			$this->intIdCategoria = $idCategoria;
			$sql = "SELECT * FROM producto WHERE categoriaid != {$this->intIdCategoria}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE categoria SET status = ? WHERE idcategoria = $this->intIdCategoria";
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