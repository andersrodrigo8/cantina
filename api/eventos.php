<?php
    $db = null;
    include('funcao.php');

    if(isset($_POST['id']) && !empty($_POST['id'])){

        if(isset($_POST['evento']) && $_POST['evento'] == 'SelecionaProduto'){
            $querySelecionado = selectFindProdutos($db, $_POST['id']);
            if(!empty($querySelecionado['id'])){
                $Array[0]['id'] = $querySelecionado['id'];
                $Array[0]['titulo'] = $querySelecionado['titulo'];
                $Array[0]['quantidade'] = $querySelecionado['quantidade'];
                $Array[0]['valor'] = number_format($querySelecionado['valor'],2,",");
                $totalValor = $_POST['qtdSelect'] * $querySelecionado['valor'];
                $Array[0]['totalvalor'] = number_format($totalValor,2,",");
                echo json_encode($Array);
            }else{
                echo 'error';
            }
        }

        if(isset($_POST['evento']) && $_POST['evento'] == 'Pagamento'){
            $totalDevedorGeral = selectFindUsuarioIdValor($db,$_POST['id']);

            $sqlPagamentos = "UPDATE public.tbvenda SET status = 'PAGO', databaixa = NOW() WHERE status = 'PENDENTE' AND usua_id = " . $_POST['id'];
            alterarRegistro($db, $sqlPagamentos);

            $queryUsuario = selectFindUsuarioId($db,$_POST['id']);
            $nomeUsuario = $queryUsuario['nome'];
            $emailUsuario = $queryUsuario['email'];

            $bodyEmail = emailHtmlPagamento($db, $_POST['id'], $nomeUsuario, $totalDevedorGeral);

            $Array[0]['status'] = 'SUCESSO';
            $Array[0]['msg'] = 'PAGAMENTO REALIZADO';
            $Array[0]['bodyEmail'] = $bodyEmail; 
            $Array[0]['emailUsuario'] = $emailUsuario;
            $Array[0]['subjectemail'] = "PAGAMENTO CONFIRMADO DA COPINHA";

            echo json_encode($Array);
        }

        if(isset($_POST['evento']) && $_POST['evento'] == 'SelecionaVencimento'){
            $produtos = selectProdutoValidade($db);

            if(!empty($produtos)){
                $Array[0]['status'] = 'VENCENDO';
                $Array[0]['produtos'] = $produtos;
            }else{
                $Array[0]['status'] = 'NORMAL';
                $Array[0]['produtos'] = 'NORMAL';
            }

            echo json_encode($Array);
        }

    }

    if(isset($_POST['evento']) && $_POST['evento'] == 'CompraProduto'){
        $queryUsuario = selectFindUsuario($db,$_POST['password']);
        $idUsuario = $queryUsuario['id'];
        $nomeUsuario = $queryUsuario['nome'];
        $emailUsuario = $queryUsuario['email'];
        $idProd = $_POST['idProduto'];
        
        if(!empty($queryUsuario['id'])){  

            $insertVenda = "INSERT INTO public.tbvenda(datavenda, status, usua_id) VALUES (NOW(), 'PENDENTE', $idUsuario) RETURNING id;";
            $vendaConfirmada = inserirRegistroReturning($db, $insertVenda);
            $corpoEmail = null;
           
            if(count($idProd) > 0){
                $totalVenda = 0;
                for($i=0; $i<count($idProd); $i++) {
                    $id = $idProd[$i]['id'];
                    $qtd = $idProd[$i]['qtd'];
                    $querySelecionado = selectFindProdutos($db, $id);

                    if($querySelecionado['quantidade'] >= $qtd){

                        $quantiEstoque = $querySelecionado['quantidade'] - $qtd;
                        $valorVenda = $qtd * $querySelecionado['valor'];
                        $precoUnitario = $querySelecionado['valor'];
                        $titulo = $querySelecionado['titulo'];
                        $totalVenda = $totalVenda + $valorVenda;

                        $insertItens = "INSERT INTO public.tbvendaitens (usua_id, prod_id, vend_id, quantidade, valorunit, valortotal, datavenda) VALUES (".$idUsuario.", ".$id.", ".$vendaConfirmada['id'].", ".$qtd.", ".$precoUnitario.", ". $valorVenda.", NOW()) RETURNING id;";
                        $vendaItenConfirmada = inserirRegistroReturning($db, $insertItens);

                        if($vendaItenConfirmada['id'] > 0){
                            $sqlEstoque = "UPDATE public.tbproduto SET quantidade = ".$quantiEstoque." WHERE id = " . $id;
                            alterarRegistro($db, $sqlEstoque);

                            $corpoEmail .= '<tr>';
                              $corpoEmail .= '<th><strong>'.$titulo.'</strong></th>';
                              $corpoEmail .= '<td><strong>'.$qtd.'</strong></td>';
                              $corpoEmail .= '<th><strong>R$ '.number_format($precoUnitario,2,",").'</strong></th>';
                              $corpoEmail .= '<td><strong>R$ '.number_format($valorVenda,2,",").'</strong></td>';
                            $corpoEmail .= '</tr>';

                        }else{
                            $Array[0]['status'] = 'ERROR';
                            $Array[0]['msg'] = 'ERRO NA VENDA';
                        }
                        

                    }else{
                        $Array[0]['status'] = 'ERROR';
                        $Array[0]['msg'] = 'QUATIDADE ACIMA DO ESTOQUE';
                    }

                }

                if($vendaConfirmada['id'] > 0 && !empty($corpoEmail)){
                    $idVenda = $vendaConfirmada['id'];
                    $bodyEmail = emailHtmlCompra($db, $idUsuario, $nomeUsuario, $idVenda, $corpoEmail, $totalVenda);   

                    $html = carregaHtml($db);

                    $Array[0]['status'] = 'SUCESSO';
                    $Array[0]['msg'] = 'PRODUTO LIBERADO';
                    $Array[0]['html'] = $html;
                    $Array[0]['bodyEmail'] = $bodyEmail; 
                    $Array[0]['emailUsuario'] = $emailUsuario;
                    $Array[0]['subjectemail'] = "COMPRANDO NA COPINHA";
                }else{
                    $Array[0]['status'] = 'ERROR';
                    $Array[0]['msg'] = 'ERRO NA VENDA';
                }
            }else{
                $Array[0]['status'] = 'ERROR';
                $Array[0]['msg'] = 'PRODUTO FORA DO ESTOQUE';
            }
        }else{
            $Array[0]['status'] = 'ERROR';
            $Array[0]['msg'] = 'ERRO DE SENHA OU USUARIO NÃO CADASTRADO';
        }
        
        echo json_encode($Array);
    }

    if(isset($_POST['evento']) && $_POST['evento'] == 'CriandoCarrinho'){
        $j=0;
        $idProd = $_POST['idProd'];
        $htmlTabela = null;
        if(count($idProd) > 0) {
            $html = null;
            $htmlB = null;
            for($i=0; $i<count($idProd); $i++){
                $queryProdutos = selectFindProdutos($db, $idProd[$i]['id']);
                if(!empty($queryProdutos['id'])){
                    $htmlB .= '<li>';
                        $htmlB .= '<a href="#"><img src="'.$queryProdutos['pathfoto'].'" class="flag flag-us" alt="United States"> '.$queryProdutos['titulo'].' &emsp;&emsp; '.$idProd[$i]['qtd'].'x </a>';
                    $htmlB .= '</li>';
                    $j++;
                    $carrinho .= '<tr>';
                        $carrinho .= '<td><img src="'.$queryProdutos['pathfoto'].'" class="flag flag-us" alt="United States"></td>';
                        $carrinho .= '<td>'.$queryProdutos['titulo'].'</td>';
                        $carrinho .= '<td>'.$idProd[$i]['qtd'].'x</td>';
                    $carrinho .= '</tr>';
                }
            }

            $htmlTabela .= '<table style="width: 100%">';
                $htmlTabela .= '<tr>';
                    $htmlTabela .= '<th>Foto</th>';
                    $htmlTabela .= '<th>Produto</th>';
                    $htmlTabela .= '<th>Quantidade</th>';
                $htmlTabela .= '</tr>';
                $htmlTabela .= $carrinho;
            $htmlTabela .= '</table>';

            /*$html .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-shopping-basket"></i> <b class="badge"> '.$j.' </b>  </a>';
            $html .= '<ul class="dropdown-menu pull-right">';
                $html .= $htmlB;
                $html .= '<li>';
                    $html .= '<hr>';
                $html .= '</li>';
                $html .= '<li class="text-align-center">';
                    $html .= '<footer>';
                        $html .= '<a title="Fechar Compra" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">';
                            $html .= '<i class="fa fa-money"></i>';
                        $html .= '</a>&emsp;';
                        $html .= '<a href="index.php" title="Limpar Carinho" class="btn btn-danger">';
                            $html .= '<i class="fa fa-trash"></i>';
                        $html .= '</a>';
                    $html .= '</footer>';
                $html .= '</li>';
            $html .= '</ul>';*/

            $html .= $htmlB;
            $html .= '<li>';
                $html .= '<hr>';
            $html .= '</li>';
            $html .= '<li class="text-align-center">';                
                $html .= '<a title="Fechar Compra" data-toggle="modal" data-target="#myModal2" class="btn btn-primary">';
                    $html .= '<i class="fa fa-money"></i>';
                $html .= '</a>&emsp;';
                $html .= '<a href="index.php" title="Limpar Carinho" class="btn btn-danger">';
                    $html .= '<i class="fa fa-trash"></i>';
                $html .= '</a>';                
            $html .= '</li>';

            $Array[0]['status'] = 'SUCESSO';
            $Array[0]['html'] = $html;
            $Array[0]['carrinho'] = $htmlTabela;
            $Array[0]['totalCesta'] = '<em>'.count($idProd).'</em>';
        }

        echo json_encode($Array);
    }

    if(isset($_POST['evento']) && $_POST['evento'] == 'Grafico'){
        $sqlGrafico = " select 
                            tbvendaitens.valortotal,
                            EXTRACT(MONTH FROM tbvendaitens.datavenda) as mes
                        from 
                            public.tbvendaitens 
			WHERE
                            tbvendaitens.datavenda BETWEEN '".date('Y')."-01-01 00:00:01' AND '".date('Y')."-12-31 23:59:59'
                        order by
                            tbvendaitens.datavenda asc";
        /*$sqlGrafico = "select 
                            tbvendaitens.valortotal,
                            EXTRACT(MONTH FROM tbvenda.datavenda) as mes
                        from 
                            public.tbvenda,
                            public.tbvendaitens 
                        where
                            tbvenda.id = tbvendaitens.id 
                        order by
                            tbvenda.datavenda asc";*/
        $queryGrafico = selectpadrao($db,$sqlGrafico);

        $soma1 = null;
        $soma2 = null;
        $soma3 = null;
        $soma4 = null;
        $soma5 = null;
        $soma6 = null;
        $soma7 = null;
        $soma8 = null;
        $soma9 = null;
        $soma10 = null;
        $soma11 = null;
        $soma12 = null;

        $arrayMes = array();

        foreach($queryGrafico as $result){
            if($result['mes'] == 1){
                $soma1 = $soma1 + $result['valortotal'];
            }

            if($result['mes'] == 2){
                $soma2 = $soma2 + $result['valortotal'];
            }

            if($result['mes'] == 3){
                $soma3 = $soma3 + $result['valortotal'];
            }

            if($result['mes'] == 4){
                $soma4 = $soma4 + $result['valortotal'];
            }

            if($result['mes'] == 5){
                $soma5 = $soma5 + $result['valortotal'];
            }

            if($result['mes'] == 6){
                $soma6 = $soma6 + $result['valortotal'];
            }

            if($result['mes'] == 7){
                $soma7 = $soma7 + $result['valortotal'];
            }

            if($result['mes'] == 8){
                $soma8 = $soma8 + $result['valortotal'];
            }

            if($result['mes'] == 9){
                $soma9 = $soma9 + $result['valortotal'];
            }

            if($result['mes'] == 10){
                $soma10 = $soma10 + $result['valortotal'];
            }

            if($result['mes'] == 11){
                $soma11 = $soma11 + $result['valortotal'];
            }

            if($result['mes'] == 12){
                $soma12 = $soma12 + $result['valortotal'];
            }
        }

        $linha = 0;

        if(!empty($soma1)){
            $arrayMes[$linha]['x'] = 'Janeiro';
            $arrayMes[$linha]['y'] = round($soma1,2);
            $linha++;
        }

        if(!empty($soma2)){
            $arrayMes[$linha]['x'] = 'Fevereiro';
            $arrayMes[$linha]['y'] = round($soma2,2);
            $linha++;
        }

        if(!empty($soma3)){
            $arrayMes[$linha]['x'] = 'Marco';
            $arrayMes[$linha]['y'] = round($soma3,2);
            $linha++;
        }

        if(!empty($soma4)){
            $arrayMes[$linha]['x'] = 'Abril';
            $arrayMes[$linha]['y'] = round($soma4,2);
            $linha++;
        }

        if(!empty($soma5)){
            $arrayMes[$linha]['x'] = 'Maio';
            $arrayMes[$linha]['y'] = round($soma5,2);
            $linha++;
        }

        if(!empty($soma6)){
            $arrayMes[$linha]['x'] = 'Junho';
            $arrayMes[$linha]['y'] = round($soma6,2);
            $linha++;
        }

        if(!empty($soma7)){
            $arrayMes[$linha]['x'] = 'Julho';
            $arrayMes[$linha]['y'] = round($soma7,2);
            $linha++;
        }

        if(!empty($soma8)){
            $arrayMes[$linha]['x'] = 'Agosto';
            $arrayMes[$linha]['y'] = round($soma8,2);
            $linha++;
        }

        if(!empty($soma9)){
            $arrayMes[$linha]['x'] = 'Setembro';
            $arrayMes[$linha]['y'] = round($soma9,2);
            $linha++;
        }

        if(!empty($soma10)){
            $arrayMes[$linha]['x'] = 'Outubro';
            $arrayMes[$linha]['y'] = round($soma10,2);
            $linha++;
        }

        if(!empty($soma11)){
            $arrayMes[$linha]['x'] = 'Novembro';
            $arrayMes[$linha]['y'] = round($soma11,2);
            $linha++;
        }

        if(!empty($soma12)){
            $arrayMes[$linha]['x'] = 'Dezembro';
            $arrayMes[$linha]['y'] = $soma12;
        }

        echo json_encode($arrayMes);
    }

    if(isset($_POST['evento']) && $_POST['evento'] == 'GraficoUsuario'){
        $sqlGrafico = " SELECT 
                            tbvendaitens.valortotal,
                            EXTRACT(MONTH FROM tbvendaitens.datavenda) as mes
                        FROM 
                            public.tbvendaitens,
                            public.tbusuario, 
                            public.tbvenda
                        WHERE
                            tbvendaitens.vend_id = tbvenda.id AND
                            tbusuario.id = tbvendaitens.usua_id AND
                            tbvendaitens.datavenda BETWEEN '".date('Y')."-01-01 00:00:01' AND '".date('Y')."-12-31 23:59:59' AND
                            tbvendaitens.usua_id = " . $_POST['usuaID'] . "
                        ORDER BY
                            tbvendaitens.datavenda asc";
        /*$sqlGrafico = "select 
                            tbvendaitens.valortotal,
                            EXTRACT(MONTH FROM tbvenda.datavenda) as mes
                        from 
                            public.tbvenda,
                            public.tbvendaitens 
                        where
                            tbvenda.id = tbvendaitens.id 
                        order by
                            tbvenda.datavenda asc";*/
        $queryGrafico = selectpadrao($db,$sqlGrafico);

        $soma1 = null;
        $soma2 = null;
        $soma3 = null;
        $soma4 = null;
        $soma5 = null;
        $soma6 = null;
        $soma7 = null;
        $soma8 = null;
        $soma9 = null;
        $soma10 = null;
        $soma11 = null;
        $soma12 = null;

        $arrayMes = array();

        foreach($queryGrafico as $result){
            if($result['mes'] == 1){
                $soma1 = $soma1 + $result['valortotal'];
            }

            if($result['mes'] == 2){
                $soma2 = $soma2 + $result['valortotal'];
            }

            if($result['mes'] == 3){
                $soma3 = $soma3 + $result['valortotal'];
            }

            if($result['mes'] == 4){
                $soma4 = $soma4 + $result['valortotal'];
            }

            if($result['mes'] == 5){
                $soma5 = $soma5 + $result['valortotal'];
            }

            if($result['mes'] == 6){
                $soma6 = $soma6 + $result['valortotal'];
            }

            if($result['mes'] == 7){
                $soma7 = $soma7 + $result['valortotal'];
            }

            if($result['mes'] == 8){
                $soma8 = $soma8 + $result['valortotal'];
            }

            if($result['mes'] == 9){
                $soma9 = $soma9 + $result['valortotal'];
            }

            if($result['mes'] == 10){
                $soma10 = $soma10 + $result['valortotal'];
            }

            if($result['mes'] == 11){
                $soma11 = $soma11 + $result['valortotal'];
            }

            if($result['mes'] == 12){
                $soma12 = $soma12 + $result['valortotal'];
            }
        }

        $linha = 0;

        if(!empty($soma1)){
            $arrayMes[$linha]['x'] = 'Janeiro';
            $arrayMes[$linha]['y'] = round($soma1,2);
            $linha++;
        }

        if(!empty($soma2)){
            $arrayMes[$linha]['x'] = 'Fevereiro';
            $arrayMes[$linha]['y'] = round($soma2,2);
            $linha++;
        }

        if(!empty($soma3)){
            $arrayMes[$linha]['x'] = 'Marco';
            $arrayMes[$linha]['y'] = round($soma3,2);
            $linha++;
        }

        if(!empty($soma4)){
            $arrayMes[$linha]['x'] = 'Abril';
            $arrayMes[$linha]['y'] = round($soma4,2);
            $linha++;
        }

        if(!empty($soma5)){
            $arrayMes[$linha]['x'] = 'Maio';
            $arrayMes[$linha]['y'] = round($soma5,2);
            $linha++;
        }

        if(!empty($soma6)){
            $arrayMes[$linha]['x'] = 'Junho';
            $arrayMes[$linha]['y'] = round($soma6,2);
            $linha++;
        }

        if(!empty($soma7)){
            $arrayMes[$linha]['x'] = 'Julho';
            $arrayMes[$linha]['y'] = round($soma7,2);
            $linha++;
        }

        if(!empty($soma8)){
            $arrayMes[$linha]['x'] = 'Agosto';
            $arrayMes[$linha]['y'] = round($soma8,2);
            $linha++;
        }

        if(!empty($soma9)){
            $arrayMes[$linha]['x'] = 'Setembro';
            $arrayMes[$linha]['y'] = round($soma9,2);
            $linha++;
        }

        if(!empty($soma10)){
            $arrayMes[$linha]['x'] = 'Outubro';
            $arrayMes[$linha]['y'] = round($soma10,2);
            $linha++;
        }

        if(!empty($soma11)){
            $arrayMes[$linha]['x'] = 'Novembro';
            $arrayMes[$linha]['y'] = round($soma11,2);
            $linha++;
        }

        if(!empty($soma12)){
            $arrayMes[$linha]['x'] = 'Dezembro';
            $arrayMes[$linha]['y'] = $soma12;
        }

        echo json_encode($arrayMes);
    }

    function carregaHtml($db){
        $queryProdutos = selectAllProdutos($db);
        $html = null;
        foreach ($queryProdutos as $resultado) {  
            $html .= '<div class="col-sm-6 col-md-6 col-lg-4" id="tabelaMostruario">';
                $html .= '<div class="product-content product-wrap clearfix">';
                    $html .= '<div class="row">';
                            $html .= '<div class="col-md-5 col-sm-12 col-xs-12">';
                                $html .= '<div class="product-image">';
                                    //$html .= '<img src="'.$resultado['pathfoto'].'" width=200 height=200 alt="194x228" class="img-responsive">';
                                    $html .= '<img title="'.$resultado['descricao'].'" src="'.$resultado['pathfoto'].'" width=194 height=228>';
                                    if($resultado['promocao']){
                                        $html .= '<span class="tag2 hot" title="O Gerente Ficou Doido, PROMOÇÃO!">';
                                            $html .= 'Prom.';
                                        $html .= '</span>';
                                    }
                                $html .= '</div>';
                            $html .= '</div>';
                            $html .= '<div class="col-md-7 col-sm-12 col-xs-12">';
                            $html .= '<div class="product-deatil">';
                                    $html .= '<h5 class="name">';
                                        $html .= '<strong>';
                                            $html .= $resultado['titulo'];
                                        $html .= '</strong>';
                                    $html .= '</h5>';
                                    $html .= '<p class="price-container">';
                                        $html .= '<span>R$ '.number_format($resultado['valor'],2,",");
                                    $html .= '</p>';
                                    $html .= '<span class="tag1"></span>';
                            $html .= '</div>';
                            $html .= '<div class="description">';
                                $html .= $resultado['descricao']; 
                                $html .= '<select class="form-control" id="Quantidade_'.$resultado['id'].'">';
                                    for($i=1; $i<=$resultado['quantidade']; $i++) {
                                        $html .=  '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                $html .= '</select>';
                                $html .= '<br>';
                                $html .= '<a title="Comprar" id="'.$resultado['id'].'" onClick="CarregaProduto(this.id);" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-money"></i>  Comprar</a> ';
                                //$html .= '<a title="Carrinho" onclick="cesta(this.id);" id="cesta_'.$resultado['id'].'" class="btn btn-info btn-lg"><i class="fa fa-shopping-basket"></i> Adicionar</a>';
                            $html .= '</div>';
                        $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';
        } 
        return $html;
    }
