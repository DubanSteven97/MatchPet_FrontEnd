<?php

	class Views
	{
		function GetView($controller, $view, $data="")
		{
			$view = ucwords($view);
			$controller = get_class($controller);
			if($controller == "Home")
			{
				$view = "Views/".$view.".php";
			}else
			{
				$view = "Views/".$controller."/".$view.".php";
			}
			require_once($view);
		}
	}
?>