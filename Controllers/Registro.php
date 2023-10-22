<?php
	class Registro extends Controllers{


		public function __construct()
		{
			parent::__construct();
		}

		public function Registro()
		{
			$data['page_tag'] ="Registro ". NombreApp()."</smal>";
			$data['page_title'] = "Registro ". NombreApp()."</smal>";
			$data['page_name'] = "Registro";
			$data['page_functions_js'] = "functions_register_user.js";
			$this->views->getView($this,"registro",$data);
		}

		public function createdUser(int $identificacion, string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId, int $status)
		{
			$requestCreateUser = $this->model->InsertUsuario($identificacion, $nombres, $apellidos, $telefono,$email, $password, $rolId, $status);
		}		

	}
?>