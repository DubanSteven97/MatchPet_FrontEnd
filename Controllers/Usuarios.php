<?php
	class Usuarios extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Usuarios');
		}
		public function Usuarios()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Usuarios";
			$data['page_name'] = "usuarios";
			$data['page_title'] = "Usuarios <small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_usuarios.min.js";
			$this->views->GetView($this,"usuarios",$data);
		}

		public function SetUsuario()
		{
			if(empty($_POST['txtIdentificacion']) ||
			    empty($_POST['txtNombres']) ||
			    empty($_POST['txtApellidos']) ||
			    empty($_POST['txtTelefono']) ||
			    empty($_POST['txtEmail']) ||
			    empty($_POST['listRolId']) ||
			    empty($_POST['listStatus'])||
			    empty($_POST['listOrganizacionId']))
		   	{
				
				$arrResponse = array(	'estado'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{
		   		$idUsuario = intval($_POST['idUsuario']);
		   		$strIdentificacion = StrClean($_POST['txtIdentificacion']);
				$strNombres = ucwords(StrClean($_POST['txtNombres']));
				$strApellidos = ucwords(StrClean($_POST['txtApellidos']));
				$intTelefono = intval(StrClean($_POST['txtTelefono']));
				$strEmail = strtolower(StrClean($_POST['txtEmail']));
				$intRolId = intval(StrClean($_POST['listRolId']));
				$intestado = intval(StrClean($_POST['listStatus']));
				$intIdOrganizacion = intval(StrClean($_POST['listOrganizacionId']));
				if ($intIdOrganizacion == -1 && $intRolId != 1 )
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'Debe seleccionar una organización válida');
				}
				else
				{
					$intIdOrganizacion = $intIdOrganizacion == -1 ? null : $intIdOrganizacion;
					$request_user = "";
					if($idUsuario == 0)
					{
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256",PassGenerator()) : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['w'])
						{
							$request_user = $this->model->InsertUsuario($strIdentificacion,
																		$strNombres,
																		$strApellidos,
																		$intTelefono,
																		$strEmail,
																		$strPassword,
																		$intRolId,
																		$intestado,
																		$intIdOrganizacion
																		);
						}
						$option = 1;
					}else
					{
						$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u'])
						{
							$request_user = $this->model->UpdateUsuario($idUsuario,
																		$strIdentificacion,
																		$strNombres,
																		$strApellidos,
																		$intTelefono,
																		$strEmail,
																		$strPassword,
																		$intRolId,
																		$intestado,
																		$intIdOrganizacion
																		);
						}
						$option = 2;
					}
					if($request_user>0 /*&& $request_user != 'exist'*/) 
					{
						if($option == 1)
						{
							$arrResponse = array(	'estado'=> true,
													'msg'	=> 'Datos guardados correctamente.');
						}else
						{
							$arrResponse = array(	'estado'=> true,
													'msg'	=> 'Datos actualizados correctamente.');
						}
					}else if($request_user == 'exist')
					{
						$arrResponse = array(	'estado'=> false,
												'msg'	=> '¡Atención! El email o identificación ya existe.');
					}else 
					{
						$arrResponse = array(	'estado'=> false,
												'msg'	=> 'No es posible almacenar los datos');
					}
				}
		   	}
		   	echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function GetUsuarios()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectUsuarios();
				for($i=0;$i<count($arrData);$i++){
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($arrData[$i]['estado']==1)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
					}
					if($arrData[$i]['estado']==2)
					{
						$arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick= "fntViewUsuario('.$arrData[$i]['idPersona'].')" title="Ver usuario"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['nombreRol'] == 'Administrador') ||
							($_SESSION['userData']['nombreRol'] == 'Administrador' AND $arrData[$i]['nombreRol'] != 'Administrador') ||
							($_SESSION['userData']['idPersona'] != $arrData[$i]['idPersona']))
						{
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick= "fntEditUsuario(this,'.$arrData[$i]['idPersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else
						{
							$btnEdit = '<button class="btn btn-primary btn-sm " disabled><i class="fas fa-pencil-alt"></i></button>';
						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['nombreRol'] == 'Administrador') ||
							($_SESSION['userData']['nombreRol'] == 'Administrador' AND $arrData[$i]['nombreRol'] != 'Administrador') AND
							($_SESSION['userData']['idPersona'] != $arrData[$i]['idPersona']))
						{
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick= "fntDelUsuario('.$arrData[$i]['idPersona'].')" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button>';
						}else
						{
							$btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">
												'.$btnView.' '.$btnEdit.' '.$btnDelete.'
												</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
				
			die();
		}

		public function GetUsuario($idPersona)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idUsuario = intval($idPersona);
				if($idUsuario>0)
				{
					$arrData = $this->model->SelectUsuario($idUsuario);
					if(empty($arrData))
					{
						$arrResponse = array(	'estado'=> false,
													'msg'	=> 'Datos no encontrados.');	
					}else
					{
						$arrResponse = array(	'estado'=> true,
													'data'	=> $arrData);	
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function DelUsuario()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'])
				{
						
					$intidPersona = intval($_POST['idUsuario']);
					$request = $this->model->DeleteUsuario($intidPersona);
					if($request)
					{
						$arrResponse = array(	'estado'=> true,
												'msg'	=> 'Se ha eliminado el usuario.');
					}else
					{
						$arrResponse = array(	'estado'=> true,
												'msg'	=> 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function Perfil()
		{
			$data['page_tag'] ="Perfil";
			$data['page_name'] = "Perfil";
			$data['page_title'] = "Perfil de usuario";
			$data['page_functions_js'] = "functions_perfil.js";
			$this->views->GetView($this,"perfil",$data);
		}

		public function PutPerfil()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombres']) ||
			    empty($_POST['txtApellidos']) ||
			    empty($_POST['txtTelefono']))
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$idUsuario = intval($_SESSION['idUser']);
					$strNombres = ucwords(StrClean($_POST['txtNombres']));
					$strApellidos = ucwords(StrClean($_POST['txtApellidos']));
					$intTelefono = intval(StrClean($_POST['txtTelefono']));
					$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
					$request_user = $this->model->UpdatePerfil($idUsuario,
																$strNombres,
																$strApellidos,
																$intTelefono,
																$strPassword);
					if($request_user)
					{
						SessionUser($_SESSION['idUser']);
						$arrResponse = array(	'estado'=> true,
													'msg'	=> 'Datos Actualizados correctamente.');
					}else
					{
						$arrResponse = array(	'estado'=> false,
													'msg'	=> 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function PutDFiscal()
		{
			if($_POST)
			{
				if(empty($_POST['txtNit']) ||
			    empty($_POST['txtNombreFiscal']) ||
			    empty($_POST['txtDireccionFiscal']))
				{
					$arrResponse = array(	'estado'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$idUsuario = intval($_SESSION['idUser']);
					$strNit = StrClean($_POST['txtNit']);
					$strNombreFiscal = ucwords(StrClean($_POST['txtNombreFiscal']));
					$strDireccionFiscal = StrClean($_POST['txtDireccionFiscal']);
					$request_user = $this->model->UpdateDataFiscal($idUsuario,
																$strNit,
																$strNombreFiscal,
																$strDireccionFiscal);
					if($request_user)
					{
						SessionUser($_SESSION['idUser']);
						$arrResponse = array(	'estado'=> true,
													'msg'	=> 'Datos Actualizados correctamente.');
					}else
					{
						$arrResponse = array(	'estado'=> false,
													'msg'	=> 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>