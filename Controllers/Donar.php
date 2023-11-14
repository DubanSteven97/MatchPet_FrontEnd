<?php

	require_once("Models/LoginModel.php");
	class Donar extends Controllers
	{
		public $login;
		public function __construct()
		{
			session_start();
			parent::__construct();
			$this->login = new LoginModel();
		}
		public function Donar()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "donar";
			//$data['animales'] = $this->GetAnimales();
			$data['page'] = GetPageRout('donar');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			$this->views->GetView($this,"donar",$data);
		}
    }
?>
