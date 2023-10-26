<?php
	class ConfiguracionesModel extends SqlServer
	{
		private $idEmpresa;
		private $direccion;
		private $telefono;
        private $correoPedidos;
        private $correoEmrpesa;
        private $nombreRemitente;
        private $correoRemitente;
        private $nombreEmpresa;
        private $nombeAplicacion;
        private $sitioWeb;
        private $SimboloMoneda;
        private $Moneda;
        private $Divisa;
        private $SeparfadorDecimal;
        private $SeparadorMilesMillones;

		public function __construct()
		{
			parent::__construct();
		}


		public function SelectEmpresa(int $compañia)
		{
			$this->idEmpresa = $compañia;
			$sql = "SELECT * FROM Aplication WHERE idAplicacion = $this->idEmpresa";
			$request = $this->Select($sql);
			return $request;
		}

        public function DatosCorreo(int $compañia)
		{
			$this->idEmpresa = $compañia;
			$sql = "SELECT nombre_remitente, correo_remitente, nombre_aplicacion,nombre_empresa,sitio_web FROM Aplication WHERE idAplicacion = $this->idEmpresa";
			$request = $this->Select($sql);
			return $request;
		}

        public function DatosEmpresa(int $compañia)
		{
			$this->idEmpresa = $compañia;
			$sql = "SELECT direccion, telefono, correo_pedidos,correo_empresa FROM Aplication WHERE idAplicacion = $this->idEmpresa";
			$request = $this->Select($sql);
			return $request;
		}
        public function DatosMoneda(int $compañia)
		{
			$this->idEmpresa = $compañia;
			$sql = "SELECT separador_decimales, separador_miles_millones, simbolo_moneda,divisa, moneda FROM Aplication WHERE idAplicacion = $this->idEmpresa";
			$request = $this->Select($sql);
			return $request;
		}
		public function UpdateEmpresa(string $direccion, int $telefono, string $correoPedidos,string $correoEmrpesa,string $nombreRemitente, string $correoRemitente, string $nombreEmpresa, string $nombeAplicacion, string $sitioWeb,  string $SimboloMoneda,  string $Moneda,  string $Divisa,  string $SeparfadorDecimal,  string $SeparadorMilesMillones )
		{
			$this->idEmpresa = 1;
            $this->direccion = $direccion;
			$this->telefono = $telefono;
            $this->correoPedidos = $correoPedidos;
            $this->correoEmrpesa = $correoEmrpesa;
            $this->nombreRemitente = $nombreRemitente;
            $this->correoRemitente = $correoRemitente;
            $this->nombreEmpresa = $nombreEmpresa;
            $this->nombeAplicacion = $nombeAplicacion;
            $this->sitioWeb = $sitioWeb;
            $this->SimboloMoneda = $SimboloMoneda;
            $this->Moneda = $Moneda;
            $this->Divisa = $Divisa;
            $this->SeparfadorDecimal = $SeparfadorDecimal;
            $this->SeparadorMilesMillones = $SeparadorMilesMillones;
	
            $queryUpdate = "UPDATE Aplication SET direccion = ?, telefono = ?,correo_empresa = ? , correo_pedidos = ?, nombre_remitente = ?, correo_remitente = ?, nombre_empresa = ? , nombre_aplicacion = ?, sitio_web = ?, simbolo_moneda = ?, moneda = ?, divisa = ?, separador_decimales = ?, separador_miles_millones = ?  WHERE idAplicacion = $this->idEmpresa";
            $arrData = array($this->direccion,$this->telefono,$this->correoEmrpesa,$this->correoPedidos, $this->nombreRemitente,$this->correoRemitente, $this->nombreEmpresa, $this->nombeAplicacion,$this->sitioWeb,$this->SimboloMoneda,$this->Moneda,$this->Divisa,$this->SeparfadorDecimal,$this->SeparadorMilesMillones );

            $return = $this->Update($queryUpdate,$arrData);

			return $return;
		}



	}

?>