<?php
	class Configuraciones extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Configuraciones');
		}
		public function Configuraciones()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Configuraciones";
			$data['page_name'] = "Configuraciones";
            $data['codigo_empresa'] = 1;
			$data['page_title'] = "Configuraciones <small>". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_configuraciones.js";
			$this->views->GetView($this,"configuraciones",$data);
		}

		public function UpdateEmpresa()
		{
			if(empty($_POST['txtDireccion']))
		   	{
				$arrResponse = array(	'status'=> false,
											'msg'	=> 'Datos incorrectos.');		   	
		   	}else
		   	{

		   		$strDireccion = ucwords(StrClean($_POST['txtDireccion']));
				$intTelefono = intval(StrClean($_POST['txtTelefono']));
                $strCorreoPedidos = ucwords(StrClean($_POST['txtEmailPedidos']));
                $strCorreoEmpresa = ucwords(StrClean($_POST['txtEmailEmpresa']));
                $strNombreRemitente = ucwords(StrClean($_POST['txtNombreRemitente']));
                $strCorreoRemitente= ucwords(StrClean($_POST['txtEmailRemitente']));
                $strNombreEmpresa= ucwords(StrClean($_POST['txtNombreEmpresa']));
                $strNombreAplicacion= ucwords(StrClean($_POST['txtNombreAplicación']));
                $strSitioWeb= ucwords(StrClean($_POST['txtSitioWeb']));
                $strSimboloMoneda= ucwords(StrClean($_POST['txtSimboloMoneda']));
                $strMoneda= ucwords(StrClean($_POST['txtMoneda']));
                $strDivisa= ucwords(StrClean($_POST['txtDivisa']));
                $strSeparfadorDecimal= ucwords(StrClean($_POST['txtSeparadorDecimal']));
                $strSeparadorMilesMillones= ucwords(StrClean($_POST['txtSeparadorMilesMillones']));


					if($_SESSION['permisosMod']['u'])
					{
						$request_user = $this->model->UpdateEmpresa($strDireccion,
																	$intTelefono,
                                                                    $strCorreoPedidos,
                                                                    $strCorreoEmpresa,
                                                                    $strNombreRemitente,
                                                                    $strCorreoRemitente,
                                                                    $strNombreEmpresa,
                                                                    $strNombreAplicacion,
                                                                    $strSitioWeb,
                                                                    $strSimboloMoneda,
                                                                    $strMoneda,
                                                                    $strDivisa,
                                                                    $strSeparfadorDecimal,
                                                                    $strSeparadorMilesMillones																
																	);
					}
		
			

				if($request_user>0)
				{
				
						$arrResponse = array(	'status'=> true,
												'msg'	=> 'Datos actualizados correctamente.');
					
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
		public function GetEmpresa($idempresa)
		{
			if($_SESSION['permisosMod']['r'])
			{
                $empresa = intval($idempresa);
                $arrData = $this->model->SelectEmpresa($empresa);
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
			die();
		}
	}
?>