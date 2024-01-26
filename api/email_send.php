<?php
    $db = null;
	require_once('src/PHPMailer.php');
	require_once('src/SMTP.php');
	require_once('src/Exception.php');
    include ('funcao.php');
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$hostname = "{imap.gmail.com:993/imap/ssl}";;
	$corpo1 = $_POST['bodyEmail'];
	$emailsend = trim($_POST['emailUsuario']);
        //$ccopy = selectUsuariosAdministradores($db);
	$subjectemail = trim($_POST['subjectemail']);


	if (isset($emailsend) && !empty($emailsend) && isset($subjectemail) && !empty($subjectemail)) {

	    //$login = trim('interpmpp@gmail.com');
	    //$senha = trim('jnghbbbcdfldrpff');

	    $login = trim('copinhafood@gmail.com');
	    $senha = trim('mydvcolwyobjyjjb');

	    $subjectemail = trim($subjectemail);
	    $emailbody = trim($corpo1);
	    $altbody = strip_tags(trim($emailbody));

		$mail = new PHPMailer(true);
 
		try {
			$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Username = $login;
			$mail->Password = $senha;
			$mail->Port = 587;
		 
			$mail->setFrom($login);

			$emailsend = trim(strtolower($emailsend));
			$arraySend = explode(";", $emailsend);
			for($i=0; $i<count($arraySend); $i++){
				$mail->addAddress(trim($arraySend[$i]));
			}
			
			if(isset($ccopy) && !empty($ccopy)){
				$emailsendCCopy = trim(strtolower($ccopy));
				$arraySendCCopy = explode(";", $emailsendCCopy);
				for($i=0; $i<count($arraySendCCopy); $i++){
					trim($arraySendCCopy[$i]);
					$mail->addCC(trim($arraySendCCopy[$i]));
				}
			} 

			if (isset($_FILES['attachments']) && $_FILES['attachments']['error'] == UPLOAD_ERR_OK) {
			    $mail->AddAttachment($_FILES['attachments']['tmp_name'], $_FILES['attachments']['name']);
			}
		 
			$mail->isHTML(true);
			$mail->CharSet = 'UTF-8'; // Charset da mensagem (opcional)
			$mail->Subject = $subjectemail;
			$mail->Body = $emailbody;
			$mail->AltBody = $altbody;
		 
			if($mail->send()) {
				echo "OK";
			} else {
				echo "ERROR";
			}
		} catch (Exception $e) {
			echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
		}
		
	}
?>
