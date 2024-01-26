<?php
    mb_internal_encoding("UTF-8");
    include_once('config.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    // FUNCAO PARA LOCALIZAÇÂO DO MENU

    class ConexaoPDO{
        public $con;

        public function __construct()
        {
            try {
                $this->con = new PDO(DB_SGBD . ':host=' . DB_HOST . ' dbname=' . DB_NAME . ' port=' . DB_PORT . ' user=' . DB_USER . ' password=' . DB_PASS);
                $this->con->setAttribute(PDO::ATTR_PERSISTENT, false);//
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                echo 'Erro: ' . $e->getMessage() . '<br /> Código: ' . $e->getCode() . '<br /> Arquivo: ' . $e->getFile() . '<br /> Linha: ' . $e->getLine();
            }
        }
    }

    //CHAMA A CONEXÃO
    try {
        $db = new ConexaoPDO();
    } catch (PDOException $e) {
        throw new PDOException($e);
    }

    //--------------------------------INSERIR REGISTRO DO SISTEMA-------------------------------------------//
    function inserirRegistro($db, $sql){
        try {
            $inserir = $db->con->prepare($sql);
            $inserir->execute();
            if ($inserir == 1) {
                return (1);
            } else {
                return (0);
            }
            $db = null;
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------INSERIR REGISTRO RETURNING ID-------------------------------------------//
    function inserirRegistroReturning($db, $sql){
        try {
            $inserir = $db->con->prepare($sql);
            $inserir->execute();

            $ultimo_id = $inserir->fetch(PDO::FETCH_ASSOC);
            return ($ultimo_id);

            $db = null;
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------ALTERAR REGISTRO DO SISTEMA-------------------------------------------//
    function alterarRegistro($db, $sql){
        try {
            $alterar = $db->con->prepare($sql);
            $alterar->execute();
            if ($alterar == 1) {
                return (1);
            } else {
                return (0);
            }
            $db = null;
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------EXCLUIR REGISTRO DO SISTEMA-------------------------------------------//
    function excluirRegistro($db, $sql){
        try {
            $exclui = $db->con->prepare($sql);
            $exclui->execute();
            if ($exclui == 1) {
                return (1);
            } else {
                return (0);
            }
            $db = null;
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------FUNCAO SELECT PADRAO----------------------------------//
    function selectpadrao($db, $sql){
        try {
            $verificar = $db->con->prepare($sql);
            $verificar->execute();
            $resultado = $verificar->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            return ($resultado);
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------FUNCAO SELECT PADRAO CONTADOR----------------------------------//
    function selectpadraoconta($db, $sql){
        try {
            $verificar = $db->con->prepare($sql);
            $verificar->execute();
            $resultado = $verificar->rowCount();
            $db = null;
            return ($resultado);
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------FUNCAO SELECT PADRAO UMA LINHA----------------------------------//
    function selectpadraoumalinha($db, $sql){
        try {
            $verificar = $db->con->prepare($sql);
            $verificar->execute();
            if (isset($verificar)) {
                $resultado = $verificar->fetch(PDO::FETCH_ASSOC);
                $db = null;
                return ($resultado);
            }
        } catch (PDOException $error) {
            return ($error->getMessage());
        }
    }

    //--------------------------------SOMA VALOR DE PRODUTOS EM ESTOQUE----------------------------------//
    function somaTotalGastoProdutos($db){
        $sql = "select * from public.tbproduto";
        $queryValorTotal = selectpadrao($db,$sql);
        $soma = 0;

        foreach($queryValorTotal as $resultado){
            $soma = $soma + ($resultado['quantidade'] * $resultado['valor']);
        }

        $sql = "select * from public.tbvendaitens";
        $queryValorTotal = selectpadrao($db,$sql);

        foreach($queryValorTotal as $resultado){
            $soma = $soma + ($resultado['quantidade'] * $resultado['valorunit']);
        }
        
        return $soma;
    }

    //--------------------------------SOMA TOTAL DE PRODUTOS EM ESTOQUE----------------------------------//
    function somaQuantidadeProdutoEstoque($db){
        $sql = "select sum(tbproduto.quantidade) as total from public.tbproduto";
        $query = selectpadraoumalinha($db,$sql);
        $Total = 0;
        if($query['total'] > 0){
            $Total = $query['total'];
        }
        return $Total;
    }

    //--------------------------------SELECIONA TOTAL PRODUTOS CONSUMIDOS----------------------------------//
    function selectFindUsuarioIdProdutoTotal($db,$id){
        $sql = "select sum(tbvendaitens.quantidade) as total from public.tbusuario, public.tbvenda, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbusuario.id = tbvendaitens.usua_id and tbvendaitens.usua_id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        $Total = 0;
        if($query['total'] > 0){
            $Total = $query['total'];
        }
        return $Total;
    }

    //--------------------------------SELECIONA TOTAL GASTO----------------------------------//
    function selectFindUsuarioIdValorTotal($db,$id){
        $sql = "select sum(valortotal) as total from public.tbusuario, public.tbvenda, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbusuario.id = tbvendaitens.usua_id and tbvendaitens.usua_id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        $Total = 0;
        if($query['total'] > 0){
            $Total = number_format($query['total'],2,",");
        }
        return $Total;
    }

    //--------------------------------SELECIONA VALOR DEVEDOR USUARIO----------------------------------//
    function selectFindUsuarioIdValor($db,$id){
        $sql = "select sum(valortotal) as total from public.tbusuario, public.tbvenda, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbvenda.status = 'PENDENTE' and tbusuario.id = tbvendaitens.usua_id and tbvendaitens.usua_id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        $Total = 0;
        if($query['total'] > 0){
            $Total = number_format($query['total'],2,",");
        }
        return $Total;
    }

    //--------------------------------SELECIONA LISTA DE CONSUMO USUARIO----------------------------------//
    function selectFindUsuarioConsumo($db,$id){
        $sql = "select tbproduto.titulo, tbvendaitens.quantidade, tbvendaitens.valortotal, tbvenda.status, tbvenda.datavenda, tbvenda.databaixa, tbvenda.id  from public.tbusuario, public.tbvenda, public.tbproduto, public.tbvendaitens where tbvendaitens.vend_id = tbvenda.id and tbproduto.id = tbvendaitens.prod_id and tbusuario.id = tbvendaitens.usua_id and tbvendaitens.usua_id = ".$id. " order by tbvenda.datavenda desc";
        $query = selectpadrao($db,$sql);
        return $query;
    }

    //--------------------------------SELECIONA O USUARIO PELA ID----------------------------------//
    function selectFindUsuarioId($db,$id){
        $sql = "select * from public.tbusuario where id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        return $query;
    }

    //--------------------------------SELECIONA O USUARIO PELA SENHA----------------------------------//
    function selectFindUsuario($db,$password){
        $sql = "select * from public.tbusuario where senha = '".$password."';";
        $query = selectpadraoumalinha($db,$sql);
        return $query;
    }

    //--------------------------------LISTA TODOS OS PRODUTOS----------------------------------//
    function selectAllProdutos($db){
        $sql = "select * from public.tbproduto where quantidade > 0 order by tbproduto.titulo asc;";
        $query = selectpadrao($db,$sql);
        return $query;
    }

    //--------------------------------SELECIONA O PRODUTO PRODUTOS QUANTIDADE MAIOR----------------------------------//
    function selectFindProdutos($db, $id){
        $sql = "select * from public.tbproduto where quantidade > 0 and id = ".$id.";";
        $query = selectpadraoumalinha($db,$sql);
        return $query;
    }

    //--------------------------------SELECIONA O PRODUTO PRODUTOS ID----------------------------------//
    function selectFindProdutosId($db, $id){
        $sql = "select * from public.tbproduto where id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        return $query;
    }

    //--------------------------------SELECIONA VENDA ID----------------------------------//
    function selectFindVenda($db, $id){
        $sql = "select * from public.tbvenda where id = ".$id;
        $query = selectpadraoumalinha($db,$sql);
        return $query;
    }

    //--------------------------------ALERTA DE PRODUTOS PARA VENCER ----------------------------------//
    function selectProdutoValidade($db){
        $dataInicial = date('Y-m-d', strtotime('+10 days')); 
        $sql = "select * from public.tbproduto where tbproduto.validade BETWEEN '".date('Y-m-d')."' AND '".$dataInicial."'";
        $query = selectpadrao($db,$sql);
        $produtos = null;
        foreach($query as $resultado){
            $produtos .= $resultado['titulo'] . ' ';
        }
        return $produtos;
    }

    //--------------------------------UPLOAD DE ARQUIVOS----------------------------------//
    function enviandoArquivo($pathfoto){
        $delimitador = array("'", "!", ";", "?", ",", "-", "%", "$", "(", ")", "#", "-", "@", "<", ">", "=", "+", "~", "^", "}", "{", ":", "|", "&", "/", "º", "ª", "*");

        $arquivo = $pathfoto;

        $arquivo = str_replace($delimitador, "", $arquivo);

        $_UP['pasta'] = 'arquivos/';

        $_UP['tamanho'] = 1024 * 1024 * 30; 
        $_UP['extensoes'] = array('jpeg', 'png', 'gif', 'jpg', 'bmp');
        $_UP['renomeia'] = false;

        // Array com os tipos de erros de upload do PHP
        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'Esse arquivo é muito grande, o limite máximo é 2Mb';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

        $extensao = strtolower(end(explode('.', $pathfoto)));

        if (array_search($extensao, $_UP['extensoes']) === false) {
        } else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {  
            return "O arquivo enviado é muito grande!!!";  
            } else { 
                if ($_UP['renomeia'] == true) {
                    $nome_final = time() . '.png';
                } else {
                    $nome_final = $pathfoto;
                    $nome_final = str_replace($delimitador, "", $nome_final);
                    $nome_final = strtoupper("ID_" . $_POST['id'] . "_" . date("YmdHis") . "_" . $nome_final);
                if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                    return $arquivo = ($_UP['pasta'] . $nome_final); 
                }  
            }
        }
    }

    //--------------------------------EVENTOS DE FORMULARIO----------------------------------//
    if(isset($_POST['botaoAcao']) && $_POST['botaoAcao'] == "CadastroUsuario"){
        $re = $_POST['re'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $tipo = $_POST['tipo'];

        if(!empty($re) && !empty($nome) && !empty($email) && !empty($senha) && !empty($tipo)){
            $sqlInsert = "insert into public.tbusuario(re, nome, email, senha, tipo) values ('".pg_escape_string($re)."', '".pg_escape_string($nome)."', '".pg_escape_string($email)."', '".pg_escape_string($senha)."', '".pg_escape_string($tipo)."')";
            inserirRegistro($db, $sqlInsert);
        }
    }

    if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['botaoAcao']) && $_POST['botaoAcao'] == "AlterarUsuario"){
        $id = $_POST['id'];
        $re = $_POST['re'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha =  $_POST['senha'];
        $tipo = $_POST['tipo'];

        if(!empty($id) && !empty($re) && !empty($nome) && !empty($email) && !empty($senha) && !empty($tipo)){
            $sqlUpdate = "update public.tbusuario set re = '".pg_escape_string($re)."', nome = '".pg_escape_string($nome)."', email = '".pg_escape_string($email)."', senha = '".pg_escape_string($senha)."', tipo = '".pg_escape_string($tipo)."' where id = " . $id ;
            alterarRegistro($db, $sqlUpdate);             
        }
    }

    if(isset($_POST['botaoAcao']) && $_POST['botaoAcao'] == "CadastroProduto"){
        $titulo = $_POST['titulo']; 
        $descricao = $_POST['descricao']; 
        $quantidade = $_POST['quantidade']; 
        $valor = str_replace(',', '.', $_POST['valor']);
        $validade = $_POST['validade']; 
        $promocao = $_POST['promocao']; 
        $pathfoto = $_FILES['arquivo']['name'];

        if($promocao != 'on'){
            $promocao = 'False';
        }else{
            $promocao = 'True';
        }

        if(!empty($pathfoto) && $pathfoto != ""){
            $pathfoto = enviandoArquivo($pathfoto);
        }

        if(!empty($titulo) && !empty($descricao) && !empty($quantidade) && !empty($valor) && !empty($validade)){
            if(!empty($pathfoto) && $pathfoto != ""){
                $sqlInsert = "insert into public.tbproduto(titulo, descricao, quantidade, valor, validade, promocao, pathfoto) values ('".pg_escape_string($titulo)."', '".pg_escape_string($descricao)."', ".pg_escape_string($quantidade).", '".pg_escape_string($valor)."', '".pg_escape_string($validade)."', '".pg_escape_string($promocao)."', '".pg_escape_string($pathfoto)."')";
            }else{
                $sqlInsert = "insert into public.tbproduto(titulo, descricao, quantidade, valor, validade, promocao) values ('".pg_escape_string($titulo)."', '".pg_escape_string($descricao)."', ".pg_escape_string($quantidade).", '".pg_escape_string($valor)."', '".pg_escape_string($validade)."', '".pg_escape_string($promocao)."')";
            }
            inserirRegistro($db, $sqlInsert);
        }
    }

    if(isset($_POST['id']) && !empty($_POST['id']) && isset($_POST['botaoAcao']) && $_POST['botaoAcao'] == "AlterarProduto"){
        $id = $_POST['id']; 
        $titulo = $_POST['titulo']; 
        $descricao = $_POST['descricao']; 
        $quantidade = $_POST['quantidade'];
        $valor = str_replace(',', '.', $_POST['valor']);
        $validade = $_POST['validade']; 
        $promocao = $_POST['promocao']; 
        $pathfoto = $_FILES['arquivo']['name'];  

        if($promocao != 'on'){
            $promocao = 'False';
        }else{
            $promocao = 'True';
        }

        if(!empty($pathfoto) && $pathfoto != ""){
            $pathfoto = enviandoArquivo($pathfoto);
        }

        if(!empty($id) && !empty($titulo) && !empty($descricao) && !empty($quantidade) && !empty($valor) && !empty($validade)){
            if(!empty($pathfoto) && $pathfoto != "") {
                $sqlUpdate = "update public.tbproduto set titulo = '" . pg_escape_string($titulo) . "', descricao = '" . pg_escape_string($descricao) . "', quantidade = " . pg_escape_string($quantidade) . ", valor = '" . pg_escape_string($valor) . "', validade = '" . pg_escape_string($validade) . "', promocao = '" . pg_escape_string($promocao) . "', pathfoto = '" . pg_escape_string($pathfoto) . "' where id = " . $id;
            }else{
                $sqlUpdate = "update public.tbproduto set titulo = '" . pg_escape_string($titulo) . "', descricao = '" . pg_escape_string($descricao) . "', quantidade = " . pg_escape_string($quantidade) . ", valor = '" . pg_escape_string($valor) . "', validade = '" . pg_escape_string($validade) . "', promocao = '" . pg_escape_string($promocao) . "' where id = " . $id;
            }
            alterarRegistro($db, $sqlUpdate);
        }
    } 

    if(isset($_POST['idVenda']) && !empty($_POST['idVenda']) && isset($_POST['BotaoAcao']) && $_POST['BotaoAcao'] == "ExcluirVenda"){
        $id = $_POST['id'];
        $idVenda = $_POST['idVenda'];
        $ItensId = $_POST['ItensId'];
        $ProdId = $_POST['ProdId'];

        $queryVenda = selectFindVenda($db, $idVenda);        

        if(!empty($queryVenda['id'])){

            $sqlItens = "SELECT * FROM public.tbvendaitens WHERE vend_id = " . $idVenda ;
            $queryItens = selectpadrao($db,$sqlItens);
         
            if (count($queryItens) == 1) {
                $queryProduto = selectFindProdutosId($db, $ProdId);

                $sqlItens2 = "SELECT * FROM public.tbvendaitens WHERE id = " . $ItensId ;
                $queryItens2 = selectpadraoumalinha($db,$sqlItens2);

                $estorno = $queryItens2['quantidade'] + $queryProduto['quantidade'];

                $sqlEstoque = "UPDATE public.tbproduto SET quantidade = ".$estorno." WHERE id = " . $ProdId;
                alterarRegistro($db, $sqlEstoque);

                $sqlDelete = "DELETE FROM public.tbvendaitens WHERE id = " . $ItensId;
                excluirRegistro($db, $sqlDelete); 

                $sqlDelete = "DELETE FROM public.tbvenda WHERE id = " . $idVenda;
                excluirRegistro($db, $sqlDelete); 
            }else{
                $queryProduto = selectFindProdutosId($db, $ProdId);

                $sqlItens2 = "SELECT * FROM public.tbvendaitens WHERE id = " . $ItensId ;
                $queryItens2 = selectpadraoumalinha($db,$sqlItens2);

                $estorno = $queryItens2['quantidade'] + $queryProduto['quantidade'];

                $sqlEstoque = "UPDATE public.tbproduto SET quantidade = ".$estorno." WHERE id = " . $ProdId;
                alterarRegistro($db, $sqlEstoque);

                $sqlDelete = "DELETE FROM public.tbvendaitens WHERE id = " . $ItensId;
                excluirRegistro($db, $sqlDelete); 
            }         
        }      
    }  

    //--------------------------------LOGIN PARA ACESSO ADMINISTRATIVO----------------------------------//
    if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['BotaoAcao']) && $_POST['BotaoAcao'] == "LoginSistema"){
        $sqlLogin = "select * from public.tbusuario where tipo = 'ADMINISTRADOR' and email = '".strtolower(trim($_POST['email']))."' and senha = '".$_POST['password']."'";
        $queryLogin = selectpadraoumalinha($db, $sqlLogin);

        if(!empty($queryLogin['id'])){
            $_SESSION['administrador'] = 1;
        }else{
            $_SESSION['administrador'] = 0;
        }
    }

    //--------------------------------CORPO DO EMAIL----------------------------------//
    function emailHtmlCompra($db, $idUsuario, $nomeUsuario, $idVenda, $corpoEmail, $totalVenda){
        $totalDevedorGeral = selectFindUsuarioIdValor($db,$idUsuario);

        $bodyEmail = null;
        $bodyEmail .= "<h3>Prezado(a),/h3>";
        $bodyEmail .= "<br>";
        $bodyEmail .= "<h3>".$nomeUsuario." obrigado por adquirir seu produto na copinha!</h3>";
        $bodyEmail .= "<br>";
        $bodyEmail .= "<br>";
        $bodyEmail .= '<table style="width:100%;" boder="1">';
            
            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th colspan="2"><h2>Extrato Compra Copinha</h2></th>';
              $bodyEmail .= '<th colspan="2">Nº Compra: '.$idVenda.'</th>';             
            $bodyEmail .= '</tr>';

            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';             
            $bodyEmail .= '</tr>';

            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th><strong>Produto</strong></th>';
              $bodyEmail .= '<td><strong>Quantide</strong></td>';
              $bodyEmail .= '<th><strong>Valor Unitario</strong></th>';
              $bodyEmail .= '<td><strong>Total</strong></td>';
            $bodyEmail .= '</tr>';

            $bodyEmail .= $corpoEmail;

            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';             
            $bodyEmail .= '</tr>';

            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';
              $bodyEmail .= '<th colspan="2">&nbsp;</th>';             
            $bodyEmail .= '</tr>';

            $bodyEmail .= '<tr>';
              $bodyEmail .= '<th colspan="2">Acumulado Geral Devedor: R$ '.$totalDevedorGeral.'</th>';
              $bodyEmail .= '<th colspan="2">Valor da Compra: R$ '.number_format($totalVenda,2,",").'</th>';             
            $bodyEmail .= '</tr>';

        $bodyEmail .= '</table>';

        $bodyEmail .= "<br>";
        $bodyEmail .= "<br>";
        $bodyEmail .= '<h3>Obrigado!</h3>';

        return $bodyEmail;
    }

    function emailHtmlPagamento($db, $idUsuario, $nomeUsuario,$totalDevedorGeral){
        $bodyEmail = null;
        $bodyEmail .= "<h3>Prezado(a),/h3>";
        $bodyEmail .= "<br>";
        $bodyEmail .= "<h3>".$nomeUsuario.", sua divida Total de R$ ".$totalDevedorGeral." foi paga!</h3>";
        $bodyEmail .= "<br>";
        $bodyEmail .= "<br>";
        $bodyEmail .= '<h3>Obrigado!</h3>';

        return $bodyEmail;
    }

    //--------------------------------REDIMENCIONA TAMANHO DA FOTO----------------------------------//
    function resizeImage($filename,$newFile){
       $width = 200;
       $height = 200;

       // Obtendo o tamanho original
       list($width_orig, $height_orig) = getimagesize($filename);

       // Calculando a proporção
       $ratio_orig = $width_orig/$height_orig;

       if ($width/$height > $ratio_orig) {
          $width = $height*$ratio_orig;
       } else {
          $height = $width/$ratio_orig;
       }

       // O resize propriamente dito. Na verdade, estamos gerando uma nova imagem.
       $image_p = imagecreatetruecolor($width, $height);
       $image = imagecreatefromjpeg($filename);
       imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

       imagejpeg($image_p, $newFile, 75);
    }