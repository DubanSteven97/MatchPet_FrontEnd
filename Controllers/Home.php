<?php
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	class Home extends Controllers
	{
		use TCategoria, TProducto;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}
		public function Home()
		{
			$data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "elbuensamaritano";
			$data['slider'] = $this->GetCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->GetCategoriasT(CAT_BANNER);
			$data['productos'] = $this->GetProductosT();
			$this->views->GetView($this,"home",$data);
		}


	}
?>