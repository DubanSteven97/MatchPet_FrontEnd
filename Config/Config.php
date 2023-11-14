<?php

#	const HOST = "matchpetucentral.online";
	const HOST = "localhost:80";
	const BASE_URL = "http://".HOST."/MatchPet";
	const BASE_URL_H = HOST."/MatchPet";

	date_default_timezone_set('America/Bogota');

		#ENVIROMENT DEV
#	const DRIVER_SQL ="sqlsrv:server";
#	const DATABASE="DBMatchpet";
#	const PORT="10060";
#	const HOSTNAME="DESKTOP-UIAKGPT";
#	const USERNAME="root";
#	const PASSWORD= "123456";

#	const APP_URL = "https://localhost:7176/Matchpet";
#	const APP_NAME = "MatchpetDEV";
#	const APP_US = "devmatchpet";
#	const APP_PS = "147852";

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


	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const IDCLIENTEPAYPAL = "AcC2eApkOGCPo2k03LryQEkZJXIGEzC_UD-Xh8AedUUmLOIImINbEMkChJjAaexBTLgvRXb0IkUMlLET";
	const SECRETCLIENTEPAYPAL = "EO0IGxZBSKMHrrWJdsQysPwLDShcZkdU9xSH536bIdz_u2HuCPD5uz7JojS-YOkXF7oi_NhLlupNrybJ";
	const URLGETPAYMENTPP = URLPAYPAL."/v2/payments/captures/";
	const URLGETORDENPP =URLPAYPAL."/v2/checkout/orders/";
	const URLREENVOLSOPP = "/refund";

	const URLMERCADOPAGO = "https://api.mercadopago.com";
	const ACCESSTOKENMERCADOPAGO = "TEST-530799249801378-101016-f19e98f43d54b91941e72dc3ea42ad11-383773505";
	const KEYPUBLICMERCADOPAGO = "TEST-eac798f6-f505-491b-9bc3-f35cbfbb4bd8";
	const IDAPPMERCADOPAGO = "4889927137089308";
	const SECRETAPPMERCADOPAGO = "R3FI1VJetdTT84vfuY888xeNzEVdOmZf";
	const URLGETPAYMENTMP = URLMERCADOPAGO."/v1/payments/";
	const URLGETORDENMP = URLMERCADOPAGO."/merchant_orders/";
	const URLREENVOLSOMP = "/refunds";

	const SHAREDHASH = "AdoptaNoCompres";

	const KEYTASACAMBIO = "Z1rthZIKB8xx7we6m44l4ImeXXoxQAVg";

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

?>