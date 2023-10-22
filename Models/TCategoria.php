<?php
require_once("Libraries/Core/Mysql.php");
	trait TCategoria
	{
		private $con;

		public function GetCategoriasT(string $categorias)
		{
			$this->con = new Mysql();
			$sql = "SELECT idcategoria, nombre, descripcion, portada, ruta FROM categoria WHERE status != 0 AND idcategoria IN ($categorias)";
			$request = $this->con->SelectAll($sql);
			if(count($request)>0)
			{
				for($c=0; $c < count($request); $c++)
				{
					$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];
				}
			}
			return $request;
		}
	}
?>