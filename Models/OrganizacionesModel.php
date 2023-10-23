<?php
	class OrganizacionesModel extends SqlServer
	{
		public $intIdOrganizacion;
		public $strNombre;
        public $strDescripcion;
		public $strTelefono;
        public $strDireccion;
        public $strEstado;
		public $intStatus;
		public function __construct()
		{
			parent::__construct();
		}

		public function SelectOrganizaciones()
		{
			$sql = "SELECT * FROM Organizacion WHERE estado != 0";
			$request = $this->SelectAll($sql);
			return $request;
		}

	}

?>