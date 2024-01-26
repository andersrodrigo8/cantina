<?php
    $db = null;
    include ('funcao.php');
?>

<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> Copinha </title>
		<meta name="description" content="">
		<meta name="author" content="">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/smartadmin-rtl.min.css"> 

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/demo.min.css">

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

	</head>

<body class="desktop-detected menu-on-top pace-done">
 
	<?php include('topo.php'); ?>

	<!-- MAIN PANEL -->
	<div  role="main">		

		<!-- MAIN CONTENT -->
		<div id="content">

			<!-- row -->
			<div class="row">
				
				<!-- col -->
				<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
					<h1 class="page-title txt-color-blueDark">
						
						<!-- PAGE HEADER -->
						<i class="fa-fw fa fa-home"></i> 
							E-commerce
						<span>>  
							Products View
						</span>
					</h1>
				</div>
				<!-- end col -->
				
			</div>
			<!-- end row -->

			<!-- widget grid -->
			<section id="widget-grid" class="">

				<!-- row -->

				<div class="row" id="tabelaMostruario">
                    <?php $queryProdutos = selectAllProdutos($db);
                    foreach ($queryProdutos as $resultado) { ?>                        
                        <div class="col-sm-6 col-md-6 col-lg-4" >
                            <!-- product -->
                            <div class="product-content product-wrap clearfix">
                                <div class="row">
                                        <div class="col-md-5 col-sm-12 col-xs-12">
                                            <div class="product-image">
                                                <!--<img src="<?php echo $resultado['pathfoto'];?>" width=200 height=200 class="img-responsive"> -->
                                                <img src="<?php echo $resultado['pathfoto'];?>" width=194 height=228> 
                                                <?php if($resultado['promocao']){ ?>
                                                    <span class="tag2 hot" title="O Gerente Ficou Doido, PROMOÇÃO!">
                                                        Prom.
                                                    </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                        <div class="product-deatil">
                                                <h5 class="name">
                                                    <strong>
                                                        <?php echo $resultado['titulo']; ?>
                                                    </strong>
                                                </h5>
                                                <p class="price-container">
                                                    <span>R$ <?php echo number_format($resultado['valor'],2,","); ?></span>
                                                </p>
                                                <span class="tag1"></span>
                                        </div>
                                        <div class="description">
                                            <?php echo $resultado['descricao']; ?>
                                            <select class="form-control" id="Quantidade_<?php echo $resultado['id']; ?>">
                                            	<?php for($i=1; $i<=$resultado['quantidade']; $i++) {
	                                            	echo '<option value="'.$i.'">'.$i.'</option>';
	                                            } ?>
	                                        </select>
                                            <br>
                                            <a title="Comprar" id="<?php echo $resultado['id']; ?>" onClick="CarregaProduto(this.id);" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-money"></i> Comprar</a>
                                            <a title="Carrinho" onclick="cesta(this.id);" id="cesta_<?php echo $resultado['id']; ?>" class="btn btn-info btn-lg"><i class="fa fa-shopping-basket"></i> Adicionar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end product -->
                        </div>
                    <?php } ?>
				</div>

				<!-- end row -->

			</section>
			<!-- end widget grid -->

            <div class="row">

                <!-- a blank row to get started -->
                <div class="col-sm-12">
                    <br>
                </div>

            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Confirmação Crompra</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">

                                    <input type="hidden" class="form-control" id="idproduto" value=""/>
                                    <input type="hidden" class="form-control" id="qtaselecionada" value=""/>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="produtotitulo" autocomplete="off" value="" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="valorunit" autocomplete="off" value="" readonly/>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="valortotal" autocomplete="off" value="" readonly/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tags"> Senha </label>
                                        <input type="numeric" autocomplete="off" class="form-control" id="Senha" placeholder="Senha" value="" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="efetuarCompra(<?php echo $resultado['id']; ?>)" class="btn btn-success"><i class="fa fa-money"></i>
                                Comprar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="CancelarModal"><i class="fa fa-trash"></i>
                                Cancelar
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Confirmação Crompra Carrinho</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="tabelaCarrinho">



                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tags"> Senha </label>
                                        <input type="numeric" autocomplete="off" class="form-control" id="Senha2" placeholder="Senha" value="" />
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="comprarcesta();"  class="btn btn-success"><i class="fa fa-money"></i>
                                Comprar
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="CancelarModal2"><i class="fa fa-trash"></i>
                                Cancelar
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

		</div>
		<!-- END MAIN CONTENT -->

	
	<!-- END MAIN PANEL -->

	<?php include('rodape.php'); ?>
 

	<!--================================================== -->

	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
	<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script><script data-pace-options="{ &quot;restartOnRequestAfter&quot;: true }" src="js/plugin/pace/pace.min.js"></script>

	<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		if (!window.jQuery) {
			document.write('<script src="js/libs/jquery-3.2.1.min.js"><\/script>');
		}
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script>
		if (!window.jQuery.ui) {
			document.write('<script src="js/libs/jquery-ui.min.js"><\/script>');
		}
	</script>

	<!-- IMPORTANT: APP CONFIG -->
	<script src="js/app.config.js"></script>

	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
	<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

	<!-- BOOTSTRAP JS -->
	<script src="js/bootstrap/bootstrap.min.js"></script>

	<!-- CUSTOM NOTIFICATION -->
	<script src="js/notification/SmartNotification.min.js"></script>

	<!-- JARVIS WIDGETS -->
	<script src="js/smartwidgets/jarvis.widget.min.js"></script>

	<!-- EASY PIE CHARTS -->
	<script src="js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

	<!-- SPARKLINES -->
	<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>

	<!-- JQUERY VALIDATE -->
	<script src="js/plugin/jquery-validate/jquery.validate.min.js"></script>

	<!-- JQUERY MASKED INPUT -->
	<script src="js/plugin/masked-input/jquery.maskedinput.min.js"></script>

	<!-- JQUERY SELECT2 INPUT -->
	<script src="js/plugin/select2/select2.min.js"></script>

	<!-- JQUERY UI + Bootstrap Slider -->
	<script src="js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

	<!-- browser msie issue fix -->
	<script src="js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

	<!-- FastClick: For mobile devices -->
	<script src="js/plugin/fastclick/fastclick.min.js"></script>

	<!--[if IE 8]>

	<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

	<![endif]-->

	<!-- Demo purpose only -->
	<script src="js/demo.min.js"></script>

	<!-- MAIN APP JS FILE -->
	<script src="js/app.min.js"></script>

	<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
	<!-- Voice command : plugin -->
	<script src="js/speech/voicecommand.min.js"></script><div class="modal fade" id="voiceModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"></div></div></div>

	<!-- SmartChat UI : plugin -->
	<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
	<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

	<!-- PAGE RELATED PLUGIN(S) 
	<script src="..."></script>-->

	<script>
        var cestaCompra = [];

		$(document).ready(function() {
			
			 pageSetUp();
			
		});

		$('#CancelarModal').click(function(){
            location.reload();
		});

        $('#CancelarModal2').click(function(){
            location.reload();
        });

        function limparDados(){
            document.getElementById("idproduto").value = null;
            document.getElementById("produtotitulo").value = null;
            document.getElementById("valorunit").value = null;
            document.getElementById("valortotal").value = null;
        }

        function CarregaProduto(id){
            limparDados();
            $.post("eventos.php",{id:id, evento:'SelecionaProduto'}, function (data){
                if((data.length > 0) || typeof(data) !== "undefined"){
                    var MeuObjeto = JSON.parse(data);

                    var select = document.getElementById("Quantidade_"+id);
            		var text = select.options[select.selectedIndex].text;

            		document.getElementById("qtaselecionada").value = text;
                    document.getElementById("idproduto").value = id;
                    document.getElementById("produtotitulo").value = MeuObjeto[0].titulo;
                    document.getElementById("valorunit").value = MeuObjeto[0].valor; 
                    document.getElementById("valortotal").value = parseFloat(MeuObjeto[0].valor) * parseFloat(text);
                }
            });
        }

        function efetuarCompra(id){
            var qtdselecionado = document.getElementById("qtaselecionada").value;
            var idproduto = document.getElementById("idproduto").value;
            var password = document.getElementById("Senha").value;
            
            arrayCompra = []; 

            var valueToPush = { };  
            valueToPush["id"] = idproduto;
            valueToPush["qtd"] = qtdselecionado;

            arrayCompra.push(valueToPush);

            if(password.length > 0) {
                $.post("eventos.php", {idProduto: arrayCompra, password: password, evento: 'CompraProduto'}, function (data) {
                    if((data.length > 0) || typeof(data) !== "undefined"){
                        var MeuObjeto = JSON.parse(data);

                        if(MeuObjeto[0].status == 'SUCESSO') {
                            $.bigBox({
                                title: "AVISO COMPRA",
                                content: "COMPRA EFETUADA COM SUCESSO " + MeuObjeto[0].msg +", FOI ENCAMINHADO EMAIL DE CONFIRMAÇÃO",
                                color: "#3276B1",
                                icon: "fa fa-bell swing animated",
                                timeout: 15000
                            });

                            var bodyEmail = MeuObjeto[0].bodyEmail; 
                            var emailUsuario = MeuObjeto[0].emailUsuario;
                            var subjectemail = MeuObjeto[0].subjectemail;

                            $.post("email_send.php",{bodyEmail:bodyEmail,emailUsuario:emailUsuario,subjectemail:subjectemail}, function (data){
				                console.log(data);
				            });

                            $('#tabelaMostruario').empty();
                            $('#tabelaMostruario').append(MeuObjeto[0].html);

                        }else{
                            $.bigBox({
                                title: "AVISO COMPRA",
                                content: "ERRO AO REALIZAR A COMPRA " + MeuObjeto[0].msg,
                                color: "#C46A69",
                                icon: "fa fa-warning shake animated",
                                timeout: 15000
                            });
                        }
                    } else {
                        $.bigBox({
                            title: "AVISO COMPRA",
                            content: "ERRO AO REALIZAR A COMPRA VERIFIQUE OS DADOS",
                            color: "#C46A69",
                            icon: "fa fa-warning shake animated",
                            timeout: 15000
                        });
                    }
                });
            }else{
                $.bigBox({
                    title: "AVISO COMPRA",
                    content: "ERRO AO REALIZAR A COMPRA A SENHA NÃO FOI INFORMADA",
                    color: "#C46A69",
                    icon: "fa fa-warning shake animated",
                    timeout: 15000
                });
            }
            limparDados();
            $('#myModal').modal('hide');
        }

        function cesta(id){
            var idProduto = id.replace('cesta_',"");
            let select = document.getElementById("Quantidade_"+idProduto);
            let text = select.options[select.selectedIndex].text;

            var valueToPush = { };  
            valueToPush["id"] = idProduto;
            valueToPush["qtd"] = text;

            cestaCompra.push(valueToPush);

            $.post("eventos.php",{idProd:cestaCompra, evento:'CriandoCarrinho'}, function (data){
                if((data.length > 0) || typeof(data) !== "undefined"){
                    var MeuObjeto = JSON.parse(data);

                    if(MeuObjeto[0].status == 'SUCESSO') {
                        $('#carrinhocompras').empty();
                        $('#carrinhocompras').append(MeuObjeto[0].html);

                        $('#tabelaCarrinho').empty();
                        $('#tabelaCarrinho').append(MeuObjeto[0].carrinho);

                        $('#carrinho').removeClass('hidden');

                        $('#totalCesta').empty();
                        $('#totalCesta').append(MeuObjeto[0].totalCesta);
                    }
                }
            });
        }

        function comprarcesta(){

            var password2 = document.getElementById("Senha2").value;

            if(password2.length > 0) {
                $.post("eventos.php", {idProduto: cestaCompra, password: password2, evento: 'CompraProduto'}, function (data) {
                    if((data.length > 0) || typeof(data) !== "undefined"){
                        var MeuObjeto = JSON.parse(data);

                        if(MeuObjeto[0].status == 'SUCESSO') {
                            $.bigBox({
                                title: "AVISO COMPRA",
                                content: "COMPRA EFETUADA COM SUCESSO " + MeuObjeto[0].msg +", FOI ENCAMINHADO EMAIL DE CONFIRMAÇÃO",
                                color: "#3276B1",
                                icon: "fa fa-bell swing animated",
                                timeout: 15000
                            });

                            var bodyEmail = MeuObjeto[0].bodyEmail; 
                            var emailUsuario = MeuObjeto[0].emailUsuario;
                            var subjectemail = MeuObjeto[0].subjectemail;

                            $.post("email_send.php",{bodyEmail:bodyEmail,emailUsuario:emailUsuario,subjectemail:subjectemail}, function (data){
				                console.log(data);
				            });

                            $('#tabelaMostruario').empty();
                            $('#tabelaMostruario').append(MeuObjeto[0].html);

                        }
                    }
                });
            } 
            
            location.reload();
        }
	</script>

	<!-- Your GOOGLE ANALYTICS CODE Below -->
	<script>
		var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
			_gaq.push(['_trackPageview']);
		
		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();

	</script>
	
	</div>
</body>
</html>