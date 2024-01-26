<?php
	include("lib/nusoap.php");

	$tokenAuthorized = "202302160542-1273914";
	
	if(!empty($_POST['token']) && $_POST['token'] == $tokenAuthorized){

		header('Content-Type: text/html; charset=iso-8859-18');

		set_time_limit(0);
		ini_set('memory_limit', '-1');
		mb_internal_encoding("UTF-8");

		if(!empty($_POST['re'])){

			$nome = null;
	    	$re = null;
	        $email = null;

			$re = trim($_POST['re']);

			$options = array('trace'=>1, 
							'exceptions'=> 0, 			
							'encoding' => 'UTF-8',
							'soapaction' => '');

			// Create the client instance
			$client = new soapclient('http://10.61.254.16/WSSCPM/Service.asmx?wsdl', true, $options);

			// Check for an error
			$err = $client->getError();
			if ($err) {
				$status['msg'] = $err;
				$status['status'] = 400;
				$status['text'] = "error";
			}
			
			$function = 'procuraPMPorREDetalhe';
			$arguments = array('PMRENum' => trim($RE));

			// Call the SOAP method
			$result = $client->call($function, $arguments);
			
			// Check for a fault
			if ($client->fault) {
				$status['msg'] = $result;
				$status['status'] = 400;
				$status['text'] = "error";
			} else {
			    // Check for errors
			    $err = $client->getError();
			    if ($err) {
			        $status['msg'] = $err;
					$status['status'] = 400;
					$status['text'] = "error";
			    } else {
			    	$nome = $result['procuraPMPorREDetalheResult']['nomePM'];
			    	$re = $result['procuraPMPorREDetalheResult']['numeroREPM'] . $result['procuraPMPorREDetalheResult']['digitoREPM'];
			        $email = DadosFuncionario($result['procuraPMPorREDetalheResult']['dadosContatoFuncionario']['FuncionarioContato']);
			    }
			}
			
			if(!empty($nome)){
				$status['nome'] = $nome;
				$status['re'] = $re;
				$status['email'] = $email;
				$status['status'] = 200;
				$status['text'] = "ok";
			}else{
				$status['status'] = 400;
				$status['text'] = "error";
				echo json_encode($status);
			}
			echo json_encode($status);
		}else{
			$status['status'] = 400;
			$status['text'] = "error";
			echo json_encode($status);
		}		
		
	}

	function DadosFuncionario($arrayDadosFuncionario){
		foreach ($arrayDadosFuncionario as $valores) {
    		try{
    			if(isset($valores['emailContato'])){
    				return $valores['emailContato'];
    			}else{
    				return null;
    			}				 						
			}catch(Exception $error){ 
				return null;
			}
    	}
	}

?>
