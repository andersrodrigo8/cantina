<?php
    $db = null;
	include('funcao.php'); 

	try{
		$requestData = $_REQUEST;

		$sqldados = "SELECT * FROM public.tbusuario WHERE 1 = 1 ";

		//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
		$columns = array(
			array( '0' => 'tbusuario.id'), 
		    array( '1' => 'tbusuario.nome'),
            array( '2' => 'tbusuario.tipo'),
		    array( '3' => 'tbusuario.email')
		);
		
		//Obter registros de número total sem qualquer pesquisa
		$qnt_linhas = selectpadraoconta($db,$sqldados);

		//Obter registro com pesquisa total
		if(!empty($requestData['search']['value'])){ //Se houver um parâmetro de pesquisa $requestData['search']['value'] contém o parâmetro de pesquisa
			$sqldados .= " AND ( tbusuario.nome ILIKE '%".$requestData['search']['value']."%' ";
			$sqldados .= " OR tbusuario.re ILIKE '%".$requestData['search']['value']."%' OR tbusuario.nomeguerra ILIKE '%".$requestData['search']['value']."%' ) ";
		}

		//Obter registro com pesquisa na coluna
		$condicaoArray = array();

		if(!empty($requestData['columns'][0]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbusuario.id ILIKE '%".$requestData['columns'][0]['search']['value']."%' ";
		}	

		if(!empty($requestData['columns'][1]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbusuario.nome ILIKE '%".$requestData['columns'][1]['search']['value']."%' ";
		}

        if(!empty($requestData['columns'][2]['search']['value'])){
            $condicaoArray[count($condicaoArray)] = " tbusuario.tipo ILIKE '%". $requestData['columns'][2]['search']['value']."%' ";
        }

		if(!empty($requestData['columns'][3]['search']['value'])){
			$condicaoArray[count($condicaoArray)] = " tbusuario.email ILIKE '%". $requestData['columns'][3]['search']['value']."%' ";
		}

		$sqlCondicao = null;
		for($i=0; $i<count($condicaoArray); $i++){
			if($i == 0){
				$sqlCondicao = " AND (".$condicaoArray[$i];
			}else{
				$sqlCondicao .= ' AND '.$condicaoArray[$i];
			}

			if($i == (count($condicaoArray)-1)){
				$sqlCondicao .= " ) ";
			}
		}

		if(!empty($sqlCondicao)){ 
			$sqldados .= $sqlCondicao;
		}

		//Obter registros de número total com pesquisa
		$totalFiltered = selectpadraoconta($db,$sqldados);

		//Ordena o resultado
        if(!empty($requestData['order'][0])){
            $sqldados .= " ORDER BY ". $columns[$requestData['order'][0]['column']][$requestData['order'][0]['column']] . " ". $requestData['order'][0]['dir'];
        }

        $sqldados .= " LIMIT ".(!empty($requestData['length']) ? $requestData['length'] : 10)." OFFSET ".(!empty($requestData['start']) ? $requestData['start'] : 0). " ";

        //echo $sqldados;

		$resultado_agenda = selectpadrao($db,$sqldados);

		//Ler e Criar o Array de Dados
		$dadosArray = array();

		foreach($resultado_agenda as $row_result){
			$dado = array(); 

			if(!empty($row_result['id'])){
				$dado[] = '<div class="text-align-center">'.$row_result['id'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['nome'])){
				$dado[] = '<div class="text-align-center">'.$row_result['nome'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

            if(!empty($row_result['tipo'])){
                $dado[] = '<div class="text-align-center">'.$row_result['tipo'].'</div>';
            }else{
                $dado[] = '<div class="text-align-center">-</div>';
            }

			if(!empty($row_result['email'])){
				$dado[] = '<div class="text-align-center">'.$row_result['email'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			$total = selectFindUsuarioIdValor($db,$row_result['id']);
			if($total > 0){
				$dado[] = '<div class="text-align-center">R$ '.$total.'</div>';
			}else{
				$dado[] = '<div class="text-align-center">R$ -</div>';
			}
			 
			$form = null;
			$form = '<form action="pop_usuarios.php" method="post" target="_self" class="text-align-center">
							<input type="hidden" name="id" value="'.$row_result['id'].'"/>';
							$form .= '<button name="BotaoAcao" value="Alterar" class="btn btn-warning btn-xs" title="Alterar Registro"><i class="fa fa-pencil"></i></button> ';

							$form .= '<a id="'.$row_result['id'].'" onClick="Pagamento(this.id);" class="btn btn-info btn-xs" title="Efetuar Pagamento"><i class="fa fa-money"></i></a>';
			$form .= '</form>'; 

			$dado[] = $form;

			$dadosArray[] = $dado;
		}

        if(isset($requestData['draw'])){
            $draw = $requestData['draw'];
        }else{
            $draw = 0;
        }

		//Criar o array de informações a serem retornadas para o Javascript com html já montada
		$json_data = array(
			"draw" => intval($draw), 								//Para cada requisição é enviado um número como parametro
			"recordsTotal" => intval($qnt_linhas), 					//Quantidade de registros que há no bando de dados
			"recordsFiltered" => intval($totalFiltered),			//Total de registros quando houver pesquisa
			"data" => $dadosArray  									//Array de dados completo dos dados retornados da tabela
		);

		echo json_encode($json_data);

	}catch(PDOException $error){
		return($error->getMessage());
	}
?>