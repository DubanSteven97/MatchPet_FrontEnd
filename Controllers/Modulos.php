<?php
	class Modulos extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Modulos');
		}
		
		public function Modulos()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Modulos";
			$data['page_title'] = "Modulos <smal>". NombreApp()."</smal>";
			$data['page_name'] = "modulos";
			$data['page_functions_js'] = "functions_modulos.min.js";
			$this->views->GetView($this,"modulos",$data);
		}

		public function SetModulo()
		{
			if(empty($_POST['txtTitulo']) ||
			    empty($_POST['txtDescripcion']) ||
			    empty($_POST['txtIcono']) ||
			    empty($_POST['listStatus']))
		   	{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{
		   		$idModulo = intval($_POST['idModulo']);
		   		$strTitulo = StrClean($_POST['txtTitulo']);
				$strDescripcion = ucwords(StrClean($_POST['txtDescripcion']));
				$strIcono = StrClean($_POST['txtIcono']);
				$intStatus = intval(StrClean($_POST['listStatus']));
				$strRuta = empty($_POST['txtRuta']) ? $strTitulo : StrClean($_POST['txtRuta']);

				$request = "";
				if($idModulo == 0)
				{
					if($_SESSION['permisosMod']['w'])
					{
						$modulo = array ("titulo" => $strTitulo,
						"descripcion" => $strDescripcion,
						"icono" => $strIcono,
						"estado" => $intStatus,
						"ruta" => $strRuta);

						$data = json_encode($modulo);
						$url = APP_URL."/Modulo/InsertModulo";
						$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
					}
					$option = 1;
				}else
				{
					if($_SESSION['permisosMod']['u'])
					{

						$modulo = array ("idModulo" => $idModulo,
						"titulo" => $strTitulo,
						"descripcion" => $strDescripcion,
						"icono" => $strIcono,
						"estado" => $intStatus,
						"ruta" => $strRuta);

						$data = json_encode($modulo);
						$url = APP_URL."/Modulo/UpdateModulo";
						$request = PeticionPost($url, $data, "application/json", $_SESSION['Token_APP']);
					}
					$option = 2;
				}
				if($request>0)
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
				}else if($request == 'exist')
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> '¡Atención! El titulo ya existe.');
				}else 
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar los datos');
				}
		   	}
		   	echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function GetModulos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$url = APP_URL."/Modulo/GetModulos";
				$arrData = PeticionGet($url, "application/json", $_SESSION['Token_APP']);
				for($i=0;$i<count($arrData);$i++){
					$btnEdit = '';
					$btnDelete = '';
                    $arrData[$i]->icono = '<i class="'.$arrData[$i]->icono.'"></i>';
					if($arrData[$i]->estado==1)
					{
						$arrData[$i]->estado = '<span class="badge badge-success">Activo</span>';
					}
					if($arrData[$i]->estado==2)
					{
						$arrData[$i]->estado = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewModulo" onClick= "fntViewModulo('.$arrData[$i]->idmodulo.')" title="Ver Modulo"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditModulo" onClick="fntEditModulo(this,'.$arrData[$i]->idmodulo.')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelModulo" onClick="fntDelModulo('.$arrData[$i]->idmodulo.')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]->options = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetModulo($idmodulo)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idModulo = intval($idmodulo);
				if($idModulo>0)
				{
					$url = APP_URL."/Modulo/GetModulo/".$idModulo;
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

		public function DelModulo()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
						
					$intidmodulo = intval($_POST['idModulo']);
					$request = $this->model->DeleteModulo($intidmodulo);
					if($request)
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el Modulo.');
					}else
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Error al eliminar el Modulo.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>