<?php
	class TipoAnimal extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Tipo de animal');
		}
		public function TipoAnimal()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="TipoAnimal";
			$data['page_name'] = "TipoAnimal";
			$data['page_title'] = "Tipo de animal <small>". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_TipoAnimal.min.js";
			$this->views->GetView($this,"TipoAnimal",$data);
		}

		public function GetTipoAnimales()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$url = APP_URL."/TipoAnimal/GetTipoAnimales";
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
						$btnView = '<button class="btn btn-info btn-sm btnViewTipoAnimal" onClick= "fntViewTipoAnimal('.$arrData[$i]->idTipoAnimal.')" title="Ver Tipo de animal"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditTipoAnimal" onClick="fntEditTipoAnimal(this,'.$arrData[$i]->idTipoAnimal.')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelTipoAnimal" onClick="fntDelTipoAnimal('.$arrData[$i]->idTipoAnimal.')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]->options = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetTipoAnimal(int $idTipoAnimal)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdTipoAnimal = intval(StrClean($idTipoAnimal));
				if($intIdTipoAnimal > 0) 
				{
					$url = APP_URL."/TipoAnimal/GetTipoAnimal/".$intIdTipoAnimal;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
				
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos no enontrados.');
					}else
					{
						$arrData->url_portada = $arrData->img;
						$arrResponse = array(	'status'=> true,
												'data'	=> $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function SetTipoAnimal()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']))
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$idTipoAnimal= intval($_POST['idTipoAnimal']);
					$strnombre = StrClean($_POST['txtNombre']);
					$strDescripcion = StrClean($_POST['txtDescripcion']);
					$intStatus = intval($_POST['listStatus']);
					$ruta = 'No se para que es la ruta';
					$fechaActual = date("Y-m-d");
					$request = "";



					if(empty($_FILES['foto']['name'])){
						$foto = media()."/images/uploads/portada_categoria.png";
					}else{
					
						$foto = fileToBase64($_FILES['foto']);
					}

				

					if($idTipoAnimal == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							{
								$tipoAnimal = array ("nombre" => $strnombre,
								"descripcion" => $strDescripcion,
								"img" => $foto,
								"fechaCreacion" => 	$fechaActual ,
								"ruta" => $ruta,
								"estado" => $intStatus);
		
								$data = json_encode($tipoAnimal);
								$url = APP_URL."/TipoAnimal/InsertTipoAnimal";
								$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
							}
					
						}
						$option = 1;
					}else
					{
						if($_SESSION['permisosMod']['u'])
						{

							$fotoActual = ($_POST['foto_actual']);

							if(empty($_FILES['foto']['name'])){
								
								$foto = $fotoActual;
							}else{
							
								$foto = fileToBase64($_FILES['foto']);
							}


							$tipoAnimal = array ("idTipoAnimal" => $idTipoAnimal,
							"nombre" => $strnombre,
							"descripcion" => $strDescripcion,
							"img" => $foto,
							"fechaCreacion" => 	$fechaActual ,
							"ruta" => $ruta,
							"estado" => $intStatus);
	
							$data = json_encode($tipoAnimal);
							$url = APP_URL."/TipoAnimal/UpdateTipoAnimal";
							$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);

						}
						$option = 2;
					}

					
					if($request>0 && $request<2)
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
												'msg'	=> '¡Atención! El tipo de animal ya existe.');
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

		public function DelTipoAnimal()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
					$intIdTipoAnimal= intval($_POST['idTipoAnimal']);
					$url = APP_URL."/TipoAnimal/DelTipoAnimal/".$intIdTipoAnimal;
					$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
					if($arrData == 'ok')
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el tipo de animal.');
					}else if($arrData == 'exist')
					{
						$arrResponse = array(	'status'=> false,
						'msg'	=> 'No es posible eliminar un tipo de animal con animales asociados.');
					}else
					{
						$arrResponse = array(	'status'=> false,
						'msg'	=> 'Error al eliminar el tipo de animal.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function GetSelectTipoAnimal()
		{
			$htmlOptions = "";
			$url = APP_URL."/TipoAnimal/GetTipoAnimales";
			$arrData =PeticionGet($url, "application/json", $_SESSION['Token_APP']);
			if(count($arrData) > 0)
			{
				for($i=0;$i<count($arrData);$i++)
				{
					if($arrData[$i]->estado == 1)
					{
						$htmlOptions .= '<option value="'.$arrData[$i]->idTipoAnimal.'"> '.$arrData[$i]->nombre.' </option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}
	}
?>