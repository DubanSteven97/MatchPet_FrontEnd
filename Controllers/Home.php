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
			$data['page_name'] = "matchpet";
			$arrTipoAnimales = $this->GetTipoAnimales();
			$data['slider'] = $arrTipoAnimales;
			$data['banner'] = $arrTipoAnimales;
			$data['animales'] = $this->GetAnimales();
			$this->views->GetView($this,"home",$data);
		}

		public function GetTipoAnimales()
		{
			$url = APP_URL."/TipoAnimal/GetTipoAnimales";
			$arrData = PeticionGet($url, "application/json", "");
			return $arrData;
		}

		public function GetAnimales()
		{
			$idOrhanizacion = 0;
			$url = APP_URL."/Animal/GetAnimales/".$idOrhanizacion;
			$arrData = PeticionGet($url, "application/json", "");
			for($p=0;$p<count($arrData);$p++){
				$intidAnimal = $arrData[$p]->idAnimal; 
				$url_img = APP_URL."/Animal/GetImgByAnimal/".$intidAnimal;
				$requestImg = PeticionGet($url_img, "application/json", "");
				if(count($requestImg)>0)
				{
					for ($i=0; $i < count($requestImg); $i++) { 
						$requestImg[$i]->url_image = $requestImg[$i]->img;
					}
				}
				$arrData[$p]->images = $requestImg;
				
			}

			return $arrData;
		}


	}
?>