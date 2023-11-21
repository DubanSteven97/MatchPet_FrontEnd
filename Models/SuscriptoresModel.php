<?php
	class SuscriptoresModel extends Mysql
	{
		public function SelectSuscriptores()
		{	
			$sql = "SELECT idsuscripcion, nombre, email, datecreated as fecha FROM suscripciones ORDER BY idsuscripcion DESC";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SetSuscripcion(string $nombre, string $email)
		{
			$sql = "SELECT * FROM suscripciones WHERE email = '{$email}'";
			$request = $this->SelectAll($sql);
			if(empty($request))
			{
				$query_insert = "INSERT INTO suscripciones (nombre, email) VALUES (?,?)";
				$arrData = array($nombre,$email);
				$request_insert = $this->Insert($query_insert,$arrData);
				$return = $request_insert;
			}
			else
			{
				$return = false;
			}
			return $return;
		}
	}
?>