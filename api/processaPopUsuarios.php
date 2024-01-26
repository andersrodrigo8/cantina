<?php
    $db = null;
	include('funcao.php'); 

	try{
		$requestData = $_REQUEST;

		$id = $requestData['id'];

		$sqldados = "select tbproduto.titulo, tbvendaitens.quantidade, tbvendaitens.valortotal, tbvenda.status, tbvenda.datavenda, tbvenda.databaixa, tbvenda.id, tbvendaitens.id as ItensId, tbproduto.id as ProdId from public.tbusuario, public.tbvenda, public.tbproduto, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbproduto.id = tbvendaitens.prod_id and tbusuario.id = tbvendaitens.usua_id and tbvendaitens.usua_id = ".$id . " ";

		//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
		$columns = array(
			array( '0' => 'tbproduto.titulo'), 
		    array( '1' => 'tbvendaitens.quantidade'),
		    array( '2' => 'tbvendaitens.valortotal'), 
		    array( '3' => 'tbvenda.datavenda'),
		    array( '4' => 'tbvenda.databaixa'),
		    array( '5' => 'tbvenda.status') 
		);
		
		//Obter registros de número total sem qualquer pesquisa
		$qnt_linhas = selectpadraoconta($db,$sqldados);

		//Obter registro com pesquisa total
		if(!empty($requestData['search']['value'])){ //Se houver um parâmetro de pesquisa $requestData['search']['value'] contém o parâmetro de pesquisa
			$sqldados .= " AND ( tbproduto.titulo ILIKE '%".$requestData['search']['value']."%' ";
			$sqldados .= " OR tbvenda.quantidade = ".$requestData['search']['value']." OR tbvenda.status ILIKE '%".$requestData['search']['value']."%' ) ";
		}

		//Obter registro com pesquisa na coluna
		$condicaoArray = array();

		if(!empty($requestData['columns'][0]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbproduto.titulo ILIKE '%".$requestData['columns'][0]['search']['value']."%' ";
		}	

		if(!empty($requestData['columns'][1]['search']['value'])){  
			$condicaoArray[count($condicaoArray)] = " tbvenda.quantidade ILIKE ".$requestData['columns'][1]['search']['value']." ";
		}	

		if(!empty($requestData['columns'][5]['search']['value'])){ 
			$condicaoArray[count($condicaoArray)] = " tbvenda.status ILIKE '%". $requestData['columns'][5]['search']['value']."%' ";
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
        
		$queryResultado = selectpadrao($db,$sqldados);

		//Ler e Criar o Array de Dados
		$dadosArray = array();

		foreach($queryResultado as $row_result){
			$dado = array(); 

			if(!empty($row_result['titulo'])){
				$dado[] = '<div class="text-align-center">'.$row_result['titulo'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['quantidade'])){
				$dado[] = '<div class="text-align-center">'.$row_result['quantidade'].'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['valortotal'])){
				$dado[] = '<div class="text-align-center">R$ '.number_format($row_result['valortotal'],2,",").'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['datavenda'])){
				$dado[] = '<div class="text-align-center">'.date('d/m/Y H:i:s', strtotime($row_result['datavenda'])).'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if(!empty($row_result['databaixa'])){
				$dado[] = '<div class="text-align-center">'.date('d/m/Y H:i:s', strtotime($row_result['databaixa'])).'</div>';
			}else{
				$dado[] = '<div class="text-align-center">-</div>';
			}

			if($row_result['status'] == 'PAGO') { 
				$dado[] = '<div class="text-align-center"><span class="center-block padding-5 label label-success">'.$row_result['status'].'</span></div>';
			}else{
				$dado[] = '<div class="text-align-center"><span class="center-block padding-5 label label-danger">'.$row_result['status'].'</span></div>';
			}
			 
			$form = null;
			if($row_result['status'] != 'PAGO') { 
				$form .= '<form action="pop_usuarios.php" method="post" target="_self" class="text-align-center">';
					$form .= '<input type="hidden" name="idVenda" value="'.$row_result['id'].'"/>';
					$form .= '<input type="hidden" name="ItensId" value="'.$row_result['itensid'].'"/>';
					$form .= '<input type="hidden" name="ProdId" value="'.$row_result['prodid'].'"/>';
					$form .= '<input type="hidden" name="id" value="'.$id.'"/>';

					$form .= '<button name="BotaoAcao" value="ExcluirVenda" class="btn btn-danger btn-xs" title="Excluir a Venda"><i class="fa fa-trash"></i></button>';
				$form .= '</form>'; 
			}else{
				$form .= '-';
			}

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