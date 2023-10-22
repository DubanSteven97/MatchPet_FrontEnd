<?php
	require 'Libraries/html2pdf/vendor/autoload.php';
	use Spipu\Html2Pdf\Html2Pdf;
	class Factura extends Controllers
	{
		public function __construct()
		{
			SessionStart();
			parent::__construct();
			if(empty($_SESSION['login']))
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			GetPermisos('Pedidos');
		}
		public function GenerarFactura($idpedido)
		{
			if($_SESSION['permisosMod']['r']){
				if(is_numeric($idpedido))
				{
					$idpersona = "";
					if($_SESSION['userData']['nombrerol'] == "Cliente")
					{

						$idpersona = $_SESSION['userData']['idpersona'];
					}
					$data = $this->model->SelectPedido($idpedido, $idpersona);
					if(empty($data)){
						echo "Datos no encontrados.";
					}else{
						$idpedido = $data['orden']['idpedido'];
						ob_end_clean();
						$html = GetFile("Template/PDFs/ComprobantePDF", $data);
						$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
						$html2pdf->writeHTML($html);
						$html2pdf->output('factura-'.$idpedido.'.pdf');
					}
				}else
				{
					echo "Dato no válido";
				}
			}else
			{
				header('Location: ' . BaseUrl(). '/login');
			}
			die();
		}

	}
?>