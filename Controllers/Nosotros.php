<?php
	class Nosotros extends Controllers
	{
		public function __construct()
		{
			parent::__construct();
			session_start();
			GetPermisos('Paginas');
		}
		public function Nosotros()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "matchpet";
			$data['page'] = GetPageRout('nosotros');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
			$this->views->GetView($this,"nosotros",$data);
		}


	}
?>