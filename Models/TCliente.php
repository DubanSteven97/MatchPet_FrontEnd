<?php
require_once("Libraries/Core/Mysql.php");
	trait TCliente
	{
		private $con;

		private $intIdUsuario;
		private $strIdentificacion;
		private $strIdTransaccion;
		private $strNombres;
		private $strApellidos;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intRolId;
		private $intStatus;

		public function InsertClienteT(string $nombres, string $apellidos, int $telefono, string $email, string $password, int $rolId)
		{
			$this->con = new Mysql();

			$this->strNombres = $nombres;
			$this->strApellidos = $apellidos;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intRolId = $rolId;
			$this->intStatus = 1;
			
			$return = 0;
			$sql = "SELECT * FROM persona WHERE
					email_user = '{$this->strEmail}'";
			$request = $this->con->SelectAll($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO persona (nombres, apellidos, telefono, email_user, password, rolid, status) VALUES (?,?,?,?,?,?,?)";
				$arrData = array($this->strNombres,
								$this->strApellidos,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intRolId,
								$this->intStatus
							);
				$request_insert = $this->con->Insert($query_insert, $arrData);
				$return = $request_insert;
			}else
			{
				$return = "exist";
			}
			return $return;
		}

		public function GetIdRolT(string $nombrerol)
		{
			$this->con = new Mysql();
			$sql = "SELECT idrol FROM rol WHERE nombrerol = '$nombrerol'";
			$request = $this->con->Select($sql);
			return $request['idrol'];
		}

		public function InsertPedidoT(string $idtransaccion = NULL, string $datostransaccion = NULL, int $personaid, float $costo_envio, string $monto, int $tipopagoid, string $direccionenvio, string $status)
		{
			$this->con = new Mysql();
			$query_insert = "INSERT INTO pedido (idtransaccion, datostransaccion, personaid, costo_envio, monto, tipopagoid, direccion_envio, status) VALUES (?,?,?,?,?,?,?,?)";
			$arrData = array($idtransaccion, $datostransaccion, $personaid, $costo_envio, $monto, $tipopagoid, $direccionenvio, $status);
			$request_insert = $this->con->Insert($query_insert,$arrData);
			return $request_insert;
		}

		public function InsertDetalle(int $pedidoid, int $productoid, string $precio, int $cantidad)
		{
			$this->con = new Mysql();
			$query_insert = "INSERT INTO detalle_pedido (pedidoid,productoid, precio, cantidad) VALUES (?,?,?,?)";
			$arrData = array($pedidoid, $productoid, $precio, $cantidad);
			$request_insert = $this->con->Insert($query_insert,$arrData);
			return $request_insert;
		}

		public function InsertDetalleTempT(array $pedido)
		{
			$this->intIdUsuario = $pedido['idCliente'];
			$this->strIdTransaccion = $pedido['idTransaccion'];
			$productos = $pedido['productos'];

			$this->con = new Mysql();

			$sql = "SELECT * FROM detalle_temp WHERE transaccionid = '{$this->strIdTransaccion}' AND personaid = {$this->intIdUsuario}";
			$request = $this->con->SelectAll($sql);
			if(empty($request))
			{
				foreach ($productos as $producto) {
					$query_insert = "INSERT INTO detalle_temp(personaid,productoid, precio, cantidad, transaccionid)
									VALUES (?,?,?,?,?)";
					$arrData = array(	$this->intIdUsuario,
										$producto['idproducto'],
										$producto['precio'],
										$producto['cantidad'],
										$this->strIdTransaccion);
					$request_insert = $this->con->Insert($query_insert,$arrData);
				}
			}else
			{
				$query_delete = "DELETE FROM detalle_temp WHERE transaccionid = '{$this->strIdTransaccion}' AND personaid = {$this->intIdUsuario}";
				$request_delete = $this->con->Delete($query_delete);

				foreach ($productos as $producto) {
					$query_insert = "INSERT INTO detalle_temp(personaid,productoid, precio, cantidad, transaccionid)
									VALUES (?,?,?,?,?)";
					$arrData = array(	$this->intIdUsuario,
										$producto['idproducto'],
										$producto['precio'],
										$producto['cantidad'],
										$this->strIdTransaccion);
					$request_insert = $this->con->Insert($query_insert,$arrData);
				}
			}
		}


		public function GetPedido (int $idPedido)
		{
			$this->con = new Mysql();
			$request = array();
			$sql = "SELECT	p.idpedido,
							p.referenciacobro,
							p.idtransaccion,
							p.personaid,
							p.fecha,
							p.costo_envio,
							p.monto,
							p.tipopagoid,
							t.tipopago,
							p.direccion_envio,
							p.status
					FROM	pedido as p
					INNER JOIN tipopago t
					ON 		p.tipopagoid = t.idtipopago
					WHERE	p.idpedido = $idPedido";
			$requestPedido = $this->con->Select($sql);
			if(count($requestPedido)>0)
			{
				$sqlDetalle = "SELECT	p.idproducto,
										p.nombre AS producto,
										d.precio,
										d.cantidad
								FROM	detalle_pedido d
								INNER JOIN producto p
								ON 		d.productoid = p.idproducto
								WHERE	d.pedidoid = $idPedido";
				$requestDetalle = $this->con->SelectAll($sqlDetalle);
				$request = array('orden' => $requestPedido,
								'detalle' => $requestDetalle);
			}
			return $request;
		}
	}
?>