<?php
	class Adopciones extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Adopciones');
		}
		public function Adopciones()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Adopciones";
			$data['page_name'] = "adopciones";
			$data['page_title'] = "Adopciones<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_adopciones.js";
			$this->views->GetView($this,"adopciones",$data);
		}
		
		public function GetAdopciones()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idOrganizacion = intval( $_SESSION['userData']['idOrganizacion']);
				$idPersona = intval( $_SESSION['userData']['idPersona']);
				$nombreRol = ucwords( $_SESSION['userData']['nombreRol']);

				$arrData = $this->model->SelectProcesos($idOrganizacion,$idPersona,$nombreRol);
				for($i=0;$i<count($arrData);$i++){

					$btnGest = '';

					$estado = $arrData[$i]['estado'];
	
					if($arrData[$i]['estado']==1)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-primary">En proceso</span>';
					}
					if($arrData[$i]['estado']==2)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($arrData[$i]['estado']==3)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-success">Aprobado</span>';
					}
					if($arrData[$i]['estado']==4)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-danger">Rechazado</span>';
					}
					
					if($_SESSION['permisosMod']['u']){
						if($estado  == 1){
							$btnGest = '<button class="btn btn-info btn-sm" onClick= "fntAprobarProceso('.$arrData[$i]['idProcesoAdopcion'].')" title="Validar solicitud" ><i class="fa-solid fa-magnifying-glass"></i></button>';
						}else{
							$btnGest = '<button class="btn btn-info btn-sm" onClick= "fntAprobarProceso('.$arrData[$i]['idProcesoAdopcion'].')" title="Validar solicitud" disabled><i class="fa-solid fa-magnifying-glass"></i></button>';
						}
							
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