<?php
	class PaginasModel extends SqlServer
	{

		private $intidPagina;
		private $strTitulo;
		private $strContenido;
		private $strPortada;
		private $strRuta;
		private $intEstado;


		public function SelectPaginas()
		{	
			$sql = "SELECT idPagina, titulo, CONVERT(varchar, datecreated, 103)as fecha, ruta, estado
					FROM pagina WHERE estado != 0 ORDER BY idPagina DESC";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectPagina(int $idPagina)
		{	
			$sql = "SELECT idPagina, titulo, CONVERT(varchar, datecreated, 103)as fecha, estado
					FROM pagina WHERE id = {$idPagina}";
			$request = $this->Select($sql);
			return $request;
		}

		public function InsertPagina(string $titulo, string $contenido, string $portada, string $ruta,  int $estado)
		{
			$return = "";
			$this->strTitulo = $titulo;
			$this->strContenido = $contenido;
			$this->intEstado = $estado;
			$this->strRuta = $ruta;
			$this->strPortada = $portada;

			$sql = "SELECT * FROM pagina WHERE ruta = '{$this->strRuta}'";
			$request = $this->SelectAll($sql);

			if(empty($request))
			{
				$queryInsert = "INSERT INTO pagina(titulo,contenido, portada, ruta, estado) VALUES (?,?,?,?,?)";
				$arrData = array($this->strTitulo, $this->strContenido, $this->strPortada, $this->strRuta, $this->intEstado);
				$return = $this->Insert($queryInsert,$arrData);
			}else
			{
				$return = 0;
			}
			return $return;
		}

		public function UpdatePagina(int $idPagina, string $titulo, string $contenido, string $portada,  int $estado)
		{
			$return = "";
			$this->intidPagina = $idPagina;
			$this->strTitulo = $titulo;
			$this->strContenido = $contenido;
			$this->intEstado = $estado;
			$this->strPortada = $portada;

			$queryUpdate = "UPDATE pagina SET titulo = ?, contenido = ?, portada = ?, estado = ? WHERE idPagina = $this->intidPagina";
			$arrData = array($this->strTitulo, $this->strContenido, $this->strPortada, $this->intEstado);
			$return = $this->Update($queryUpdate,$arrData);
			return $return;
		}

		public function DeletePagina(int $idPagina)
		{
			$this->intidPagina = $idPagina;
			$queryUpdate = "UPDATE pagina SET estado = ? WHERE idPagina = $this->intidPagina";
			$arrData = array(0);
			$request = $this->Update($queryUpdate,$arrData);
			return $request;
		}
	}
?>