<?php
	class Inicio extends Controllers{

		public function __construct()
		{
			parent::__construct();
		}

		public function Inicio()
		{
			$data['variable'] = $this->model->GetValor();
			$this->views->getView($this,"inicio",$data);
		}
	}
?>