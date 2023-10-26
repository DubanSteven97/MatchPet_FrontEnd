<?php
	class AplicacionModel extends SqlServer
	{
		private $idAplicacion;
		private $nombre;
        private $descripcion;
        private $usuario;
        private $clave;
        private $estado;
        private $token;
        private $creacion_token;
        private $expires_token;

		public function __construct()
		{
			parent::__construct();
		}


		public function SelectAplicacion(string $app)
		{
			$this->nombre = $app;
			$sql = "SELECT * FROM Aplicacion WHERE nombre = '{$this->nombre}'";
			$request = $this->Select($sql);
			return $request;
		}

	}

?>