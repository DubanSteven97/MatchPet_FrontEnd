<?php
	class Paginas extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Paginas');
		}

		public function Paginas()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Paginas";
			$data['page_name'] = "paginas";
			$data['page_title'] = "Paginas";
			$data['page_functions_js'] = "functions_paginas.min.js";
			$this->views->GetView($this,"paginas",$data);
		}

		public function Editar($idPagina)
		{
			if(empty($_SESSION['permisosMod']['u']))
			{
				header("Location:".BaseUrl().'/dashboard');
			}
			$idPagina = intval($idPagina);

			if($idPagina > 0)
			{
				$data['page_tag'] ="Actualizar Pagina";
				$data['page_name'] = "actualizar_pagina";
				$data['page_title'] = "Actualizar Página <small> Tienda Virtual</smal>";
				$data['page_functions_js'] = "functions_paginas.js";

				$infoPage = GetInfoPage($idPagina);

				if(empty($infoPage))
				{
					header("Location:".BaseUrl().'/paginas');
				}
				else
				{
					$data['infoPage'] = $infoPage;
				}
				$this->views->GetView($this,"EditarPagina",$data);
			}
			else
			{
				header("Location:".BaseUrl().'/paginas');
			}
			die();
		}

		public function Crear()
		{
			if(empty($_SESSION['permisosMod']['w']))
			{
				header("Location:".BaseUrl().'/dashboard');
			}
		
			$data['page_tag'] ="Crear Pagina";
			$data['page_name'] = "crear_pagina";
			$data['page_title'] = "Crear Página <small> Tienda Virtual</smal>";
			$data['page_functions_js'] = "functions_paginas.js";

			$this->views->GetView($this,"CrearPagina",$data);
			die();
		}
		public function GetPaginas()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectPaginas();
				for($i=0;$i<count($arrData);$i++){
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
					
					$urlPage = BaseUrl()."/".$arrData[$i]['ruta'];

					if($_SESSION['permisosMod']['r']){
						$btnView = '<a title="Ver Página" href="'.$urlPage.'" target="_balnck" class="btn btn-info btn-sm"><i class="far fa-eye"></i></a>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<a title="Editar Página" href="'.BaseUrl().'/paginas/editar/'.$arrData[$i]['idPagina'].'" class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelInfo" onClick="fntDelPagina('.$arrData[$i]['idPagina'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
		}

		public function SetPagina()
		{
			if($_POST)
			{
				if(empty($_POST['txtTitulo']) || empty($_POST['txtContenido']) || empty($_POST['listStatus']))
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}
				else
				{
					$intIdPagina = empty($_POST['idPagina']) ? 0 : intval($_POST['idPagina']);
					$strTitulo = StrClean($_POST['txtTitulo']);
					$strContenido = StrClean($_POST['txtContenido']);
					$intStatus = intval($_POST['listStatus']);
					$ruta = strtolower(ClearCadena($strTitulo));
					$ruta = str_replace(" ", "-", $ruta);

					$foto = $_FILES['foto'];
					$nombreFoto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = '';

					if($nombreFoto != '')
					{
						$imgPortada = 'img_'.md5(date('d-m-Y H:i:s')).'.jpg';
					}
					if($intIdPagina == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							$request = $this->model->InsertPagina($strTitulo, $strContenido, $imgPortada, $ruta, $intStatus);
							$option = 1;
						}
					}
					else
					{
						if($_SESSION['permisosMod']['u'])
						{
							if($nombreFoto == '')
							{
								if($_POST['foto_actual'] != '' && $_POST['foto_remove'] == 0)
								{
									$imgPortada = $_POST['foto_actual'];
								}
							}

							$request = $this->model->UpdatePagina($intIdPagina, $strTitulo, $strContenido, $imgPortada, $intStatus);
							$option = 2;
						}
					}
					if($request>0)
					{
						if($option == 1)
						{
							$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos guardados correctamente.');
							if($nombreFoto != '')
							{
								UploadImage($foto,$imgPortada);
							}
						}
						else
						{
							$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos actualizados correctamente.');
							if($nombreFoto != '')
							{
								UploadImage($foto,$imgPortada);
							}

							if(($nombreFoto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != '') || ($nombreFoto != '' && $_POST['foto_actual'] != ''))
							{
								DeleteFile($_POST['foto_actual']);
							}
						}
						
					}
					else if($request == 0)
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> '¡Atención! La ruta de la Página ya existe.');
					}
					else 
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'No es posible almacenar los datos');
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function DelPagina()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
						
					$intIdPagina = intval($_POST['idPagina']);
					$request = $this->model->DeletePagina($intIdPagina);
					if($request)
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado la página.');
					}else
					{
						$arrResponse = array(	'status'=> true,
						'msg'	=> 'Error al eliminar la página.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

	}
?>