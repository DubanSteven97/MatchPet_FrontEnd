<?php
	Class Controllers
	{
		public function __construct()
		{
			$this->views = new Views();
			$this->LoadModel();
		}

		public function LoadModel()
		{
			$model = get_class($this)."Model";
			$routClass = "Models/".$model.".php";
			if(file_exists($routClass))
			{
				require_once($routClass);
				$this->model = new $model();
			}
		}
	}

?>