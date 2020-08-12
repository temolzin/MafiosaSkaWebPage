<?php
	require_once('lib/WhatsmsApi.php');
	require_once('lib/phpMailer/class.phpmailer.php');
	require_once('lib/phpMailer/class.smtp.php');
	require_once('lib/phpMailer/PHPMailerAutoload.php');
	
	define("destino", "temolzin@hotmail.com");
	define("nombre", "Temolzin Roldan");

	$nombre1=filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
	$apellido=filter_var($_POST['apellido'], FILTER_SANITIZE_STRING);
	$de=filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$telefono=filter_var($_POST['telefono'], FILTER_SANITIZE_STRING);
	$asunto=filter_var($_POST['asunto'], FILTER_SANITIZE_STRING);
	$message = filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);
	$nombre = $nombre1 . " " . $apellido;

	/*$whatsmsapi = new WhatsmsApi();
	$whatsmsapi->setApiKey("5cf97ab762963");
	$mensajeWhats = "Nombre: " . $nombre . " Teléfono: " . $telefono ." Correo: " . $de . " Asunto: " . $asunto . " Mensaje: " . $message;
	$whatsmsapi->sendSms("525535092965", $mensajeWhats);*/

	$mensaje='
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Formulario de contacto</title>
		</head>
		<body>
			<h1>Página de La Mafiosa Ska</h1>
			<table border="1">
				<tr>
					<td bgcolor="#2BD8D6">Nombre</td>
					<td bgcolor="#2BD8D6">Email</td>
					<td bgcolor="#2BD8D6">Teléfono</td>
					<td bgcolor="#2BD8D6">Asunto</td>
					<td bgcolor="#2BD8D6">Mensaje</td>
				</tr>
				<tr>
					<td>'.$nombre.'</td>
					<td>'.$de.'</td>
					<td>'.$telefono.'</td>
					<td>'.$asunto.'</td>
					<td>'.$message.'</td>
				</tr>
			</table>
			<img src="../images/logoMafiosa.png" alt="La Mafiosa Ska" align="left">
		</body>
		</html>
		';
		//$mensaje.=filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING);
		
		$correo = new PHPMailer(); //Creamos una instancia en lugar usar mail()

		$correo->IsSMTP();
		$correo->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true));

		// optional
		// used only when SMTP requires authentication  
		$correo->SMTPAuth   = true;
		$correo->SMTPSecure = 'tls';
		$correo->Host       = "smtp.live.com";
		$correo->Port = 587;

		$correo->Username = 'temolzin@hotmail.com';
		$correo->Password = 'naruto_10';
				
 
		//Usamos el SetFrom para indicar quien envia el correo
		//$correo->From = $de;
		$correo->FromName = $nombre;
		$correo->SetFrom($de, $nombre);
		 
		//Usamos el AddReplyTo para indicart a quien tiene que responder el correo
		$correo->AddReplyTo($de, $nombre);
		 
		//Usamos el AddAddress para agregar un destinatario
		$correo->AddAddress(destino, nombre);
		//$correo->AddAddress("coker_3x@hotmail.com");
		 
		$asunto = "Página MafiosaSka " . $asunto;
		//Ponemos el asunto del mensaje
		$correo->Subject = $asunto;
		 
		/*
		 * Si deseamos enviar un correo con formato HTML utilizaremos MsgHTML:
		 * $correo->MsgHTML("<strong>Mi Mensaje en HTML</strong>");
		 * Si deseamos enviarlo en texto plano, haremos lo siguiente:
		 * $correo->IsHTML(false);
		 * $correo->Body = "Mi mensaje en Texto Plano";
		$correo->MsgHTML($mensaje);*/

		$correo->MsgHTML($mensaje);
		//Si deseamos agregar un archivo adjunto utilizamos AddAttachment
		//$correo->AddAttachment("images/phpmailer.gif");
		$correo->CharSet = "UTF­8";
		//$correo->Encoding = "quoted­printable";
		 
		//Enviamos el correo
		if($correo->Send()) {
		  echo'ok';
		} else {
		  echo "Hubo un error: " . $correo->ErrorInfo;
		}

?>