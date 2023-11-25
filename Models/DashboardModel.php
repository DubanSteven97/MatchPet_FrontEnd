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

		public function CanAdopciones($idPersona = null)
		{
			$whereOrg = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$where = "  AND idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			if($idPersona != null)
			{
				$where = " AND	idPersona = ".$idPersona;
			}
			$sql = "SELECT COUNT(*) total FROM procesoadopcion WHERE estado != 0".$whereOrg;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function CanDonaciones($idPersona = null)
		{
			$where = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$where = "  AND idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			if($idPersona != null)
			{
				$where = " AND	idPersona = ".$idPersona;
			}

			$sql = "SELECT COUNT(*) total FROM Donacion WHERE 1=1 ". $where;
			$request = $this->Select($sql);
			$total = $request['total'];
			return $total;
		}

		public function LastDonaciones($idPersona = null)
		{
			$where = "";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$where = "  AND d.idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			if($idPersona != null)
			{
				$where = " AND	d.idPersona = ".$idPersona;
			}

			$sql = "SELECT TOP 10	d.idDonacion, CONCAT(p.nombres, ' ', p.apellidos) as nombre, o.nombre as Organizacion, d.monto, d.estado
					FROM donacion d
					INNER JOIN persona p
					ON p.idPersona = d.idPersona
					INNER JOIN Organizacion o
					ON o.idOrganizacion = d.idOrganizacion
					WHERE 1=1
					".$where. "
					ORDER BY d.idDonacion DESC";
			$request = $this->SelectAll($sql);
			return $request;
		}

		public function SelectDonacionesMes(int $anio, int $mes)
		{
			$where = "";
			$rol = $_SESSION['userData']['nombreRol'];
			if($_SESSION['userData']['nombreRol'] == "Amigo")
			{
				$idUser = $_SESSION['userData']['idPersona'];
			}
			
			if($rol == 'Amigo')
			{
				$where = " AND d.idPersona = ". $idUser;
			}
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$where = "  AND d.idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			$totalDonacionesMes = 0;
			$arrDonacionesDias = array();
			$dias = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
			$n_dia = 1;
			for ($i=0; $i < $dias; $i++) { 
				$date = date_create($anio.'-'.$mes.'-'.$n_dia);
				$fechaDonacion = date_format($date, "Y-m-d");

				$sql = "SELECT	DAY(d.fecha) as dia,
								COUNT(d.idDonacion) as cantidad, 
								SUM(d.monto) as total 
						FROM donacion d 
						WHERE MONTH(d.fecha) = $mes
						AND		YEAR(d.fecha) = $anio
						AND		DAY(d.fecha) = $n_dia
						AND		d.estado in ('Completo', 'Aprobado')
					".$where." GROUP BY DAY(d.fecha)";
				$DonacionDia = $this->Select($sql);
				if(empty($DonacionDia))
				{
					$DonacionDia['dia'] = $n_dia;
					$DonacionDia['cantidad'] = 0;
					$DonacionDia['total'] = 0;
				}
				
				$totalDonacionesMes += $DonacionDia['total'];
				
				array_push($arrDonacionesDias, $DonacionDia);
				$n_dia++;
			}	
			$arrData = array('anio'=>$anio, 'mes'=>Meses()[$mes-1], 'total' => $totalDonacionesMes, 'donacion'=>$arrDonacionesDias);
			return $arrData;
		}

		public function SelectDonacionesAnio(int $anio)
		{
			$arrMDonaciones = array();
			$arrMeses = Meses();
			$where ="";
			if($_SESSION['userData']['idOrganizacion'] != null)
			{
				$where = "  AND d.idOrganizacion = ".$_SESSION['userData']['idOrganizacion'];
			}
			for ($i=1; $i <= 12; $i++) { 

				$sql = "SELECT MONTH(d.fecha) as mes, SUM(d.monto) as donacion 
					FROM donacion d 
					WHERE MONTH(d.fecha) = $i AND YEAR(d.fecha) = $anio 
					AND		d.estado in ('Completo', 'Aprobado')".$where."
					GROUP BY MONTH(d.fecha)";

				$donacionesMes = $this->Select($sql);
				$arrData['mes'] = $arrMeses[$i-1];
				if(empty($donacionesMes))
				{
					$arrData['no_mes'] = $i;
					$arrData['donacion'] = 0;
				}else
				{
					$arrData['no_mes'] = $donacionesMes['mes'];
					$arrData['donacion'] = $donacionesMes['donacion'];
				}
				array_push($arrMDonaciones, $arrData);
			}
			$arrData = array('anio'=>$anio, 'meses' => $arrMDonaciones);
			return $arrData;
		}

		public function SelectAdopcionesMes(int $anio, int $mes, $idOrganizacion)
		{
			$where = "";

			$rol = $_SESSION['userData']['nombreRol'];
			if($_SESSION['userData']['nombreRol'] == "Amigo")
			{
				$idUser = $_SESSION['userData']['idPersona'];
			}
			
			if($rol == 'Amigo')
			{
				$where = " AND idPersona = ". $idUser;
			}

			if(!empty($idOrganizacion))
			{
				$where = " AND idOrganizacion = ".$idOrganizacion;
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
					WHERE 1=1  
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