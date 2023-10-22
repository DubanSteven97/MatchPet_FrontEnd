<?php
	class ProductosModel extends Mysql
	{
		private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $strPrecio;
		private $intStock;
		private $strImagen;
		private $strRuta;
		private $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function SelectProductos()
		{
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							p.precio,
							p.stock,
							p.status
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.status != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectProducto(int $idProducto)
		{
			$this->intIdProducto = $idProducto;
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							p.precio,
							p.stock,
							p.status
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.idproducto = $this->intIdProducto";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertProducto(string $nombre, string $descripcion, int $codigo, int $categoriaId, string $precio, int $stock, string $ruta, int $status)
		{
			$return = "";
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaId;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM producto WHERE codigo = {$this->intCodigo}";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$queryInsert = "INSERT INTO producto(nombre, descripcion, codigo, categoriaid, precio, stock, ruta, status) 
									VALUES (?,?,?,?,?,?,?,?)";
				$arrData = array($this->strNombre, $this->strDescripcion, $this->intCodigo, $this->intCategoriaId, $this->strPrecio, $this->intStock, $this->strRuta, $this->intStatus);
				$return = $this->Insert($queryInsert,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function UpdateProducto(int $idProducto, string $nombre, string $descripcion, int $codigo, int $categoriaId, string $precio, int $stock, string $ruta, int $status)
		{
			$return = "";
			$this->intIdProducto = $idProducto;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intCodigo = $codigo;
			$this->intCategoriaId = $categoriaId;
			$this->strPrecio = $precio;
			$this->intStock = $stock;
			$this->strRuta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' AND idproducto != {$this->intIdProducto}";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$queryUpdate = "UPDATE producto SET nombre = ?, descripcion = ?, codigo = ?, categoriaid = ?, precio = ?, stock = ?, ruta = ?, status = ? WHERE idproducto = $this->intIdProducto";
				$arrData = array($this->strNombre, $this->strDescripcion, $this->intCodigo, $this->intCategoriaId, $this->strPrecio, $this->intStock, $this->strRuta, $this->intStatus);
				$return = $this->Update($queryUpdate,$arrData);
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function DeleteProducto(int $idProducto)
		{
			$this->intIdProducto = $idProducto;
			$queryUpdate = "UPDATE producto SET status = ? WHERE idproducto = $this->intIdProducto";
			$arrData = array(0);
			$request = $this->Update($queryUpdate,$arrData);
			return $request;
		}

		public function InsertImage(int $idProducto, string $imagen)
		{
			$this->intIdProducto = $idProducto;
			$this->strImagen = $imagen;
			$queryInsert = "INSERT INTO imagen(productoid,img) VALUES (?,?)";
			$arrData = array($this->intIdProducto,$this->strImagen);
			$return = $this->Insert($queryInsert,$arrData);
			return $return;
		}

		public function SelectImages(int $idProducto)
		{
			$this->intIdProducto = $idProducto;
			$sql = "SELECT 	productoid, 
							img
					FROM 		imagen 
					WHERE 	productoid = $this->intIdProducto";
			$request = $this->SelectAll($sql);
			return $request;
		}
		
		public function DeleteImage(int $idProducto, string $imagen)
		{
			$this->intIdProducto = $idProducto;
			$this->strImagen = $imagen;
			$query = "DELETE FROM imagen WHERE productoid = $this->intIdProducto AND img = '{$this->strImagen}'";
			$return = $this->Delete($query);
			return $return;
		}
	}

?>