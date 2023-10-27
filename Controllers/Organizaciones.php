<?php
	class Organizaciones extends Controllers
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
			$data['page_tag'] ="Organizaciones";
			$data['page_name'] = "organizaciones";
			$data['page_title'] = "Organizaciones<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_Organizaciones.min.js";
			$this->views->GetView($this,"organizaciones",$data);
		}



		public function GetSelectOrganizaciones()
		{
			$htmlOptions = "";
			$arrData = $this->model->SelectOrganizaciones();
			if(count($arrData) > 0)
			{
				for($i=0;$i<count($arrData);$i++)
				{
					if($arrData[$i]['estado'] == 1)
					{
						$htmlOptions .= '<option value="'.$arrData[$i]['idOrganizacion'].'"> '.$arrData[$i]['nombre'].' </option>';
					}
				}
			}
			echo $htmlOptions;
			die();
		}
	}
?>