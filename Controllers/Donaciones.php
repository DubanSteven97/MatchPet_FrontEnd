<?php
	class Donaciones extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Donaciones');
		}
		public function Donaciones()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Donaciones";
			$data['page_name'] = "donaciones";
			$data['page_title'] = "Donaciones<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_donaciones.js";
			$this->views->GetView($this,"donaciones",$data);
		}
		
		public function GetDonaciones()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idOrganizacion = intval( $_SESSION['userData']['idOrganizacion']);
				$idPersona = intval( $_SESSION['userData']['idPersona']);
				$nombreRol = ucwords( $_SESSION['userData']['nombreRol']);

				$arrData = $this->model->SelectDonaciones($idOrganizacion,$idPersona,$nombreRol);
				for($i=0;$i<count($arrData);$i++){

					$btnGest = '';
					$arrData[$i]['monto'] = FormatMoney($arrData[$i]['monto']);
					
					if($_SESSION['permisosMod']['u'])
					{
						$btnGest = '<button class="btn btn-info btn-sm" onClick= "fntAprobarProceso('.$arrData[$i]['idDonacion'].')" title="Validar solicitud" disabled><i class="fa-solid fa-magnifying-glass"></i></button>';					
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnGest.' ';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function aprobarAdopcion()
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

		public function gestionProceso()
		{
			$idProcesoAdopcion = intval($_POST['idProcesoAdopcion']);
			$strDescripcion = StrClean($_POST['txtDescripcion']);
			$idAnimalProceso = intval($_POST['idAnimalProceso']);
			$intEstado = intval($_POST['listStatus']);

		
			
			if($intEstado == 1)
			{
				if($_SESSION['permisosMod']['u'])
				{
					$request = $this->model->AprobarProceso($idProcesoAdopcion,$idAnimalProceso, $strDescripcion);
				}
				$option = 1;
			}else
			{
				if($_SESSION['permisosMod']['u'])
				{
					$request = $this->model->RechazarProceso($idProcesoAdopcion,$idAnimalProceso, $strDescripcion);
				}
				$option = 2;
			}
			if($request="Exito")
			{
				if($option == 1)
				{
					$arrResponse = array(	'estado'=> true,
											'msg'	=> 'Proceso actualizado.');
				}else
				{
					$arrResponse = array(	'estado'=> true,
											'msg'	=> 'Proceso actualizado.');
				}
				
			}else if($request == 'Error')
			{
				$arrResponse = array(	'estado'=> false,
										'msg'	=> '¡Error! Por favor inténtenlo más tarde.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}		

		public function consultarAdopcion(int $idProcesoAdopcion)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdProcesoAdopcion = intval(StrClean($idProcesoAdopcion));
				if($intIdProcesoAdopcion > 0) 
				{
					$arrData = $this->model->SelectAdopcion($intIdProcesoAdopcion);
				
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos no enontrados.');
					}else
					{
						$arrResponse = array(	'status'=> true,
												'data'	=> $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function DelOrganizacion($idOrganizacion)
		{
			if($_SESSION['permisosMod']['w'])
			{
				
				$url = APP_URL."/Organizacion/DelOrganizacion/".$idOrganizacion;
				$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
		
				if($arrData == 'ok')
				{
					$arrResponse = array(	'estado'=> true,
											'msg'	=> 'Se ha eliminado la organización.');
				}else if($arrData == 'exist')
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'No es posible eliminar una organización asociada a un usuario.');
				}else
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'Error al eliminar la organización.');
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}

	}
?>