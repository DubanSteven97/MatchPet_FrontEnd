<?php
	class Clientes extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Clientes');
		}
		public function Clientes()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Clientes";
			$data['page_name'] = "Clientes";
			$data['page_title'] = "Clientes <small>". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_clientes.js";
			$this->views->GetView($this,"clientes",$data);
		}

		public function SetCliente()
		{
			if(empty($_POST['txtIdentificacion']) ||
			    empty($_POST['txtNombres']) ||
			    empty($_POST['txtApellidos']) ||
			    empty($_POST['txtTelefono']) ||
			    empty($_POST['txtEmail']) ||
			    empty($_POST['listStatus'])||
				empty($_POST['txtIdentificacionTributaria'])||
				empty($_POST['txtRazon'])||
				empty($_POST['txtDireccion']))
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
				$intRolId = 8;
				$intStatus = intval(StrClean($_POST['listStatus']));
				$strnit = StrClean($_POST['txtIdentificacionTributaria']);
				$strrazon = ucwords(StrClean($_POST['txtRazon']));
				$strdireccion= ucwords(StrClean($_POST['txtDireccion']));
				$request_user = "";
				if($idUsuario == 0)
				{
					$strPassword = empty($_POST['txtPassword']) ? hash("SHA256",PassGenerator()) : hash("SHA256",$_POST['txtPassword']);
					if($_SESSION['permisosMod']['w'])
					{
						$request_user = $this->model->InsertCliente($strIdentificacion,
																	$strNombres,
																	$strApellidos,
																	$intTelefono,
																	$strEmail,
																	$strPassword,
																	$intRolId,
																	$intStatus,
																	$strnit,
																	$strrazon,
																	$strdireccion
																	);
					}
					$option = 1;
				}else
				{
					$strPassword = empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
					if($_SESSION['permisosMod']['u'])
					{
						$request_user = $this->model->UpdateCliente($idUsuario,
																	$strIdentificacion,
																	$strNombres,
																	$strApellidos,
																	$intTelefono,
																	$strEmail,
																	$strPassword,
																	$intRolId,
																	$intStatus,
																	$strnit,
																	$strrazon,
																	$strdireccion																	
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
		public function GetClientes()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectClientes();
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
						$btnView = '<button class="btn btn-info btn-sm btnViewCliente" onClick= "fntViewCliente('.$arrData[$i]['idpersona'].')" title="Ver cliente"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCliente" onClick= "fntEditCliente(this,'.$arrData[$i]['idpersona'].')" title="Editar cliente"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick= "fntDelCliente('.$arrData[$i]['idpersona'].')" title="Eliminar Cliente"><i class="fas fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">
												'.$btnView.' '.$btnEdit.' '.$btnDelete.'
												</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
				
			die();
		}

		public function GetCliente($idPersona)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idUsuario = intval($idPersona);
				if($idUsuario>0)
				{
					$arrData = $this->model->SelectCliente($idUsuario);
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

		public function DelCliente()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'])
				{
						
					$intIdPersona = intval($_POST['idUsuario']);
					$request = $this->model->DeleteCliente($intIdPersona);
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

	}
?>