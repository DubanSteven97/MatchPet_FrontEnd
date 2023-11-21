<?php


	const HOST = "matchpetucentral.online";
	const BASE_URL = "https://".HOST."/MatchPet";
	const BASE_URL_H = HOST."/MatchPet";

	date_default_timezone_set('America/Bogota');

	const DRIVER_SQL ="sqlsrv:server";
	const DATABASE="DBMatchpet";
	const PORT="1433";
	const HOSTNAME="matchpetucentral.online";
	const USERNAME="MatchPet";
	const PASSWORD= "Prueba123456+";

	const APP_URL = "http://matchpetucentral.online:8081/Matchpet";
	const APP_NAME = "MatchpetDEV";
	const APP_US = "devmatchpet";
	const APP_PS = "147852";


	const SPD = ",";
	const SPM = ".";

	const SMONEY = "$";
	const CURRENCY = "USD";
	const MONEDA = "COP";

	const NOMBRE_REMITENTE = "MatchPet";
	const EMAIL_REMITENTE = "info@MatchPet.com";
	const NOMBRE_EMPRESA = "MatchPet";
	const NOMBRE_APP = "MatchPet";
	const WEB_EMPRESA = "www.MatchPet.com";

	const DIRECCION_EMPRESA = "Calle Siempre Viva 123, Bogotá DC, Colombia";
	const TELEFONO_EMPRESA = "+(57)320 3997016";
	const EMAIL_PEDIDOS = "info@MatchPet.com";
	const EMAIL_EMPRESA = "info@MatchPet.com";

	const CAT_SLIDER = "7,2,3";
	const CAT_BANNER = "6,5,8";

	const KEY = 'jusebema';
	const METHODENCRIPT = "AES-128-ECB";

	const COSTOENVIO = 500;
	const VALORIVA = 19;


	const URLMERCADOPAGO = "https://api.mercadopago.com";
	const ACCESSTOKENMERCADOPAGO = "TEST-6005038764479624-111417-0561622cb25160efc80af1e5877758da-383773505";
	const KEYPUBLICMERCADOPAGO = "TEST-4fa157c6-2e2d-4f14-a67b-d5aae08b08a1";
	const IDAPPMERCADOPAGO = "4889927137089308";
	const SECRETAPPMERCADOPAGO = "R3FI1VJetdTT84vfuY888xeNzEVdOmZf";
	const URLGETPAYMENTMP = URLMERCADOPAGO."/v1/payments/";
	const URLGETORDENMP = URLMERCADOPAGO."/merchant_orders/";
	const URLREENVOLSOMP = "/refunds";

	const SHAREDHASH = "AdoptaNoCompres";

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

?>