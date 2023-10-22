<?php
	class DashboardModel extends SqlServer
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function CanUsuarios()
		{
			$sql = "SELECT COUNT(*) total FROM Persona WHERE estado != 0";
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

		public function CanProductos()
		{
			$sql = "SELECT COUNT(*) total FROM Animal WHERE estado != 0";
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

		/*public function SelectPagosMes(int $anio, int $mes, $idPersona = null)
		{
			$where = "WHERE 1=1 ";
			if($idPersona != null)
			{
				$where = " WHERE	p.personaid = ".$idPersona;
			}
			$sql = "SELECT	p.tipopagoid, 
							tp.tipopago, 
					        COUNT(p.tipopagoid) as cantidad, 
					        SUM(p.monto) as total 
					FROM pedido p 
					INNER JOIN tipopago tp ON p.tipopagoid = tp.idtipopago 
					".$where." AND MONTH(p.fecha) = $mes AND YEAR(p.fecha) = $anio 
					GROUP BY p.tipopagoid";
			$pagos = $this->SelectAll($sql);
			$arrData = array('anio'=>$anio, 'mes'=>Meses()[$mes-1], 'tipospago'=>$pagos);
			return $arrData;
		}*/
	}

?>