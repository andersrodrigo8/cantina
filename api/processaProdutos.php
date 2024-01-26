<?php
    $db = null;
	include('funcao.php'); 

	try{
		$requestData = $_REQUEST;

		$sqldados = "SELECT * FROM public.tbproduto WHERE 1 = 1 ";

		//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
		$columns = array(
			array( '0' => 'tbproduto.id'), 
		    array( '1' => 'tbproduto.titulo'), 
		    array( '2' => 'tbproduto.validade'), 
		    array( '3' => 'tbproduto.quantidade'), 
		    array( '4' => 'tbproduto.valor'),
		);
		
		//Obter registros de número total sem qualquer pesquisa
		$qnt_linhas = selectpadraoconta($db,$sqldados);

		//Obter registro com pesquisa total
		if(!empty($requestData['search']['value'])){ //Se houver um parâmetro de pesquisa $requestData['search']['value'] contém o parâmetro de pesquisa
			$sqldados .= " AND ( tbproduto.descricao ILIKE '%".$requestData['search']['value']."%' ";
			$sqldados .= " OR tbproduto.quantidade ILIKE '%".$requestData['search']['value']."%' OR tbproduto.titulo ILIKE '%".$requestData['search']['value']."%' ) ";
		}

		//Obter registro com pesquisa na coluna
		$condicaoArray = array();

		if(!empty($requestData['columns'][0]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbproduto.id ILIKE '%".$requestData['columns'][0]['search']['value']."%' ";
		}	

		if(!empty($requestData['columns'][1]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbproduto.titulo ILIKE '%".$requestData['columns'][1]['search']['value']."%' ";
		}	

		if(!empty($requestData['columns'][2]['search']['value'])){ 					//BUSCA DATA
			if(strlen($requestData['columns'][2]['search']['value']) == 10 ){		//BUSCA DATA COMPELTA
				$condicaoArray[count($condicaoArray)] = " tbproduto.validade = '".implode('-', array_reverse(explode('/', $requestData['columns'][2]['search']['value'])))."'";
			}elseif(strlen($requestData['columns'][2]['search']['value']) == 4){	//BUSCA SOMENTE O ANO
				if (strstr($requestData['columns'][2]['search']['value'], '/')) { 	//ACHOU A BARRA
			        
			    }else{																//NÃO ACHOU A BARRA
					$condicaoArray[count($condicaoArray)] = " tbproduto.validade = '".$requestData['columns'][2]['search']['value']."' ";
			    }
			}
		}

		if(!empty($requestData['columns'][3]['search']['value'])){ 
			$condicaoArray[count($condicaoArray)] = " tbproduto.quantidade ILIKE '%". $requestData['columns'][3]['search']['value']."%' ";
		}

		if(!empty($requestData['columns'][4]['search']['value'])){ 
			$condicaoArray[count($condicaoArray)] = " tbproduto.valor ILIKE '%". $requestData['columns'][4]['search']['value']."%' ";
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
				$dado[] = '<div class="text-align-center"><img src="'.$row_result['pathfoto'].'" alt="some text" width=60 height=40></div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['titulo'])){
				$dado[] = '<div class="text-align-center">'.$row_result['titulo'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			$data_inicio = new DateTime($row_result['validade']);
		    $data_fim = new DateTime(date('Y-m-d'));

		    // Resgata diferença entre as datas
		    $dateInterval = $data_inicio->diff($data_fim); 

			if(!empty($row_result['validade'])){
				if($dateInterval->days < 5){
					$class = 'txt-color-red';
				}else{
					$class = null;
				}
				$dado[] = '<div class="text-align-center '.$class.'">'.date('d/m/Y',strtotime($row_result['validade'])).'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';		
			}
			
			if(!empty($row_result['quantidade'])){
				$dado[] = '<div class="text-align-center">'.$row_result['quantidade'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['valor'])){
				$dado[] = '<div class="text-align-center">R$ '.number_format($row_result['valor'],2,",").'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			$form = null;
			$form = '<form action="pop_produtos.php" method="post" target="_self" class="text-align-center">
							<input type="hidden" name="id" value="'.$row_result['id'].'"/>';
							$form .= '<button name="BotaoAcao" value="Alterar" class="btn btn-warning btn-xs" title="Alterar Registro"><i class="fa fa-pencil"></i></button>';
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