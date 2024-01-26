<?php
$db = null;
include('funcao.php');

try{
    $requestData = $_REQUEST;

    $sqldados = "select tbusuario.nome, sum(valortotal) as total from public.tbusuario, public.tbvenda, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbusuario.id = tbvendaitens.usua_id  group by tbusuario.nome ";

    //Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
    $columns = array(
        array( '0' => 'tbusuario.nome'),
	array('1' => 'total'),
    );

    //Obter registros de número total sem qualquer pesquisa
    $qnt_linhas = selectpadraoconta($db,$sqldados);

    //Obter registro com pesquisa total
    if(!empty($requestData['search']['value'])){ //Se houver um parâmetro de pesquisa $requestData['search']['value'] contém o parâmetro de pesquisa
        $sqldados .= " AND ( tbusuario.nome ILIKE '%".$requestData['search']['value']."%') ";
    }

    //Obter registro com pesquisa na coluna
    $condicaoArray = array();

    if(!empty($requestData['columns'][0]['search']['value'])){
        $condicaoArray[count($condicaoArray)] = " tbusuario.nome ILIKE '%".$requestData['columns'][0]['search']['value']."%' ";
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

        if(!empty($row_result['nome'])){
            $dado[] = '<div class="text-align-center">'.$row_result['nome'].'</div>';
        }else{
            $dado[] = '<div class="text-align-center">-</div>';
        }

        if(!empty($row_result['total'])){
            $dado[] = '<div class="text-align-center">R$ '.number_format($row_result['total'],2,",").'</div>';
        }else{
            $dado[] = '<div class="text-align-center">-</div>';
        }

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
