<?php
$db = null;
include('funcao.php');

try{
    $requestData = $_REQUEST;

    $mes = $requestData['mes'];

    $condicao = null;

    switch ($mes) {
        case 'Janeiro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-01-01' AND '".date('Y')."-01-31'";
            break;
        case 'Fevereiro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-02-01' AND '".date('Y')."-02-28'";
            break;
        case 'Março':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-03-01' AND '".date('Y')."-03-31'";
            break;
        case 'Abril':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-04-01' AND '".date('Y')."-04-30'";
            break;
        case 'Maio':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-05-01' AND '".date('Y')."-05-31'";
            break;
        case 'Junho':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-06-01' AND '".date('Y')."-06-30'";
            break;
        case 'JUlho':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-07-01' AND '".date('Y')."-07-31'";
            break;
        case 'Agosto':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-08-01' AND '".date('Y')."-08-31'";
            break;
        case 'Setembro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-09-01' AND '".date('Y')."-09-30'";
            break;
        case 'Outubro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-10-01' AND '".date('Y')."-10-31'";
            break;
        case 'Novembro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-11-01' AND '".date('Y')."-11-30'";
            break;
        case 'Dezembro':
            $condicao = "tbvenda.datavenda BETWEEN '".date('Y')."-12-01' AND '".date('Y')."-12-31'";
            break;
    }

    $sqldados = "select tbusuario.nome, sum(valortotal) as total from public.tbusuario, public.tbvenda, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbvenda.status = 'PENDENTE' and tbusuario.id = tbvendaitens.usua_id and " . $condicao ." group by tbusuario.nome ";

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

        /*if(!empty($row_result['total'])){
            $dado[] = '<div class="text-align-center">R$ '.number_format($row_result['total'],2,",").'</div>';
        }else{
            $dado[] = '<div class="text-align-center">-</div>';
        }*/

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
