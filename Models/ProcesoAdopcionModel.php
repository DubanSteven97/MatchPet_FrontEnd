<?php
	class ProcesoAdopcionModel extends SqlServer
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



		public function CrearProceso(int $idPersona, int $idAnimal, int $idOrganizacionAnimal)
		{	
			$return = "";
			$this->intIdAnimal = $idAnimal;
			$this->intIdPersona = $idPersona;
			$this->intIdOrganizacion = $idOrganizacionAnimal;
			$this->strFechaCreacion = date("Y-m-d");
			$this->strDescripcion = "Proceso iniciado - un miembro de la organización se pondrá en contacto contigo";
			$this->intStatus = 1;

			
			$queryInsert = "INSERT INTO ProcesoAdopcion(idPersona,idAnimal,idOrganizacion,fecha_solicitud,requisitos,estado) VALUES (?,?,?,?,?,?)";
			$arrData = array($this->intIdPersona,$this->intIdAnimal, $this->intIdOrganizacion, $this->strFechaCreacion, $this->strDescripcion, $this->intStatus);
			$returnInsert = $this->Insert($queryInsert,$arrData);

	
			if($returnInsert != null){
				return $return="Exito";
			}

			return $return="Error";
		}

	}

?>