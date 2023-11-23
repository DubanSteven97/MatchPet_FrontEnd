<?php
	class DashboardModel extends SqlServer
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function CanUsuarios()
		{
			$whereOrg = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$whereOrg = "  AND idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			$sql = "SELECT COUNT(*) total FROM Persona WHERE estado != 0".$whereOrg;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanClientes()
		{
			$sql = "SELECT COUNT(*) total FROM Persona WHERE estado != 0 AND idRol = (SELECT idRol FROM Rol WHERE nombrerol = 'Cliente');";
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanAnimales()
		{
			$whereOrg = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$whereOrg = "  AND idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			$sql = "SELECT COUNT(*) total FROM Animal WHERE estado != 0".$whereOrg;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanOrganizaciones()
		{
			$sql = "SELECT COUNT(*) total FROM organizacion WHERE estado != 0";
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanAdopciones()
		{
			$whereOrg = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$whereOrg = "  AND idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			$sql = "SELECT COUNT(*) total FROM procesoadopcion WHERE estado != 0".$whereOrg;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanPedidos($idPersona = null)
		{
			$where = "";
			if($idPersona != null)
			{
				$where = " WHERE	personaid = ".$idPersona;
			}

			$sql = "SELECT COUNT(*) total FROM Apadrinamiento ". $where;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		/*public function LastOrders($idPersona = null)
		{
			$where = "";
			if($idPersona != null)
			{
				$where = " WHERE	p.personaid = ".$idPersona;
			}
			$sql = "SELECT p.idpedido, CONCAT(pr.nombres, ' ', pr.apellidos) as nombre,
					p.monto, p.status FROM pedido p
					INNER JOIN persona pr
					ON p.personaid = pr.idpersona
					".$where. "
					ORDER BY p.idpedido DESC LIMIT 10";
			$request = $this->SelectAll($sql);
			return $request;
		}*/

		public function SelectAdopcionesMes(int $anio, int $mes, $idOrganizacion)
		{
			$where = "WHERE 1=1 ";
			if($idOrganizacion != null)
			{
				$where = " WHERE idOrganizacion = ".$idOrganizacion;
			}
			$sql = "SELECT	
							CASE estado
								WHEN 1 THEN 'En proceso'
								WHEN 3 THEN 'Aprobados'
								WHEN 4 THEN 'Rechazados'
								ELSE 'Desconocido'
							END AS nombre_estado, 
					        COUNT(estado) as adopcion 
					FROM procesoAdopcion  
					".$where." AND MONTH(fecha_solicitud) = $mes AND YEAR(fecha_solicitud) = $anio 
					GROUP BY estado";
			$adopciones = $this->SelectAll($sql);
			$arrData = array('anio'=>$anio, 'mes'=>Meses()[$mes-1], 'adopciones'=>$adopciones);
			return $arrData;
	
		}

		public function SelectAdopcionesPorMes( int $anio,$idOrganizacion)
		{
			$where = "WHERE 1=1 ";
			if($idOrganizacion != null)
			{
				$where = " WHERE idOrganizacion = ".$idOrganizacion;
			}
			$sql = "SELECT	
							FORMAT(fecha_solicitud, 'MMMM', 'es-es') mes,
					        COUNT(*) as adopcion 
					FROM procesoAdopcion  
					".$where." AND estado = 3 AND YEAR(fecha_solicitud) = $anio 
					GROUP BY FORMAT(fecha_solicitud, 'MMMM', 'es-es')";
			$adopcionesPorMes = $this->SelectAll($sql);
			$arrData = array( 'adopcionesPorMes'=>$adopcionesPorMes);
			return $arrData;
	
		}		

		public function SelectAdopcionesPorAno( $idOrganizacion)
		{
			$where = "WHERE 1=1 ";
			if($idOrganizacion != null)
			{
				$where = " WHERE idOrganizacion = ".$idOrganizacion;
			}
			$sql = "SELECT	
							YEAR(fecha_solicitud) ano,
					        COUNT(*) as adopcion 
					FROM procesoAdopcion  
					".$where." AND estado = 3 
					GROUP BY YEAR(fecha_solicitud)";
			$adopcionesPorMes = $this->SelectAll($sql);
			$arrData = array( 'adopcionesPorAno'=>$adopcionesPorMes);
			return $arrData;
	
		}	
	}

?>