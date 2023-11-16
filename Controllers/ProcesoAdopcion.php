<?php
	class ProcesoAdopcion extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function ProcesoAdopcion()
		{
			$data['page_tag'] = NOMBRE_EMPRESA. ' - Adopción';
			$data['page_title'] = 'Proceso de Adopción';
			$data['page_name'] = "adopcion";
			$this->views->GetView($this,"ProcesoAdopcion",$data);
		}

		
		public function SolicitudAdopcion()
		{
			$idPersona = intval($_POST['idPersona']);
			$idAnimal = intval($_POST['idAnimal']);
			$idOrganizacionAnimal = intval($_POST['idOrganizacionAnimal']);


			$arrData = $this->model->CrearProceso($idPersona,$idAnimal,$idOrganizacionAnimal);
			if($arrData == "Exito")
			{
				$arrResponse = array(	'estado'=> true,
										'msg'	=> 'Proceso creado correctamente -  Un miembro de la organización se pondrá en contacto contigo.');
			}else
			{
				$arrResponse = array(	'estado'=> false,
										'msg'	=> '¡Error! Por favor inténtenlo más tarde.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		
		
			die();
		}
	}
?>