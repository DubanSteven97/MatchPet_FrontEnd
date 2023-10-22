<?php

	class Mysql extends Conexion
	{
		private $conexion;
		private $strQuery;
		private $arrValues;

		function __construct(){
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		public function Insert(string $query, array $arrayValues)
		{
			$this->strQuery = $query;
			$this->arrValues = $arrayValues;
			$insert = $this->conexion->prepare($this->strQuery);
			$resInsert = $insert->execute($this->arrValues);
			if($resInsert)
			{
				$lastInsert = $this->conexion->lastInsertId();
			}
			else
			{
				$lastInsert = 0;
			}
			return $lastInsert;
		}

		public function Select(string $query)
		{
			$this->strQuery = $query;
			$result = $this->conexion->prepare($this->strQuery);
			$result->execute();
			$data = $result->fetch(PDO::FETCH_ASSOC);
			return $data;
		}

		public function SelectAll(string $query)
		{
			$this->strQuery = $query;
			$result = $this->conexion->prepare($this->strQuery);
			$result->execute();
			$data = $result->fetchall(PDO::FETCH_ASSOC);
			return $data;
		}

		public function Update(string $query, array $arrayValues)
		{
			$this->strQuery = $query;
			$this->arrValues = $arrayValues;
			$update = $this->conexion->prepare($this->strQuery);
			$resUpdate = $update->execute($this->arrValues);
			return $resUpdate;
		}

		public function Delete(string $query)
		{
			$this->strQuery = $query;
			$delete = $this->conexion->prepare($this->strQuery);
			$resDelete = $delete->execute();
			return $resDelete;
		}

	}
?>