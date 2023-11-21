<?php
	class Contactos extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Mensajes');
		}
		public function Contactos()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Contactos";
			$data['page_name'] = "contactos";
			$data['page_title'] = "contactos <small> Tienda Virtual</smal>";
			$data['page_functions_js'] = "functions_contactos.js";
			$this->views->GetView($this,"contactos",$data);
		}

		public function GetContactos()
		{
			if($_SESSION['permisosMod']['r'])
			{
				$arrData = $this->model->SelectContactos();
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id'].')" title="Ver mensaje"><i class="far fa-eye"></i></button>';
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
				}
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function GetContacto(int $idMensaje)
		{
			if($_SESSION['permisosMod']['r'])
			{
				$idMensaje = intval($idMensaje);
				if($idMensaje > 0)
				{
					$arrData = $this->model->SelectContacto($idMensaje);	
					if(empty($arrData))
					{
						$arrResponse = array('status' => false,
												'msg' => 'Datos no encontrados');
					}else
					{
						$arrResponse = array('status' => true,
												'data' => $arrData);
					}
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>