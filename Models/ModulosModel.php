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