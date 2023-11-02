<?php
	class Animales extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Animales');
		}
		public function Animales()
		{
			if(empty($_SESSION['permisosMod']['r']))
			{
				header('Location: ' . BaseUrl(). '/AccesoRestringido');
			}
			$data['page_tag'] ="Animales";
			$data['page_name'] = "animales";
			$data['page_title'] = "Animales<small> ". NombreApp()."</smal>";
			$data['page_functions_js'] = "functions_animales.min.js";
			$this->views->GetView($this,"animales",$data);
		}


	}
?>