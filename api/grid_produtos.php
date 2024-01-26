<?php
    $db = null;
	include('funcao.php'); 
	$totalGastoGeral = somaTotalGastoProdutos($db);
	$totalProdutos = somaQuantidadeProdutoEstoque($db);
	$totalValorEstoque = somaTotaldosValoresEstoque($db);
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<title> Produtos Grid </title>
		<meta name="description" content="">
		<meta name="author" content="">
			
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
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

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">


	</head>


	<body class="desktop-detected menu-on-top pace-done">

		<!-- #NAVIGATION -->
		<?php include('topo.php'); ?>
		<!-- END NAVIGATION -->

		<!-- MAIN PANEL -->
		<div role="main">

			
			<!-- MAIN CONTENT -->
			<div id="content">

				<!-- row -->
				<div class="row">
					
					<!-- col -->
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							
							<!-- PAGE HEADER -->
							<i class="fa-fw fa fa-home"></i> 
								Page Header 
							<span>>  
								Subtitle
							</span>
						</h1>
					</div>
					<!-- end col -->					
				</div>
				<!-- end row -->

				<!-- widget grid -->
				<section id="widget-grid" class="">
					 <?php if (isset($status) && $status == 'Success') { ?>
                            <div class="alert alert-success fade in">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa-fw fa fa-check"></i>
                                <strong>Sucesso</strong> Registro Realizado com Sucesso!
                            </div>
                        <?php }
                        if (isset($status) && $status == 'Error') { ?>
                            <div class="alert alert-danger fade in">
                                <button class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa-fw fa fa-times"></i>
                                <strong>Erro!</strong> Registro Gerou Errro!
                            </div>
                        <?php } ?>
					<div class="row">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
							<h1 class="page-title txt-color-blueDark">
								<i class="fa fa-table fa-fw "></i> 
									Protutos
							</h1>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
							<ul id="sparks" class="">
								<li class="sparks-info">
									<h5> Investimento <span class="txt-color-blue">R$ <?php echo number_format($totalGastoGeral,2,","); ?></span></h5> 
								</li> 
								<li class="sparks-info">
                                    					<h5> Valor Estoque <span class="txt-color-orange">R$ <?php echo number_format($totalValorEstoque,2,","); ?></span></h5>
                                				</li>
								<li class="sparks-info">
									<h5> Produtos Estoque <span class="txt-color-greenDark"><i class="fa fa-shopping-cart"></i>&nbsp;<?php echo $totalProdutos; ?></span></h5>
								</li>
							</ul>
						</div>
					</div>

					<!-- row -->
					<div class="row">
						
						<!-- NEW WIDGET START -->
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
 
								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2> <a href="pop_produtos.php" class="btn btn-info btn-xs" >Produtos Novos </a> </h2>

								</header>

								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>
									<!-- end widget edit box -->

									<!-- widget content -->
									<div class="widget-body no-padding">

										<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
					
									        <thead>
												<tr>
													<th class="hasinput" style="width:10%">
													</th>
													<th class="hasinput" style="width:12%">
														<input type="text" class="form-control" placeholder="Descrição" />
													</th>
													<th class="hasinput icon-addon">
														<input id="dateselect_filter" type="text" placeholder="Data Validade" class="form-control datepicker" data-dateformat="dd/mm/yy">
														<label for="dateselect_filter" class="glyphicon glyphicon-calendar no-margin padding-top-15" rel="tooltip" title="" data-original-title="Purchase Date"></label>
													</th>
													<th class="hasinput">
														<input type="text" class="form-control" placeholder="Quantidade" />
													</th>
													<th class="hasinput" style="width:12%">
														<input type="text" class="form-control" placeholder="Valor" />
													</th> 
													<th class="hasinput" style="width:10%">
														 
													</th>

												</tr>
									            <tr>
								                    <th data-class="expand">Imagem</th>
								                    <th>Título</th>
								                    <th data-hide="phone, tablet">Data Validade</th>
								                    <th data-hide="phone, tablet">Quantidade</th>
								                    <th data-hide="phone,tablet">Valor</th> 
								                    <th>Ação</th>
									            </tr>
									        </thead>

											<tbody>
											 
											</tbody>
																
										</table>

									</div>
									<!-- end widget content -->

								</div>
								<!-- end widget div -->

							</div>
							<!-- end widget -->

						</article>
						<!-- WIDGET END -->
						
					</div>

					<!-- end row -->

					<!-- row -->

					<div class="row">

						<!-- a blank row to get started -->
						<div class="col-sm-12">
							<br>
						</div>
							
					</div>

					<!-- end row -->

				</section>
				<!-- end widget grid -->


			</div>
			<!-- END MAIN CONTENT -->

		</div>
		<!-- END MAIN PANEL -->

		<?php include('rodape.php'); ?>


		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>

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
		<script src="js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="js/smart-chat-ui/smart.chat.manager.min.js"></script>

		<!-- PAGE RELATED PLUGIN(S) 
		<script src="..."></script>-->
		<script src="js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script>
			$(document).ready(function() {
			 					
				pageSetUp();

				$.post("eventos.php",{id:'1', evento:'SelecionaVencimento'}, function (data){
	                if((data.length > 0) || typeof(data) !== "undefined"){
                        var MeuObjeto = JSON.parse(data);

                        if(MeuObjeto[0].status == 'VENCENDO') {
                        	$.bigBox({
	                            title: "AVISO ESTOQUE",
	                            content: "PRODUTOS QUE ESTÃO PARA VENCER : " + MeuObjeto[0].produtos,
	                            color: "#C46A69",
	                            icon: "fa fa-warning shake animated",
	                            timeout: 15000
	                        });
                                var emailUsuario = 'madureira@policiamilitar.sp.gov.br';
	                        var subjectemail = 'Alerta Vencimento de Produtos';
	                        var bodyEmail = '<h2>' + MeuObjeto[0].produtos + '</h2>';

	                        $.post("email_send.php",{bodyEmail:bodyEmail,emailUsuario:emailUsuario,subjectemail:subjectemail}, function (data){
				        console.log(data);
				});
                        }
                    }
	            });
				 
				
				/* BASIC ;*/
	            var responsiveHelper_datatable_fixed_column = undefined;

	            var breakpointDefinition = {
	                tablet : 1024,
	                phone : 480
	            };
	            /* END BASIC */ 
 
	            
	            /* COLUMN FILTER  */
	            var otable = $('#datatable_fixed_column').DataTable({ 
	                //"bFilter": false,
	                //"bInfo": false,
	                //"bLengthChange": false
	                //"bAutoWidth": false,
	                //"bPaginate": false,
	                //"bStateSave": true // saves sort state using localStorage
	                "lengthMenu": [ 10, 25, 50, 75, 100, 500 ],
	                "pageLength": 10,
	                "deferRender": true,
	                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'l><'col-xs-12 col-sm-6 hidden-xs'f>r>"+
	                        "t"+
	                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
	                "autoWidth" : true,
	                "oLanguage": {
	                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
	                },
	                "iDisplayLength": 10,
	                "processing": true,
	                "serverSide": true,
	                "ajax": {
	                      "url": "processaProdutos.php",
	                      "type": "POST"
	                },	                
	                "preDrawCallback" : function() {
	                    // Initialize the responsive datatables helper once.
	                    if (!responsiveHelper_datatable_fixed_column) {
	                        responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
	                    }
	                },
	                "rowCallback" : function(nRow) {
	                    responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
	                },
	                "drawCallback" : function(oSettings) {
	                    responsiveHelper_datatable_fixed_column.respond();
	                },
	                "order": [[ 1, "asc" ]]

	            });
	                
	            // Apply the filter
	            $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {                    
	                otable
	                    .column( $(this).parent().index()+':visible' )
	                    .search( this.value )
	                    .draw();
	                    
	            } );
	            /* END COLUMN FILTER */   

				
			})
		
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

	</body>

</html>
