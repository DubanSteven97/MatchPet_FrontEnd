<?php
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TTipoPago.php");
	require_once("Models/TCliente.php");
	class Carrito extends Controllers
	{
		use TCategoria, TProducto, TTipoPago, TCliente;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function Carrito()
		{
			$data['page_tag'] = NOMBRE_EMPRESA. ' - Carrito';
			$data['page_title'] = 'Carrito de Compras';
			$data['page_name'] = "carrito";
			$this->views->GetView($this,"carrito",$data);
		}

		public function ProcesarPago()
		{
			if(empty($_SESSION['arrCarrito']))
			{
				header("Location: ".BaseUrl());
				die();
			}
			/*if(isset($_SESSION['login'])){
				$this->SetDetalleTemp();
			}*/		
			$data['page_tag'] = NOMBRE_EMPRESA. ' - Procesar Pago';
			$data['page_title'] = 'Procesar Pago';
			$data['page_name'] = "procesarpago";
			$data['tiposPago'] = $this->getTiposPagosT();
			$this->views->GetView($this,"procesarpago",$data);
		}

		/*public function SetDetalleTemp(){
			$sid = session_id();

			$arrPedido = array(	'idCliente' => $_SESSION['idUser'],
								'idTransaccion' => $sid,
								'productos' => $_SESSION['arrCarrito']
								);

			$this->InsertDetalleTempT($arrPedido);
		}*/
	}
?>