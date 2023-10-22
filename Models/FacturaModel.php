<?php
	class FacturaModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

		public function SelectPedido(int $idPedido, $idPersona = null)
		{
			$and = "";
			if($idPersona != null)
			{
				$and = " AND	p.personaid = ".$idPersona;
			}
			$this->intIdPedido = $idPedido;

			$request = array();
			$sql = "SELECT	p.idpedido,
							p.referenciacobro,
							p.idtransaccion,
							p.personaid,
							DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha,
							p.costo_envio,
							p.monto,
							p.tipopagoid,
							t.tipopago,
							p.direccion_envio,
							p.status
					FROM	pedido as p
					INNER JOIN tipopago t
					ON 		p.tipopagoid = t.idtipopago
					WHERE 	p.idpedido = $this->intIdPedido $and";
			$requestPedido = $this->Select($sql);
			if (!empty($requestPedido)) 
			{
				$idPersona = $requestPedido['personaid'];
				$sqlCliente = "SELECT 	idpersona, 
										nombres, 
										apellidos, 
										telefono,
										email_user,
										nit,
										nombrefiscal,
										direccionfiscal
								FROM	persona
								WHERE	idpersona = $idPersona";
				$requestCliente = $this->Select($sqlCliente);
				$sqlDetalle = "SELECT	p.idproducto,
										p.nombre AS producto,
										d.precio,
										d.cantidad
								FROM	detalle_pedido d
								INNER JOIN producto p
								ON 		d.productoid = p.idproducto
								WHERE	d.pedidoid = $idPedido";				
				$requestDetalle = $this->SelectAll($sqlDetalle);

				$request = array('cliente' => $requestCliente,
								'orden' => $requestPedido,
								'detalle' => $requestDetalle);								
			}
			return $request;
		}
	}

?>