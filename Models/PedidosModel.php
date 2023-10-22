<?php
	class PedidosModel extends Mysql
	{
		private $intIdPedido;
		private $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function SelectPedidos($idPersona = null)
		{
			$where = "";
			if($idPersona != null)
			{
				$where = " WHERE	p.personaid = ".$idPersona;
			}
			$sql = "SELECT 	p.idpedido, 
							p.referenciacobro, 
							p.idtransaccion, 
							DATE_FORMAT(p.fecha, '%d/%m/%Y') as fecha, 
							p.monto, 
							tp.tipopago,
							tp.idtipopago,
							p.status
					FROM 		pedido p
					INNER JOIN	tipopago tp 
					ON 		p.tipopagoid = tp.idtipopago $where";
			$request = $this->SelectAll($sql);
			return $request;
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

		public function SelectTransaccionPaypal(string $idtransaccion, $idPersona = null)
		{
			$and = "";
			if($idPersona != null)
			{
				$and = " AND	personaid = ".$idPersona;
			}
			$obTransaccion = array();
			$sql = "SELECT	datostransaccion
					FROM	pedido
					WHERE	idtransaccion = '{$idtransaccion}' $and";
			$requestData = $this->Select($sql);
			if(!empty($requestData))
			{
				$objData = json_decode($requestData['datostransaccion']);
				$urlTransaccion = URLGETPAYMENTPP.$idtransaccion;
				$urlOrden = $objData->links[0]->href;
				$objTransaccion = CurlConnectionGet($urlOrden, "application/json", GetTokenPayPal());
				$objTransaccion->transaccion = "";
			}
			return $objTransaccion;
		}

		public function SelectTransaccionMercadoPago(string $idtransaccion, $idPersona = null)
		{
			$and = "";
			if($idPersona != null)
			{
				$and = " AND	personaid = ".$idPersona;
			}
			$obTransaccion = array();
			$sql = "SELECT	datostransaccion
					FROM	pedido
					WHERE	idtransaccion = '{$idtransaccion}' $and";
			$requestData = $this->Select($sql);
			if(!empty($requestData))
			{
				$objData = json_decode($requestData['datostransaccion']);
				$urlTransaccion = URLGETPAYMENTMP.$idtransaccion;
				$urlOrden = URLGETORDENMP.$objData->order->id;
				$objTransaccion = CurlConnectionGet($urlOrden, "application/json", ACCESSTOKENMERCADOPAGO);
				$objTransaccion->transaccion = $objData;
				$urlReembolso = URLGETPAYMENTMP.$objData->id.URLREENVOLSOMP;
				$objReembolso = CurlConnectionGet($urlReembolso, "application/json", ACCESSTOKENMERCADOPAGO);
				$objTransaccion->reembolso = $objReembolso;
			}
			return $objTransaccion;
		}

		public function Reembolso(string $idtransaccion, string $observacion)
		{
			$response = false;
			$sql = "SELECT p.idpedido, p.datostransaccion, tp.tipopago FROM pedido p INNER JOIN tipopago tp ON tp.idtipopago = p.tipopagoid WHERE p.idtransaccion = '{$idtransaccion}'";
			$requestData = $this->Select($sql);
			if(!empty($requestData))
			{
				$objData = json_decode($requestData['datostransaccion']);
				if($requestData['tipopago'] == 'PayPal')
				{
					$urlReembolso = URLGETPAYMENTPP.$idtransaccion.URLREENVOLSOPP;
					$objReembolso = CurlConnectionPost($urlReembolso, "application/json", GetTokenPayPal());
				}
				if($requestData['tipopago'] == 'Mercado Pago')
				{
					$urlReembolso = URLGETPAYMENTMP.$objData->id.URLREENVOLSOMP;
					$objReembolso = CurlConnectionPost($urlReembolso, "application/json", ACCESSTOKENMERCADOPAGO);
				}
				if(isset($objReembolso->status) and ($objReembolso->status == "COMPLETED" || $objReembolso->status == "approved"))
				{
					$idpedido = $requestData['idpedido'];
					$idtransaccion = $objReembolso->id;
					$status = $objReembolso->status;
					$jsonData = json_encode($objReembolso);
					$queryInsert = "INSERT INTO reembolso (pedidoid, idtransaccion, datosreembolso, observacion, status)
									VALUES (?,?,?,?,?)";
					$arrData = array($idpedido,$idtransaccion,$jsonData,$observacion,$status);
					$requestInsert = $this->Insert($queryInsert,$arrData);
					if($requestData>0)
					{
						$updatePedido = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
						$arrPedido = array("Reembolsado");
						$request = $this->Update($updatePedido, $arrPedido);
						$response = true;
					}
				}
				return $response;
			}
		}

		public function UpdatePedido(int $idpedido, $transaccion = NULL, $idtipopago = NULL, string $estado)
		{
			if($transaccion == NULL)
			{
				$queryUpdate = "UPDATE pedido SET status = ? WHERE idpedido = $idpedido";
				$arrData = array($estado);
			}else
			{
				$queryUpdate = "UPDATE pedido SET referenciacobro = ?, tipopagoid = ?, status = ? WHERE idpedido = $idpedido";
				$arrData = array($transaccion,$idtipopago,$estado);
			}
			$requestUpdate = $this->Update($queryUpdate, $arrData);
			return $requestUpdate;
		}
	}
?>