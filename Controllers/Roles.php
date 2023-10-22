<?php
	class Roles extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Roles');
		}
		public function roles()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Roles Usuario";
			$data['page_name'] = "rol_usuario";
			$data['page_title'] = "Roles Usuario <small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_roles.js";
			$this->views->GetView($this,"roles",$data);
		}

		public function GetRoles()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectRoles();
				for($i=0;$i<count($arrData);$i++){
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status']==1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}
					if($arrData[$i]['status']==2)
					{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fas fa-key"></i></button>
									<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol(this,'.$arrData[$i]['idrol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">
												
												'.$btnEdit.' '.$btnDelete.'
												';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->model->SelectRoles();
			if(count($arrData) > 0)
			{
				for($i=0;$i<count($arrData);$i++)
				{
					if($arrData[$i]['status'] == 1)
					{
						$htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'"> '.$arrData[$i]['nombrerol'].' </option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}

		public function GetRol(int $idRol)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdRol = intval(StrClean($idRol));
				if($intIdRol > 0) 
				{
					$arrData = $this->model->SelectRol($intIdRol);
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

		public function SetRol()
		{
			$intIdRol = intval($_POST['idrol']);
			$strRol = StrClean($_POST['txtNombre']);
			$strDescripcion = StrClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			if($intIdRol == 0)
			{
				if($_SESSION['permisosMod']['w'])
				{
					$request_rol = $this->model->InsertRol($strRol, $strDescripcion, $intStatus);
				}
				$option = 1;
			}else
			{
				if($_SESSION['permisosMod']['u'])
				{
					$request_rol = $this->model->UpdateRol($intIdRol, $strRol, $strDescripcion, $intStatus);
				}
				$option = 2;
			}
			if($request_rol>0)
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
				
			}else if($request_rol == 'exist')
			{
				$arrResponse = array(	'status'=> false,
										'msg'	=> '¡Atención! El rol ya existe.');
			}else 
			{
				$arrResponse = array(	'status'=> false,
										'msg'	=> 'No es posible almacenar los datos');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function DelRol()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['w'])
				{
					
					$intIdRol = intval($_POST['idRol']);
					$request_rol = $this->model->DeleteRol($intIdRol);
					if($request_rol == 'ok')
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el rol.');
					}else if($request_rol == 'exist')
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'No es posible eliminar un rol asociado a un usuario.');
					}else
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Error al eliminar el rol.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>