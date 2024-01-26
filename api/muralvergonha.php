<?php
$db = null;
include('funcao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$mes = ucfirst(strftime('%B', strtotime('today')));

if(isset($_POST['buscar'])){
    $mes = $_POST['mes'];
}
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

    <title> Mural da Vergonha do Usuários </title>
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
                    <span>
                        Form Elements
                    </span>
                </h1>
            </div>
        </div>

        <input type="hidden" class="input-sm" id="usuaID" name="id" value="<?php if(isset($id)) { echo $id; } ?>">

        <div class="row">
            <div class="col-xs-12">
                <div class="well no-padding">
                    <form action="muralvergonha.php" id="login-form" method="post" class="smart-form client-form">
                        <fieldset>
                            <section>
                                <label class="label">Escolha o Mês</label>
                                <label class="select">
                                    <select class="input-sm" name="mes" id="mes">
                                        <option value="Janeiro" <?php if($mes == 'Janeiro'){ ?> selected="selected" <?php } ?>>Janeiro</option>
                                        <option value="Fevereiro" <?php if($mes == 'Fevereiro'){ ?> selected="selected" <?php } ?>>Fevereiro</option>
                                        <option value="Março" <?php if($mes == 'Março'){ ?> selected="selected" <?php } ?>>Março</option>
                                        <option value="Abril" <?php if($mes == 'Abril'){ ?> selected="selected" <?php } ?>>Abril</option>
                                        <option value="Maio" <?php if($mes == 'Maio'){ ?> selected="selected" <?php } ?>>Maio</option>
                                        <option value="Junho" <?php if($mes == 'Junho'){ ?> selected="selected" <?php } ?>>Junho</option>
                                        <option value="Julho" <?php if($mes == 'Julho'){ ?> selected="selected" <?php } ?>>Julho</option>
                                        <option value="Agosto" <?php if($mes == 'Agosto'){ ?> selected="selected" <?php } ?>>Agosto</option>
                                        <option value="Setembro" <?php if($mes == 'Setembro'){ ?> selected="selected" <?php } ?>>Setembro</option>
                                        <option value="Outubro" <?php if($mes == 'Outubro'){ ?> selected="selected" <?php } ?>>Outubro</option>
                                        <option value="Novembro" <?php if($mes == 'Novembro'){ ?> selected="selected" <?php } ?>>Novembro</option>
                                        <option value="Dezembro" <?php if($mes == 'Dezembro'){ ?> selected="selected" <?php } ?>>Dezembro</option>
                                    </select> <i></i> </label>
                            </section>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary" name="buscar">
                                Buscar
                            </button>
                        </footer>
                    </form>

                </div>
            </div>
        </div>

        <!-- row -->
        <div class="row">

            <!-- NEW WIDGET START -->
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-0" data-widget-editbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
			<h2> Mural da Vergonha </h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">

                            <div class="table-responsive">

                                <table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">

                                    <thead>
                                    <tr>
                                        <th class="hasinput" style="width:20%">
                                            <input type="text" class="form-control" placeholder="Usuário" />
                                        </th>

                                        <!-- <th class="hasinput" style="width:10%">  </th> -->

                                    </tr>
                                    <tr>
                                        <th>Usuários</th>
                                        <!-- <th>Valor</th> -->
                                    </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>

                                </table>

                            </div>
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

        /* BASIC ;*/
        var responsiveHelper_datatable_fixed_column = undefined;

        var breakpointDefinition = {
            tablet : 1024,
            phone : 480
        };
        /* END BASIC */

        let select = document.getElementById("mes");
        let mes = select.options[select.selectedIndex].text;

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
                "url": "processaMural.php",
                "type": "POST",
                "data": {mes:mes}
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
            "order": [[ 0, "asc" ]]

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
