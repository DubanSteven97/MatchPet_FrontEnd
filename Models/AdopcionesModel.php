<?php
	class AdopcionesModel extends SqlServer
	{
		private $intIdProcesoAdopcion;
		private $intIdPersona;
		private $intIdAnimal;
		private $intIdOrganizacion;
		private $strFechaCreacion;
		private $strDescripcion;
		private $intStatus;


		public function __construct()
		{
			parent::__construct();
		}



		public function SelectProcesos(int $idOrganizacion, int $intIdPersona, string $nombreRol)
		{	
			$this->intIdOrganizacion = $idOrganizacion;
			$this->intIdPersona = $intIdPersona;

			
			$whereOrganizacion = "";
			if($this->intIdOrganizacion != 0)
			{
				$whereOrganizacion = "  AND p.idOrganizacion = $this->intIdOrganizacion ";
			}
			$persona = "";
			if($nombreRol == "Amigo"){
				$persona = "  AND p.idPersona = $this->intIdPersona";
			}
		
			$sql = "SELECT p.idProcesoAdopcion, c.nombres as Amigo, a.nombre as Animal, o.nombre as Organizacion, p.fecha_solicitud, p.requisitos, p.estado FROM ProcesoAdopcion P INNER JOIN Animal a ON p.idAnimal = a.idAnimal INNER JOIN Persona c ON p.idPersona =c.idPersona INNER JOIN  Organizacion O ON p.idOrganizacion = o.idOrganizacion WHERE p.estado != 0".$whereOrganizacion.$persona;
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