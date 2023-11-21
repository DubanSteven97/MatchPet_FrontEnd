<?php
	class DonarModel extends SqlServer
	{
		


		public function __construct()
		{
			parent::__construct();
		}

		public function InsertDonacion(string $idtransaccion,string $datostransaccion, int $personaid,float $monto,int $tipopagoid,int $idOrganizacion,string $status)
		{
			$query_insert = "INSERT INTO donacion (idtransaccion, datostransaccion, idpersona, monto, idtipopago, idorganizacion, estado) VALUES (?,?,?,?,?,?,?)";
			$arrData = array($idtransaccion, $datostransaccion, $personaid, $monto, $tipopagoid, $idOrganizacion, $status);
			$request_insert = $this->Insert($query_insert,$arrData);
			return $request_insert;
		}

	}

?>