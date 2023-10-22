<?php
require_once("Libraries/Core/Mysql.php");
	trait TProducto
	{
		private $con;
		private $strCategoria;
		private $strProducto;
		private $intIdCategoria;
		private $intIdProducto;
		private $cant;
		private $option;
		private $strRuta;

		public function GetProductosT()
		{
			$this->con = new Mysql();
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.status = 1";
			$request = $this->con->SelectAll($sql);
			if(count($request)>0)
			{
				for ($p=0; $p < count($request); $p++) 
				{
					$intIdProducto = $request[$p]['idproducto']; 
					$sqlImg = "SELECT 	productoid, 
									img
							FROM 		imagen 
							WHERE 	productoid = $intIdProducto";
					$requestImg = $this->con->SelectAll($sqlImg);
					if(count($requestImg)>0)
					{
						for ($i=0; $i < count($requestImg); $i++) { 
							$requestImg[$i]['url_image'] = media().'/images/uploads/'.$requestImg[$i]['img'];
						}
					}
					$request[$p]['images'] = $requestImg;
				}
			}
			return $request;
		}

		public function GetProductosCategoriaT(int $idCategoria,string $ruta)
		{
			$this->con = new Mysql();
			$this->intIdCategoria = $idCategoria;
			$this->strRuta = $ruta;
			$sqlCat = "SELECT 	idcategoria, 
								nombre 
						FROM 	categoria 
						WHERE 	idcategoria = {$this->intIdCategoria}";
			$request = $this->con->Select($sqlCat);
			if(!empty($request))
			{
				$this->strCategoria = $request['nombre'];
				
				$sql = "SELECT 	p.idproducto, 
								p.codigo, 
								p.nombre, 
								p.descripcion, 
								p.categoriaid, 
								c.nombre as categoria,
								p.precio,
								p.ruta,
								p.stock
						FROM 		producto p
						INNER JOIN	categoria c 
						ON 		p.categoriaid = c.idcategoria
						WHERE 	p.status = 1
						AND		p.categoriaid = {$this->intIdCategoria} 
						AND		c.ruta = '{$this->strRuta}'";
				$request = $this->con->SelectAll($sql);
				if(count($request)>0)
				{
					for ($p=0; $p < count($request); $p++) 
					{
						$intIdProducto = $request[$p]['idproducto']; 
						$sqlImg = "SELECT 	productoid, 
											img
									FROM 		imagen 
									WHERE 	productoid = $intIdProducto";
						$requestImg = $this->con->SelectAll($sqlImg);
						if(count($requestImg)>0)
						{
							for ($i=0; $i < count($requestImg); $i++) { 
								$requestImg[$i]['url_image'] = media().'/images/uploads/'.$requestImg[$i]['img'];
							}
						}
						$request[$p]['images'] = $requestImg;
					}
				}
				$request = array('idcategoria' => $this->intIdCategoria,
									'categoria' => $this->strCategoria,
									'productos' => $request
								);
			}
			return $request;
		}

		public function GetProductoT(int $idProducto,string $ruta)
		{
			$this->intIdProducto = $idProducto;
			$this->strRuta = $ruta;
			$this->con = new Mysql();
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							c.ruta as ruta_categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.status = 1
					AND		p.idproducto = {$this->intIdProducto}
					AND		p.ruta = '{$this->strRuta}'";
			$request = $this->con->Select($sql);
			if(!empty($request))
			{
				$intIdProducto = $request['idproducto']; 
				$sqlImg = "SELECT 	productoid, 
									img
							FROM 		imagen 
							WHERE 	productoid = $intIdProducto";
				$requestImg = $this->con->SelectAll($sqlImg);
				if(count($requestImg)>0)
				{
					for ($i=0; $i < count($requestImg); $i++) { 
						$requestImg[$i]['url_image'] = media().'/images/uploads/'.$requestImg[$i]['img'];
					}
				}else
				{
					$requestImg[0]['url_image'] = media().'/images/uploads/product.jpg';
				}
				$request['images'] = $requestImg;
			}
			return $request;
		}

		public function GetProductosRandomT(int $idcategoria, int $cant, string $option)
		{
			$this->intIdCategoria = $idcategoria;
			$this->cant = $cant;

			if($option == "r")
			{
				$this->option = " RAND() ";
			}else if($option == "a")
			{
				$this->option = " p.nombre ASC ";
			}else{
				$this->option = " p.nombre DESC ";
			}

			$this->con = new Mysql();
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.status = 1
					AND		c.idcategoria = {$this->intIdCategoria} 
					ORDER BY $this->option LIMIT $this->cant";
			$request = $this->con->SelectAll($sql);
			if(count($request)>0)
			{
				for ($p=0; $p < count($request); $p++) 
				{
					$intIdProducto = $request[$p]['idproducto']; 
					$sqlImg = "SELECT 	productoid, 
									img
							FROM 		imagen 
							WHERE 	productoid = $intIdProducto";
					$requestImg = $this->con->SelectAll($sqlImg);
					if(count($requestImg)>0)
					{
						for ($i=0; $i < count($requestImg); $i++) { 
							$requestImg[$i]['url_image'] = media().'/images/uploads/'.$requestImg[$i]['img'];
						}
					}
					$request[$p]['images'] = $requestImg;
				}
			}
			return $request;
		}

		public function GetProductoIdT(int $idProducto)
		{
			$this->intIdProducto = $idProducto;
			$this->con = new Mysql();
			$sql = "SELECT 	p.idproducto, 
							p.codigo, 
							p.nombre, 
							p.descripcion, 
							p.categoriaid, 
							c.nombre as categoria,
							p.precio,
							p.ruta,
							p.stock
					FROM 		producto p
					INNER JOIN	categoria c 
					ON 		p.categoriaid = c.idcategoria
					WHERE 	p.status = 1
					AND		p.idproducto = {$this->intIdProducto}";
			$request = $this->con->Select($sql);
			if(!empty($request))
			{
				$intIdProducto = $request['idproducto']; 
				$sqlImg = "SELECT 	productoid, 
									img
							FROM 		imagen 
							WHERE 	productoid = $intIdProducto";
				$requestImg = $this->con->SelectAll($sqlImg);
				if(count($requestImg)>0)
				{
					for ($i=0; $i < count($requestImg); $i++) { 
						$requestImg[$i]['url_image'] = media().'/images/uploads/'.$requestImg[$i]['img'];
					}
				}else
				{
					$requestImg[0]['url_image'] = media().'/images/uploads/product.jpg';
				}
				$request['images'] = $requestImg;
			}
			return $request;
		}
	}
?>