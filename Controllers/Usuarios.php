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
			$data['page_functions_js'] = "functions_usuarios.js";
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
			    empty($_POST['listStatus']))
		   	{
				$arrResponse = array(	'status'=> false,
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
				$intStatus = intval(StrClean($_POST['listStatus']));
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
																	$intStatus
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
																	$intStatus
																	);
					}
					$option = 2;
				}

				if($request_user>0)
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
				}else if($request_user == 'exist')
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> '¡Atención! El email o identificación ya existe.');
				}else 
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'No es posible almacenar los datos');
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
					if($arrData[$i]['status']==1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}
					if($arrData[$i]['status']==2)
					{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick= "fntViewUsuario('.$arrData[$i]['idpersona'].')" title="Ver usuario"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['nombrerol'] == 'Administrador') ||
							($_SESSION['userData']['nombrerol'] == 'Administrador' AND $arrData[$i]['nombrerol'] != 'Administrador'))
						{
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick= "fntEditUsuario(this,'.$arrData[$i]['idpersona'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else
						{
							$btnEdit = '<button class="btn btn-primary btn-sm " disabled><i class="fas fa-pencil-alt"></i></button>';
						}
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['nombrerol'] == 'Administrador') ||
							($_SESSION['userData']['nombrerol'] == 'Administrador' AND $arrData[$i]['nombrerol'] != 'Administrador') AND
							($_SESSION['userData']['idpersona'] != $arrData[$i]['idpersona']))
						{
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick= "fntDelUsuario('.$arrData[$i]['idpersona'].')" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button>';
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

		public function DelUsuario()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'])
				{
						
					$intIdPersona = intval($_POST['idUsuario']);
					$request = $this->model->DeleteUsuario($intIdPersona);
					if($request)
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el usuario.');
					}else
					{
						$arrResponse = array(	'status'=> true,
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
					$arrResponse = array(	'status'=> false,
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
						$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos Actualizados correctamente.');
					}else
					{
						$arrResponse = array(	'status'=> false,
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
					$arrResponse = array(	'status'=> false,
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
						$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos Actualizados correctamente.');
					}else
					{
						$arrResponse = array(	'status'=> false,
													'msg'	=> 'No es posible actualizar los datos.');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>