<?php

	function BaseUrl()
	{
		return BASE_URL;
	}
	function NombreApp()
	{
    	require_once('Models/ConfiguracionesModel.php');
    	$nombreApp = new ConfiguracionesModel();
    	$idEmpresa = 1;
    	$arrConfiguraciones = $nombreApp->DatosCorreo($idEmpresa);
        return  $arrConfiguraciones["nombre_aplicacion"];
	}



	function contactoWshatsapp()
	{
    	require_once('Models/ConfiguracionesModel.php');
    	$nombreApp = new ConfiguracionesModel();
    	$idEmpresa = 1;
    	$arrConfiguraciones = $nombreApp->DatosEmpresa($idEmpresa);
        return ("https://wa.me/".$arrConfiguraciones['telefono']."?text=¡Hola!%20Quisiera%20saber%20sobre%20mi%20pedido");
	}
	function Media(){
		return BASE_URL."/Assets";
	}

	function HeaderAdmin($data="")
	{
		$view_header = "Views/Template/header_admin.php";
		require_once($view_header);
	}
	
	function FooterAdmin($data="")
	{
		$view_footer = "Views/Template/footer_admin.php";
		require_once($view_footer);
	}

	function HeaderHome($data="")
	{
		$view_header = "Views/Template/header_Home.php";
		require_once($view_header);
	}
	
	function FooterHome($data="")
	{
		$view_footer = "Views/Template/footer_Home.php";
		require_once($view_footer);
	}
	function Dep($data)
	{
		$format  = print_r('<pre>');
		$format .= print_r($data);
		$format .= print_r('</pre>');
		return $format;
	}

	function GetModal(string $nameModal, $data)
	{
		$viewModal = "Views/Template/Modals/{$nameModal}.php";
		require_once($viewModal);
	}

    function GetFile(string $url, $data)
    {
        ob_start();
        require_once("Views/{$url}.php");
        $file = ob_get_clean();
        return $file;
    }

	//Envio de correos
    function SendEmail($data,$template)
    {
    	require_once('Models/ConfiguracionesModel.php');
    	$nombreApp = new ConfiguracionesModel();
    	$idEmpresa = 1;
    	$arrConfiguraciones = $nombreApp->DatosCorreo($idEmpresa);

        $asunto = $data['asunto'];
        $emailDestino = $data['email'];
        $empresa = $arrConfiguraciones["nombre_remitente"];
        $remitente = $arrConfiguraciones["correo_remitente"];
        $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";
        //ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF-8\r\n";
        $de .= "From: {$empresa} <{$remitente}>\r\n";
        $de .= "Bcc: $emailCopia \r\n";
        ob_start();
        require_once("Views/Template/Email/".$template.".php");
        $mensaje = ob_get_clean();
        $send = mail($emailDestino, $asunto, $mensaje, $de);
        return $send;
    }

    function SendEmailPqrs($data,$template)
    {
    	require_once('Models/ConfiguracionesModel.php');
    	$nombreApp = new ConfiguracionesModel();
    	$idEmpresa = 1;
    	$arrConfiguraciones = $nombreApp->DatosCorreo($idEmpresa);
        $arrCorreo = $nombreApp->DatosEmpresa($idEmpresa);

        $asunto = $data['asunto'];
        $emailDestino = $arrCorreo['correo_empresa'];
        $cliente = $data["cliente"];
        $remitente = $arrConfiguraciones["correo_remitente"];
        $emailCopia = !empty($data['emailCopia']) ? $data['emailCopia'] : "";
        //ENVIO DE CORREO
        $de = "MIME-Version: 1.0\r\n";
        $de .= "Content-type: text/html; charset=UTF-8\r\n";
        $de .= "From: {$cliente} <{$remitente}>\r\n";
        $de .= "Bcc: $emailCopia \r\n";
        ob_start();
        require_once("Views/Template/Email/".$template.".php");
        $mensaje = ob_get_clean();
        //$send = mail($emailDestino, $asunto, $mensaje, $de);
        return "true";
    }


    function GetPermisos(string $modulo)
    {
    	require_once('Models/PermisosModel.php');
    	$objPermisos = new PermisosModel();
        if(!empty($_SESSION['userData']['idRol']))
        {

        	$idRol = $_SESSION['userData']['idRol'];
        	$arrPermisos = $objPermisos->PermisosModulo($idRol);
        	$permisos = '';
        	$permisosMod = '';
        	if(count($arrPermisos) >0 )
        	{
        		$permisos = $arrPermisos;
        		$permisosMod = isset($arrPermisos[$modulo]) ? $arrPermisos[$modulo] : "";
        	}
        	$_SESSION['permisos'] = $permisos;
        	$_SESSION['permisosMod'] = $permisosMod;
        }
    }


    function SessionUser(int $idPersona)
    {
    	require_once('Models/LoginModel.php');
    	$objLogin = new LoginModel();
    	$request = $objLogin->SessionLogin($idPersona);
    	return $request;
    }

    function SessionStart()
    {
    	session_start();
    	$inactive = 1500;
    	if($_SESSION['timeout'])
    	{
    		$session_in = time() - $_SESSION['inicio'];
    		if($session_in > $inactive)
    		{
    			header("Location: ".BASE_URL. "/logout");
    		}
    	}else
    	{
    		header("Location: ".BASE_URL. "/logout");
    	}
    }

    function UploadImage(array $data, string $name)
    {
    	$url_temp = $data['tmp_name'];
    	$destino = 'Assets/images/uploads/'.$name;
    	$move = move_uploaded_file($url_temp, $destino);
    	return $move;
    }

    function DeleteFile(string $name)
    {
    	unlink('Assets/images/uploads/'.$name);
    }

    function ClearCadena(string $cadena)
    {
    	//Reemplazamos la A y a
        $cadena = str_replace(
        array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
        array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
        $cadena
        );
 
        //Reemplazamos la E y e
        $cadena = str_replace(
        array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
        array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
        $cadena );
 
        //Reemplazamos la I y i
        $cadena = str_replace(
        array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
        array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
        $cadena );
 
        //Reemplazamos la O y o
        $cadena = str_replace(
        array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
        array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
        $cadena );
 
        //Reemplazamos la U y u
        $cadena = str_replace(
        array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
        array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
        $cadena );
 
        //Reemplazamos la N, n, C y c
        $cadena = str_replace(
        array('Ñ', 'ñ', 'Ç', 'ç',',','.',';',':'),
        array('N', 'n', 'C', 'c','','','',''),
        $cadena
        );
        return $cadena;
    }

	function StrClean($strCadena)
	{
		$string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''],$strCadena);
		$string = trim($string);
		$string = stripcslashes($string);
		$string = str_replace("<script>", "",$string);
		$string = str_replace("</script>", "",$string);
		$string = str_replace("<script src>", "",$string);
		$string = str_replace("<script type=>", "",$string);
		$string = str_replace("SELECT * FROM", "",$string);
		$string = str_replace("DELETE FROM", "",$string);
		$string = str_replace("INSERT INTO", "",$string);
		$string = str_replace("SELECT COUNT(*) FROM", "",$string);
		$string = str_replace("DROP TABLE", "",$string);
		$string = str_replace("OR '1' = '1'", "",$string);
		$string = str_replace('OR "1" = "1"', "",$string);
		$string = str_replace('OR ´1´=´1´', "",$string);
		$string = str_replace("is NULL; --", "",$string);
		$string = str_replace("LIKE '", "",$string);
		$string = str_replace('LIKE "', "",$string);
		$string = str_replace("LIKE ´", "",$string);
		$string = str_replace("OR 'a'='a'", "",$string);
		$string = str_replace('OR "a"="a"', "",$string);
		$string = str_replace("OR ´a´=´a´", "",$string);
		$string = str_replace("--", "",$string);
		$string = str_replace("^", "",$string);
		$string = str_replace("[", "",$string);
		$string = str_replace("]", "",$string);
		$string = str_replace("==", "",$string);
		return $string;
	}

	function PassGenerator($length = 10)
	{
		$pass = "";
		$longitudPass = $length;
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvxyz1234567890!*-_";
		$longitudCadena=strlen($cadena);
		for($i=1; $i<=$longitudPass; $i++)
		{
			$pos = rand(0,$longitudCadena-1);
			$pass .=substr($cadena, $pos,1);
		}
		return $pass;
	}

	function Token()
	{
		$r1 = bin2hex(random_bytes(10));
		$r2 = bin2hex(random_bytes(10));
		$r3 = bin2hex(random_bytes(10));
		$r4 = bin2hex(random_bytes(10));
		$token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
		return $token;
	}

	function FormatMoney($cantidad)
	{
        require_once('Models/ConfiguracionesModel.php');
    	$nombreApp = new ConfiguracionesModel();
    	$idEmpresa = 1;
    	$arrConfiguraciones = $nombreApp->DatosMoneda($idEmpresa);

		$cantidad = $arrConfiguraciones["simbolo_moneda"].' '.number_format($cantidad,0,$arrConfiguraciones["separador_decimales"],$arrConfiguraciones["separador_miles_millones"]);
		return $cantidad;
	}

	function GetTokenPaypal()
    {
        $payLogin = curl_init(URLPAYPAL."/v1/oauth2/token");
        curl_setopt($payLogin, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($payLogin, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($payLogin, CURLOPT_USERPWD, IDCLIENTEPAYPAL .":". SECRETCLIENTEPAYPAL);
        curl_setopt($payLogin, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($payLogin);
        $err = curl_error($payLogin);
        curl_close($payLogin);
        if($err)
        {
            $request = "CURL Error #: " .$err;
        }else
        {
            $objData = json_decode($result);
            $request = $objData->access_token;
        }
        return $request;
    }

    function CurlConnectionGet(string $ruta, string $contentType =null, string $token)
    {
        $contentType = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token)
        {
            $arrHeader = array('Content-Type:'.$contentType,
                                'Authorization: Bearer '.$token);
        }else
        {
            $arrHeader = array('Content-Type:'.$contentType);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err)
        {
            $request = "CURL Error #: " .$err;
        }else
        {
            $request = json_decode($result);
        }
        return $request;
    }

    function CurlConnectionPost(string $ruta, string $contentType =null, string $token)
    {
        $contentType = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token)
        {
            $arrHeader = array('Content-Type:'.$contentType,
                                'Authorization: Bearer '.$token);
        }else
        {
            $arrHeader = array('Content-Type:'.$contentType);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err)
        {
            $request = "CURL Error #: " .$err;
        }else
        {
            $request = json_decode($result);
        }
        return $request;
    }

    function CambioMoneda($monto, $de, $a)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=".$a."&from=".$de."&amount=".$monto."",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: ".KEYTASACAMBIO
          ),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);
        return $response;
    }
    
    function Meses()
    {
        $meses = array("Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre");
        return $meses;
    }


    function PeticionPost(string $ruta, string $data = null, string $contentType =null,  string $token)
    {
        $contentType = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token != "")
        {
            $arrHeader = array('Content-Type:'.$contentType,
                                'Authorization: Bearer '.$token);
        }else
        {
            $arrHeader = array('Content-Type:'.$contentType);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);

        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err)
        {
            $request = array('success' => false,
                            'message' => 'CURL PeticionPost Error #: ' .$err);
        }else
        {
            $request = json_decode($result);
        }
        return $request;
    }

    function PeticionGet(string $ruta, string $contentType =null, string $token)
    {
        $contentType = $contentType != null ? $contentType : "application/x-www-form-urlencoded";
        if($token)
        {
            $arrHeader = array('Content-Type:'.$contentType,
                                'Authorization: Bearer '.$token);
        }else
        {
            $arrHeader = array('Content-Type:'.$contentType);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $arrHeader);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if($err)
        {
            $request = array('success' => 0,
                            'message' => 'CURL PeticionGet Error #: ' .$err);
        }else
        {
            $request = json_decode($result);
        }
        return $request;
    }

    function GetTokenApp()
	{
    	require_once('Models/AplicacionModel.php');
    	$app = new AplicacionModel();
    	$arrApp = $app->SelectAplicacion(APP_NAME);
        return  $arrApp["token"];
	}

    function fileToBase64($file) {
        // Verificar si no hubo errores en la carga del archivo
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Obtener el tipo MIME del archivo
            $imageType = $file['type'];
    
            // Leer el contenido del archivo en formato binario
            $imageData = file_get_contents($file['tmp_name']);
    
            // Codificar los datos binarios en Base64
            $base64Image = base64_encode($imageData);
    
            // Crear la URL Data URI para el archivo
            $dataURI = "data:$imageType;base64,$base64Image";
    
            return $dataURI;
        } else {
            return false; // Hubo un error en la carga del archivo
        }
    }
?>