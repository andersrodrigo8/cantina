<?php
    $db = null;
	include('funcao.php');

	$arrayArquivos = array();
	$posicao = 0;
	$pasta = "notas/";		
	if(is_dir($pasta)) {
		$diretorio = dir($pasta);
		while(($arquivo = $diretorio->read()) !== false){
			 if (($arquivo!=".")&&($arquivo!="..")){ 
			 	$arrayArquivos[date('Y/m/d H:i:s', filemtime($pasta.$arquivo))] = $pasta.$arquivo;
			 }
		}
	}
	rsort($arrayArquivos, SORT_STRING);
?>
<!DOCTYPE html>
<html lang="en-us">
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> Notas Transparência</title>
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
	

	<body class=" desktop-detected menu-on-top pace-done">

		<?php include('topo.php'); ?>

		<!-- MAIN PANEL -->
		<div role="main">

			<!-- MAIN CONTENT -->
			<div id="content" class="container">

				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							<i class="fa fa-edit fa-fw "></i> 
								Forms 
							<span>> 
								Form Elements
							</span>
						</h1>
					</div> 
				</div>

				<!-- widget grid -->
				<section id="widget-grid" class="">
				
					<!-- START ROW -->
				
					<div class="row">
						
						<?php if($_SESSION['administrador'] == 1) {?>
							<!-- NEW COL START -->
							<article class="col-sm-12 col-md-12 col-lg-12">
					
								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

									<header>
										<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
										<h2>Transparência Notas</h2>
					
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
					
											<form class="smart-form" method="post" action="notas.php" enctype="multipart/form-data">
					
												<fieldset>							 
													<div class="row">
														<section class="col col-10">
															<label class="label">Imagem Nota</label>
															<div class="input input-file">
																<span class="button"><input type="file" id="arquivo" name="arquivo" onchange="this.parentNode.nextSibling.value = this.value">Selecione</span><input type="text" placeholder="Imagem" readonly="">
															</div>
														</section>
													</div>											
												</fieldset>
					 
												<footer>
													<button type="submit" name="botaoAcao" class="btn btn-success" value="InserirNota">
															Inserir
														</button>
												</footer>
											</form>
					
										</div>
										<!-- end widget content -->
					
									</div>
									<!-- end widget div -->
					
								</div>
								<!-- end widget -->
					
							</article>
							<!-- END COL -->
						<?php } ?>

						<?php if(count($arrayArquivos) > 0) { ?>
							<!-- NEW COL START -->
							<article class="col-sm-12 col-md-12 col-lg-12">
					
								<!-- Widget ID (each widget will need unique ID)-->
								<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

									<header>
										<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
										<h2>Transparência Notas</h2>
					
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

											<div class="row">
												<div class="col col-10 text-align-center">
													<?php foreach($arrayArquivos as $valorArquivos){ ?>												
														<img style="height: 1000px; width:900px" src="<?php echo $valorArquivos; ?>" data-img="<?php echo $valorArquivos; ?>" title="Nota Fiscal" >
														<p>
                                                                                                                 <form class="smart-form" method="post" action="notas.php">
															<input type="hidden" name="arquivopath" value="<?php echo $valorArquivos; ?>">
															<?php if($_SESSION['administrador'] == 1) {?>
																<button title="Excluir Foto da Nota" type="submit" name="botaoAcao" class="btn btn-danger btn-lg" value="ExcluirNota">
																	Excluir
																</button>
															<?php } ?>
														</form>
														</p>
														<p>
															<hr style="width:90%;border-top: 10px solid #8c8b8b;">
														</p>
													<?php } ?>
												</div>
											</div> 
					
										</div>
										<!-- end widget content -->
					
									</div>
									<!-- end widget div -->
					
								</div>
								<!-- end widget -->
					
							</article>
							<!-- END COL -->
						<?php } ?>
					</div>
				
					<!-- END ROW -->
				
				</section>
				<!-- end widget grid -->

				<div class="row">

					<!-- NEW WIDGET START -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<br>

					</article>
					<!-- WIDGET END --> 

				</div>


				<div class="row">

					<!-- NEW WIDGET START -->
					<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<br>

					</article>
					<!-- WIDGET END --> 

				</div>
			</div>

		</div>
		<!-- END MAIN PANEL -->

		<!-- PAGE FOOTER -->
		<?php include('rodape.php'); ?>
		<!-- END PAGE FOOTER -->

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
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp(); 
		
		})

		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
		<script>
			/*var _gaq = _gaq || [];
				_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
				_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();*/
		</script>

	</body>

</html>
