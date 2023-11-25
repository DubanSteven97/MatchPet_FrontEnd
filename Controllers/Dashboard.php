<?php
	class Dashboard extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Dashboard');
		}
		public function dashboard()
		{

			$idPersona = "";
			if($_SESSION['userData']['nombreRol'] == "Amigo")
			{
				$idPersona = $_SESSION['userData']['idPersona'];
			}

			$data['page_id'] = 2;
			$data['page_tag'] ="Dashboard";
			$data['page_name'] = "dashboard";
			$data['page_title'] = "Dashboard <small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_dashboard.min.js";
			$data['usuarios'] = $this->model->CanUsuarios();
			$data['clientes'] = $this->model->CanClientes();
			$data['animales'] = $this->model->CanAnimales();
			$data['organizaciones'] = $this->model->CanOrganizaciones();
			$data['adopciones'] = $this->model->CanAdopciones($idPersona);
			$data['donaciones'] = $this->model->CanDonaciones($idPersona);
			$data['lastDonaciones'] = $this->model->LastDonaciones($idPersona);

			$anio = date('Y');
			$mes = date('m');
			$idOrganizacion = $_SESSION['userData']['idOrganizacion'];
		
			$data['donacionesMDia'] = $this->model->SelectDonacionesMes($anio,$mes);
			$data['donacionesAnio'] = $this->model->SelectDonacionesAnio($anio);

			$data['adopcionesMes'] = $this->model->SelectAdopcionesMes($anio,$mes,$idOrganizacion);
			$data['adopcionesPorMes'] = $this->model->SelectAdopcionesPorMes($anio,$idOrganizacion);
			$data['adopcionesPorAno'] = $this->model->SelectAdopcionesPorAno($idOrganizacion);
			//dep($data['pagosMes']);exit();

			$this->views->GetView($this,"dashboard",$data);
		}

		public function DonacionesMes(){
			if($_POST)
			{
				$grafica = "donacionesMes";
				$nFecha = str_replace(" ","",$_POST['fecha']);
				$arrFecha = explode('-',$nFecha);
				$mes = $arrFecha[0];
				$anio = $arrFecha[1];
				$pagos = $this->model->SelectDonacionesMes($anio,$mes);
				$pagos['grafica'] = $grafica;
				$script = GetFile("Template/Modals/graficas",$pagos);
				echo $script;
				die();
			}
		}
	}
?>