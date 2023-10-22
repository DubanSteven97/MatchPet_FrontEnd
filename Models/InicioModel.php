<?php
	class InicioModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function GetValor()
		{
			return array("1" => "hola", "2" => "chao");
		}
	}

?>