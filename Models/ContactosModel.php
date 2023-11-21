<?php
	class ContactosModel extends Mysql
	{
		public function SelectContactos()
		{	
			$sql = "SELECT id, nombre, email, datecreated as fecha 
					FROM contacto ORDER BY id DESC";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectContacto(int $idMensaje)
		{	
			$sql = "SELECT id, nombre, email, datecreated as fecha, mensaje 
					FROM contacto WHERE id = {$idMensaje}";
			$request = $this->Select($sql);
			return $request;
		}
	}
?>