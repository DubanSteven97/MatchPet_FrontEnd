<?php
require_once("Libraries/Core/Mysql.php");
	trait TTipoPago
	{
		private $con;

		public function getTiposPagosT()
		{
			$this->con = new Mysql();
			$sql = "SELECT * FROM tipopago WHERE status != 0";
			$request = $this->con->SelectAll($sql);
			return $request;
		}
	}
?>