<?php
	class Home extends Controllers
	{
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
			
			$data['page'] = GetPageRout('home');
			if(empty($data['page']))
			{
				header("Location: ".BaseUrl());
			}
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
			$url = APP_URL . "/Animal/GetAnimales/" . $idOrhanizacion;
			$arrData = PeticionGet($url, "application/json", "");
			$ahora = new DateTime(date("Y-m-d"));
		
			$animalesFiltrados = [];
		
			for ($p = 0; $p < count($arrData); $p++) {
				if ($arrData[$p]->estado > 0) {
					$nacimiento = new DateTime($arrData[$p]->fecha_nacimiento);
					$diferencia = $ahora->diff($nacimiento);
					$arrData[$p]->edad = $diferencia->format("%y");
		
					$intidAnimal = $arrData[$p]->idAnimal;
					$url_img = APP_URL . "/Animal/GetImgByAnimal/" . $intidAnimal;
					$requestImg = PeticionGet($url_img, "application/json", "");
		
					if (count($requestImg) > 0) {
						for ($i = 0; $i < count($requestImg); $i++) {
							$requestImg[$i]->url_image = $requestImg[$i]->img;
						}
					}
		
					$arrData[$p]->images = $requestImg;
		
					// Agregar el animal al array resultante
					$animalesFiltrados[] = $arrData[$p];
				}
			}
		
			return $animalesFiltrados;
		}


	}
?>