<?php
	class DonacionesModel extends SqlServer
	{
		private $intIdDonacion;
		private $intIdPersona;
		private $intIdTipoPago;
		private $intIdOrganizacion;
		private $strFecha;
		private $idTransaccion;
		private $strDatosTransaccion;
		private $strMonto;
		private $strStatus;


		public function __construct()
		{
			parent::__construct();
		}



		public function SelectDonaciones(int $idOrganizacion, int $intIdPersona, string $nombreRol)
		{	
			$this->intIdOrganizacion = $idOrganizacion;
			$this->intIdPersona = $intIdPersona;

			
			$whereOrganizacion = "";
			if($this->intIdOrganizacion != 0)
			{
				$whereOrganizacion = "  AND d.idOrganizacion = $this->intIdOrganizacion ";
			}
			$persona = "";
			if($nombreRol == "Amigo"){
				$persona = "  AND d.idPersona = $this->intIdPersona";
			}
		
			$sql = "SELECT d.idDonacion, d.idtransaccion, c.nombres as Amigo, o.nombre as Organizacion, d.fecha, d.monto, d.estado FROM Donacion D INNER JOIN TipoPago t ON d.idTipoPago= t.idTipoPago INNER JOIN Persona c ON d.idPersona =c.idPersona INNER JOIN  Organizacion O ON d.idOrganizacion = o.idOrganizacion WHERE 1 = 1".$whereOrganizacion.$persona;
			$request = $this->SelectAll($sql);
			return $request;
		}


		public function SelectAdopcion(int $IdProcesoAdopcion)
		{
			$this->intIdProcesoAdopcion = $IdProcesoAdopcion;
			$sql = "SELECT idProcesoAdopcion, idAnimal, requisitos FROM ProcesoAdopcion WHERE idProcesoAdopcion = $this->intIdProcesoAdopcion";
			$request = $this->Select($sql);
			return $request;
		}


		public function AprobarProceso(int $idProcesoAdopcion, int $idAnimalProceso, string $descripcion)
		{	
			$this->intIdProcesoAdopcion = $idProcesoAdopcion;
			$this->intIdAnimal = $idAnimalProceso;
			$this->strFechaCreacion = date("Y-m-d");
			$this->strDescripcion = $descripcion;
			$this->intStatus = 3;


			$queryUpdateProceso = "UPDATE ProcesoAdopcion SET requisitos = ?, fecha_solicitud = ? , estado = ? WHERE idProcesoAdopcion = $this->intIdProcesoAdopcion";
			$arrDataUpdateProceso = array($this->strDescripcion,$this->strFechaCreacion,$this->intStatus);
			$returnUpdateProceso = $this->Update($queryUpdateProceso,$arrDataUpdateProceso);

			$queryUpdateAnimal = "UPDATE Animal SET estado = ? WHERE idAnimal = $this->intIdAnimal";
			$arrDataUpdateAnimal = array(4);
			$returnUpdateAnimal = $this->Update($queryUpdateAnimal,$arrDataUpdateAnimal);

	
			if($returnUpdateProceso != null & $returnUpdateAnimal != null){
				return $return="Exito";
			}

			return $return="Error";
		}
		public function RechazarProceso(int $idProcesoAdopcion, int $idAnimalProceso, string $descripcion)
		{	
			$this->intIdProcesoAdopcion = $idProcesoAdopcion;
			$this->intIdAnimal = $idAnimalProceso;
			$this->strFechaCreacion = date("Y-m-d");
			$this->strDescripcion = $descripcion;
			$this->intStatus = 4;


			$queryUpdateProceso = "UPDATE ProcesoAdopcion SET requisitos = ?, fecha_solicitud = ? , estado = ? WHERE idProcesoAdopcion = $this->intIdProcesoAdopcion";
			$arrDataUpdateProceso = array($this->strDescripcion,$this->strFechaCreacion,$this->intStatus);
			$returnUpdateProceso = $this->Update($queryUpdateProceso,$arrDataUpdateProceso);

			$queryUpdateAnimal = "UPDATE Animal SET estado = ? WHERE idAnimal = $this->intIdAnimal";
			$arrDataUpdateAnimal = array(1);
			$returnUpdateAnimal = $this->Update($queryUpdateAnimal,$arrDataUpdateAnimal);

	
			if($returnUpdateProceso != null & $returnUpdateAnimal != null){
				return $return="Exito";
			}

			return $return="Error";
		}		

		public function DeleteCliente(int $idUsuario)
		{
			$this->intIdUsuario = intval($idUsuario);
			$sql = "UPDATE persona SET status = ? WHERE idpersona = $this->intIdUsuario";
			$arrData = array(0);
			$request = $this->Update($sql,$arrData);
			return $request;
		}

	}

?>