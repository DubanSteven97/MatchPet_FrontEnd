<?php

	require_once("Models/LoginModel.php");
	class Apadrinar extends Controllers
	{
		public $login;
		public function __construct()
		{
			session_start();
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Apadrinar()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "apadrinar";
			//$data['animales'] = $this->GetAnimales();
			$data['page'] = GetPageRout('apadrinar');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			$this->views->GetView($this,"apadrinar",$data);
		}
    }
?>
