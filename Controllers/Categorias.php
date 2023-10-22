<?php
	class Categorias extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Categorias');
		}
		public function Categorias()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Categorias";
			$data['page_name'] = "Categorias";
			$data['page_title'] = "Categorias <small>". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_categorias.js";
			$this->views->GetView($this,"categorias",$data);
		}

		public function GetCategorias()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectCategorias();
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
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewCategoria" onClick= "fntViewCategoria('.$arrData[$i]['idcategoria'].')" title="Ver Categoria"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditCategoria" onClick="fntEditCategoria(this,'.$arrData[$i]['idcategoria'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelCategoria" onClick="fntDelCategoria('.$arrData[$i]['idcategoria'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetCategoria(int $idCategoria)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdCategoria = intval(StrClean($idCategoria));
				if($intIdCategoria > 0) 
				{
					$arrData = $this->model->SelectCategoria($intIdCategoria);
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos no enontrados.');
					}else
					{
						$arrData['url_portada'] = Media().'/images/uploads/'.$arrData['portada'];
						$arrResponse = array(	'status'=> true,
												'data'	=> $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function SetCategoria()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']))
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$intIdCategoria = intval($_POST['idCategoria']);
					$strCategoria = StrClean($_POST['txtNombre']);
					$strDescripcion = StrClean($_POST['txtDescripcion']);
					$intStatus = intval($_POST['listStatus']);
					$ruta = strtolower(ClearCadena($strCategoria));
					$ruta = str_replace(" ", "-", $ruta);

					$foto = $_FILES['foto'];
					$nombreFoto = $foto['name'];
					$type = $foto['type'];
					$url_temp = $foto['tmp_name'];
					$imgPortada = 'portada_categoria.png';

					if($nombreFoto != '')
					{
						$imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
					}
					if($intIdCategoria == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							$request_Categoria = $this->model->InsertCategoria($strCategoria, $strDescripcion, $imgPortada, $ruta, $intStatus);
						}
						$option = 1;
					}else
					{
						if($nombreFoto == '')
						{
							if($_POST['foto_actual'] != 'portada_Categoria.png' && $_POST['foto_remove'] == 0)
							{
								$imgPortada = $_POST['foto_actual'];
							}
						}

						if($_SESSION['permisosMod']['u'])
						{
							$request_Categoria = $this->model->UpdateCategoria($intIdCategoria, $strCategoria, $strDescripcion, $imgPortada, $ruta, $intStatus);
						}
						$option = 2;
					}
					if($request_Categoria>0)
					{
						if($option == 1)
						{
							$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos guardados correctamente.');
							if($nombreFoto != '')
							{
								UploadImage($foto,$imgPortada);
							}
						}else
						{
							$arrResponse = array(	'status'=> true,
													'msg'	=> 'Datos actualizados correctamente.');
							if($nombreFoto != '')
							{
								UploadImage($foto,$imgPortada);
							}

							if(($nombreFoto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png') || ($nombreFoto != '' && $_POST['foto_actual'] != 'portada_categoria.png'))
							{
								DeleteFile($_POST['foto_actual']);
							}
						}
						
					}else if($request_Categoria == 'exist')
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> '¡Atención! La Categoria ya existe.');
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

		public function DelCategoria()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
						
					$intIdCategoria = intval($_POST['idCategoria']);
					$request = $this->model->DeleteCategoria($intIdCategoria);
					if($request == 'ok')
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado la categoría.');
					}else if($request == 'exist')
					{
						$arrResponse = array(	'status'=> true,
						'msg'	=> 'No es posible eliminar una categoría con productos asociados.');
					}else
					{
						$arrResponse = array(	'status'=> true,
						'msg'	=> 'Error al eliminar la categoría.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function GetSelectCategorias()
		{
			$htmlOptions = "";
			$arrData = $this->model->SelectCategorias();
			if(count($arrData)>0)
			{
				for($i=0;$i<count($arrData);$i++)
				{
					if($arrData[$i]['status']==1)
					{
						$htmlOptions .= '<option value = "'.$arrData[$i]['idcategoria'].'"> '.$arrData[$i]['nombre'].' </option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}
	}
?>