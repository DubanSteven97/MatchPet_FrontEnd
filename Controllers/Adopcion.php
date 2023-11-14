<?php
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");
	require_once("Models/TTipoPago.php");
	require_once("Models/TCliente.php");
	class Adopcion extends Controllers
	{
		use TCategoria, TProducto, TTipoPago, TCliente;
		public function __construct()
		{
			parent::__construct();
			session_start();
		}

		public function Adopcion()
		{
			$data['page_tag'] = NOMBRE_EMPRESA. ' - Adopción';
			$data['page_title'] = 'Proceso de Adopción';
			$data['page_name'] = "adopcion";
			$this->views->GetView($this,"ProcesarAdopcion",$data);
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