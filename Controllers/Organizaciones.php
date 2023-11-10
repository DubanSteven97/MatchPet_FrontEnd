<?php
	class Organizaciones extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Organizaciones');
		}
		public function Organizaciones()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Organizaciones";
			$data['page_name'] = "organizaciones";
			$data['page_title'] = "Organizaciones<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_Organizaciones.min.js";
			$this->views->GetView($this,"organizaciones",$data);
		}
		public function SetOrganizacion()
		{
			if(empty($_POST['txtNombre']) ||
			    empty($_POST['listStatus']))
		   	{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{
		   		$idOrganizacion = intval($_POST['idOrganizacion']);
		   		$strNombre = StrClean($_POST['txtNombre']);
				$strDescripcion = ucwords(StrClean($_POST['txtDescripcion']));
				$strTelefono = StrClean($_POST['txtTelefono']);
				$strDireccion = StrClean($_POST['txtDireccion']);
				$intStatus = intval(StrClean($_POST['listStatus']));
			
				$request = "";
				if($idOrganizacion == 0)
				{
					if($_SESSION['permisosMod']['w'])
					{
						$organizacion = array ("nombre" => $strNombre,
						"descripcion" => $strDescripcion,
						"telefono" => $strTelefono,
						"direccion" => $strDireccion,
						"estado" => $intStatus);

						$data = json_encode($organizacion);
						$url = APP_URL."/Organizacion/InsertOrganizacion";
						$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
					}
					$option = 1;
				}else
				{
					if($_SESSION['permisosMod']['u'])
					{

						$organizacion = array ("idOrganizacion" => $idOrganizacion,
						"nombre" => $strNombre,
						"descripcion" => $strDescripcion,
						"telefono" => $strTelefono,
						"direccion" => $strDireccion,
						"estado" => $intStatus);

						$data = json_encode($organizacion);
						$url = APP_URL."/Organizacion/UpdateOrganizacion";
						$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
					}
					$option = 2;
				}
				if($request>0 && $request<2 )
				{
					if($option == 1)
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Datos guardados correctamente.');
					}else
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Datos actualizados correctamente.');
					}
				}else if($request == 2)
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> '¡Atención! La organización ya existe.');
				}else 
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar los datos');
				}
		   	}
		   	echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
		public function GetOrganizaciones()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$url = APP_URL."/Organizacion/GetOrganizaciones";
				$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
				for($i=0;$i<count($arrData);$i++){
					$btnEdit = '';
					$btnDelete = '';
					if($arrData[$i]->estado==1)
					{
						$arrData[$i]->estado = '<span class="badge badge-success">Activo</span>';
					}
					if($arrData[$i]->estado==2)
					{
						$arrData[$i]->estado = '<span class="badge badge-danger">Inactivo</span>';
					}
					
					if($_SESSION['permisosMod']['r']){
						$btnList = '<button class="btn btn-info btn-sm btnViewModulo" onClick= "fntViewUsersByOrganizacio('.$arrData[$i]->idOrganizacion.')" title="Listar Usuarios"><i class="fa-solid fa-list"></i></button>';
						$btnView = '<button class="btn btn-info btn-sm btnViewModulo" onClick= "fntViewOrganizacio('.$arrData[$i]->idOrganizacion.')" title="Ver Organiazción"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditModulo" onClick="fntEditOrganizacion(this,'.$arrData[$i]->idOrganizacion.')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelModulo" onClick="fntDelOrganiazcion('.$arrData[$i]->idOrganizacion.')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]->options = '<div class="text-center">'.$btnList.' '.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetUserByOrganizacion($idOrganizacion)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idOrganizacion = intval($idOrganizacion);
				if($idOrganizacion>0)
				{
					$url = APP_URL."/Organizacion/GetUserByOrganizacion/".$idOrganizacion;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
													'msg'	=> 'La organización no tiene usuarios asignados.');	
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

		public function GetOrganizacion($idOrganizacion)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idOrganizacion = intval($idOrganizacion);
				if($idOrganizacion>0)
				{
					$url = APP_URL."/Organizacion/GetOrganizacion/".$idOrganizacion;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
													'msg'	=> 'Datos no encontrados.');	
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


		public function GetSelectOrganizaciones()
		{
			$htmlOptions = "";
			$url = APP_URL."/Organizacion/GetOrganizaciones";
			$arrData =PeticionGet($url, "application/json", $_SESSION['Token_APP']);
			if(count($arrData) > 0)
			{
				if($_SESSION['idUser'] == 1)
				{
					$htmlOptions = '<option value="-1"> Sin organización </option>';
				}
				for($i=0;$i<count($arrData);$i++)
				{
					if($arrData[$i]->estado == 1)
					{
						if($arrData[$i]->idOrganizacion == $_SESSION['userData']['idOrganizacion'] || $_SESSION['idUser'] == 1)
						{
							$htmlOptions .= '<option value="'.$arrData[$i]->idOrganizacion.'"> '.$arrData[$i]->nombre.' </option>';
						}
					}
				}
				
			}
			echo $htmlOptions;
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