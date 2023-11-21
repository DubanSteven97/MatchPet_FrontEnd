<?php
	class ContactoModel extends Mysql
	{
		public function SetContacto(string $nombre, string $email, string $mensaje, string $ip, string $dispositivo, string $userAgent)
		{
			$nombre = $nombre != "" ? $nombre : "";
			$email = $email != "" ? $email : "";
			$mensaje = $mensaje != "" ? $mensaje : "";
			$ip = $ip != "" ? $ip : "";
			$dispositivo = $dispositivo != "" ? $dispositivo : "";
			$userAgent = $userAgent != "" ? $userAgent : "";

			$query_insert = "INSERT INTO contacto (nombre, email, mensaje, ip, dispositivo, useragent) VALUES (?,?,?,?,?,?)";
			$arrData = array($nombre,$email,$mensaje,$ip,$dispositivo,$userAgent);
			$request_insert = $this->Insert($query_insert,$arrData);
			return $request_insert;
		}
	}
?>