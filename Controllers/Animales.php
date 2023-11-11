<?php
	class Animales extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Animales');
		}
		public function Animales()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Animales";
			$data['page_name'] = "animales";
			$data['page_title'] = "Animales<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_animales.min.js";
			$this->views->GetView($this,"animales",$data);
		}

		public function GetAnimales()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$url = APP_URL."/Animal/GetAnimales";
				$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
				$arrAux = $arrData;
				for($i=0;$i<count($arrAux);$i++){
					if($_SESSION['idUser'] == 1 || $arrData[$i]->organizacion == $_SESSION['userData']['nombreOrganizacion'])
					{
						$btnEdit = '';
						$btnDelete = '';

						if($arrData[$i]->estado==1)
						{
							$arrData[$i]->estado  = '<span class="badge badge-success">Activo</span>';
						}
						if($arrData[$i]->estado==2)
						{
							$arrData[$i]->estado = '<span class="badge badge-danger">Inactivo</span>';
						}

					
						if($_SESSION['permisosMod']['r']){
							$btnView = '<button class="btn btn-info btn-sm btnViewProducto" onClick= "fntViewAnimal('.$arrData[$i]->idAnimal.')" title="Ver Producto"><i class="fas fa-eye"></i></button>';
						}
						if($_SESSION['permisosMod']['u']){
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditProducto" onClick="fntEditAnimal(this,'.$arrData[$i]->idAnimal.')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
						}
						if($_SESSION['permisosMod']['d']){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelProducto" onClick="fntDelAnimal('.$arrData[$i]->idAnimal.')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
						}
						$arrData[$i]->options = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
						
					}
					else
					{
						unset($arrData[$i]);
					}
				}
				dep($arrData); exit();
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function SetAnimal()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombre']) || empty($_POST['txtGenero']) || empty($_POST['listOrganizacionId']) || empty($_POST['listTipoAnimalId']) || empty($_POST['listStatus']))
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$intIdAnimal = intval($_POST['idAnimal']);
					$strNombre = StrClean($_POST['txtNombre']);
					$strGenero = StrClean($_POST['txtGenero']);
					$strDescripcion = StrClean($_POST['txtDescripcion']);
					$intOrganizacionId = intval($_POST['listOrganizacionId']);
					$intTipoAnimalId = intval($_POST['listTipoAnimalId']);
					$fechaActual = date("Y-m-d");
					$ruta = strtolower(ClearCadena($strNombre));
					$ruta = str_replace(" ", "-", $ruta);
					$intStatus = intval($_POST['listStatus']);

					if(empty($dateFechaNacimiento)){
						$dateFechaNacimiento = "2000-01-01";
					}

					if($intIdAnimal == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							$animal = array ("nombre" => $strNombre,
							"idOrganizacion" => $intOrganizacionId,
							"idTipoAnimal" => $intTipoAnimalId,
							"genero" => $strGenero,
							"descripcion" => $strDescripcion,
							"fecha_nacimiento" => 	$dateFechaNacimiento ,
							"fechaCreacion" => 	$fechaActual ,
							"ruta" => $ruta,
							"estado" => $intStatus);
	
							$data = json_encode($animal);
							$url = APP_URL."/Animal/InsertAnimal";
							$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
						}
						$option = 1;
					}else
					{
						if($_SESSION['permisosMod']['u'])
						{
							$animal = array ("idAnimal" =>$intIdAnimal,
							"nombre" => $strNombre,
							"idOrganizacion" => $intOrganizacionId,
							"idTipoAnimal" => $intTipoAnimalId,
							"genero" => $strGenero,
							"descripcion" => $strDescripcion,
							"fecha_nacimiento" => 	$dateFechaNacimiento ,
							"fechaCreacion" => 	$fechaActual ,
							"ruta" => $ruta,
							"estado" => $intStatus);
	
							$data = json_encode($animal);
							$url = APP_URL."/Animal/UpdateAnimal";
							$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
						}
						$option = 2;
					}

					if($request>0)
					{
						if($option == 1)
						{

							$arrResponse = array(	'status'=> true,
													'idAnimal' => $request,
													'msg'	=> 'Datos guardados correctamente.');
						}else
						{
							$arrResponse = array(	'status'=> true,
													'idAnimal' => $request,
													'msg'	=> 'Datos actualizados correctamente.');
						}
						
					}else if($request == 2)
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> '¡Atención! El Animal ya.');
					}else 
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'No es posible almacenar los datos');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetAnimal($idAnimal)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdAnimal = intval(StrClean($idAnimal));
				if($intIdAnimal > 0) 
				{
					$url = APP_URL."/Animal/GetAnimal/".$intIdAnimal;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);

					if(empty($arrData))
					{
						
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos no enontrados.');
					}else
					{
						$url = APP_URL."/Animal/GetImgByAnimal/".$intIdAnimal;
						$arrDataImg = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
					
						if(count($arrDataImg)>0){
							for($i=0;$i<count($arrDataImg);$i++)
							{
								$arrDataImg[$i]->url_image = $arrDataImg[$i]->img;
								$arrDataImg[$i]->id_image = $arrDataImg[$i]->idImagen;
							}
						}
						$arrData->images= $arrDataImg;
						$arrResponse = array(	'status'=> true,
												'data'	=> $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function SetImage()
		{	
			if($_POST)
			{
				if($_SESSION['permisosMod']['w'])
				{
					if(empty($_POST['idAnimal'])){
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos incorrectos.');	
					}else
					{
						$intIdAnimal = intval($_POST['idAnimal']);
						$foto = fileToBase64($_FILES['foto']);
						$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
					
						$imagenAnimal = array ("idAnimal" =>$intIdAnimal,
						"img" => $foto,
						"estado" => 1);

						$data = json_encode($imagenAnimal);
						$url = APP_URL."/Animal/SetImagenAnimal";
						$request_image = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
		
						if($request_image)
						{
							
							$arrResponse = array('status' => true, 'idImagen' => $request_image, 'msg' => 'Imagen cargada correctamente.');
						}else
						{
							$arrResponse = array('status' => false, 'msg' => 'Error de carga.');
						}
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function DelAnimal()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdAnimal= intval($_POST['idAnimal']);
					$url = APP_URL."/Animal/DelAnimal/".$intIdAnimal;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
					if($arrData == 'ok')
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el animal.');
					}else if($arrData == 'exist')
					{
						$arrResponse = array(	'status'=> false,
						'msg'	=> 'No es posible eliminar un animal asociado a otros procesos.');
					}else
					{
						$arrResponse = array(	'status'=> false,
						'msg'	=> 'Error al eliminar el animal.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function DelFile()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'])
				{
					if(empty($_POST['idAnimal']) || empty($_POST['idImagen'])){
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos incorrectos.');	
					}else
					{
						
						$intIdAnimal = intval($_POST['idAnimal']);
						$intIdImagen = intval($_POST['idImagen']);

	
						$url = APP_URL."/Animal/DelFileAnimal/".$intIdAnimal."/".$intIdImagen;
						$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);

			

						if($arrData == 'ok')
						{
							$arrResponse = array(	'status'=> true,
													'msg'	=> 'Se ha eliminado la imagen.');
						}else 
						{
							$arrResponse = array(	'status'=> true,
							'msg'	=> 'Error al eliminar la imagen.');
						}
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>