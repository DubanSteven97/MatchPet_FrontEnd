<?php
	class Productos extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Productos');
		}
		public function Productos()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Productos";
			$data['page_name'] = "Productos";
			$data['page_title'] = "Productos <small>". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_productos.js";
			$this->views->GetView($this,"productos",$data);
		}

		public function GetProductos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectProductos();
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

					$arrData[$i]['precio'] = formatMoney($arrData[$i]['precio']);
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewProducto" onClick= "fntViewProducto('.$arrData[$i]['idproducto'].')" title="Ver Producto"><i class="fas fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditProducto" onClick="fntEditProducto(this,'.$arrData[$i]['idproducto'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelProducto" onClick="fntDelProducto('.$arrData[$i]['idproducto'].')" title="Eliminar"><i class="fas fa-trash-alt"></i></button></div>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetProducto($idProducto)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$intIdProducto = intval(StrClean($idProducto));
				if($intIdProducto > 0) 
				{
					$arrData = $this->model->SelectProducto($intIdProducto);
					if(empty($arrData))
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos no enontrados.');
					}else
					{
						$arrImg = $this->model->SelectImages($intIdProducto);
						if(count($arrImg)>0){
							for($i=0;$i<count($arrImg);$i++)
							{
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$arrData['precioF'] = formatMoney($arrData['precio']);
						$arrData['images'] = $arrImg;
						$arrResponse = array(	'status'=> true,
												'data'	=> $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function DelProducto()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['d'])
				{
						
					$intIdProducto = intval($_POST['idProducto']);
					$request = $this->model->DeleteProducto($intIdProducto);
					if($request)
					{
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Se ha eliminado el producto.');
					}else
					{
						$arrResponse = array(	'status'=> true,
						'msg'	=> 'Error al eliminar el producto.');
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function SetProducto()
		{
			if($_POST)
			{
				if(empty($_POST['txtNombre']) || empty($_POST['txtCodigo']) || empty($_POST['txtPrecio']) || (empty($_POST['txtStock']) && $_POST['txtStock'] != 0) || empty($_POST['listCategoria']) || empty($_POST['listStatus']))
				{
					$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');	
				}else
				{
					$intIdProducto = intval($_POST['idProducto']);
					$strNombre = StrClean($_POST['txtNombre']);
					$strDescripcion = StrClean($_POST['txtDescripcion']);
					$strCodigo = StrClean($_POST['txtCodigo']);
					$intCategoriaId = intval($_POST['listCategoria']);
					$strPrecio = StrClean($_POST['txtPrecio']);
					$intStock = intval($_POST['txtStock']);
					$intStatus = intval($_POST['listStatus']);

					$ruta = strtolower(ClearCadena($strNombre));
					$ruta = str_replace(" ", "-", $ruta);

					if($intIdProducto == 0)
					{
						if($_SESSION['permisosMod']['w'])
						{
							$request_Producto = $this->model->InsertProducto($strNombre, $strDescripcion, $strCodigo, $intCategoriaId, $strPrecio, $intStock, $ruta, $intStatus);
						}
						$option = 1;
					}else
					{
						if($_SESSION['permisosMod']['u'])
						{
							$request_Producto = $this->model->UpdateProducto($intIdProducto, $strNombre, $strDescripcion, $strCodigo, $intCategoriaId, $strPrecio, $intStock, $ruta, $intStatus);
						}
						$option = 2;
					}
					if($request_Producto>0)
					{
						if($option == 1)
						{
							$arrResponse = array(	'status'=> true,
													'idproducto' => $request_Producto,
													'msg'	=> 'Datos guardados correctamente.');
						}else
						{
							$arrResponse = array(	'status'=> true,
													'idproducto' => $request_Producto,
													'msg'	=> 'Datos actualizados correctamente.');
						}
						
					}else if($request_Producto == 'exist')
					{
						$arrResponse = array(	'status'=> false,
												'msg'	=> '¡Atención! El Producto ya existe con el código ingresado.');
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

		public function SetImage()
		{	
			if($_POST)
			{
				if($_SESSION['permisosMod']['w'])
				{
					if(empty($_POST['idproducto'])){
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos incorrectos.');	
					}else
					{
						$idproducto = intval($_POST['idproducto']);
						$foto = $_FILES['foto'];
						$imgNombre = 'pro_'.md5(date('d-m-Y H:m:s')).'.jpg';
						$request_image = $this->model->InsertImage($idproducto,$imgNombre);
						if($request_image)
						{
							$uploadImage = UploadImage($foto, $imgNombre);
							$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Imagen cargada correctamente.');
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

		public function DelFile()
		{
			if($_POST)
			{
				if($_SESSION['permisosMod']['u'])
				{
					if(empty($_POST['idproducto']) || empty($_POST['file'])){
						$arrResponse = array(	'status'=> false,
												'msg'	=> 'Datos incorrectos.');	
					}else
					{
						
						$intIdProducto = intval($_POST['idproducto']);
						$imgNombre = StrClean($_POST['file']);
						$request = $this->model->DeleteImage($intIdProducto, $imgNombre);
						if($request)
						{
							$deleteFile = DeleteFile($imgNombre);
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