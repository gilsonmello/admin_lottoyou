<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>LOTTOYOU</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
        <!-- Para o buscador do google -->
        <meta property="og:image" content="http://goLOTTOYOU.com.br/img/logos/LOTTOYOU.jpg" />
        <meta name="description" content="Sistema de apostas - LOTTOYOU" />
        <meta name="keywords" content="LOTTOYOU, LOTTOYOU"/>
        <meta name="author" content="LOTTOYOU" />
        <meta property="og:title" content="Sistema de apostas - LOTTOYOU" />
        <meta property="og:url" content="http://LOTTOYOU.com.br" />
        <meta property="og:site_name" content="LOTTOYOU" />

        <link rel="shortcut icon" href="images/icons/favicon.ico">
        <!--
        <link rel="apple-touch-icon" href="images/icons/favicon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
        -->

        <link rel="apple-touch-icon" sizes="57x57" href="img/icons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="img/icons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/icons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/icons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="img/icons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/icons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/icons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="img/icons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="img/icons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="img/icons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/icons/favicon-16x16.png">
        <link rel="manifest" href="img/icons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="img/icons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">


        <!-- BEGIN STYLESHEETS -->
        <?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900') . "\n\t"; ?>
        <?php echo $this->Html->css('http://fonts.googleapis.com/css?family=Oswald:400,700,300') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/bootstrap.css?1422792965') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/materialadmin.css?1425466319') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/font-awesome.min.css?1422529194') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/material-design-iconic-font.min.css?1421434286') . "\n\t"; ?>
        <?php //echo $this->Html->css('theme-default/libs/rickshaw/rickshaw.css?1422792967')."\n\t";?>
        <?php //echo $this->Html->css('theme-default/libs/morris/morris.core.css?1420463396')."\n\t";?>
        <?php echo $this->Html->css('theme-default/libs/bootstrap-datepicker/datepicker3.css?1422823364') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/libs/multi-select/multi-select.css?14212387856') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/libs/select2/select2.css?1424887856') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/libs/toastr/toastr.css?14248878123') . "\n\t"; ?>
        <?php echo $this->Html->css('nucleos/w2ui-1.4.1.min.css') . "\n\t"; ?>
        <?php echo $this->Html->css('nucleos/multi-select.css') . "\n\t"; ?>
        <?php echo $this->Html->css('nucleos/multiple-select.css') . "\n\t"; ?>
        <?php echo $this->Html->css('nucleos/chosen.min.css') . "\n\t"; ?>
        <?php echo $this->Html->css('vendors/dropzone/css/dropzone.css') . "\n\t"; ?>      
        <?php echo $this->Html->css('theme-default/libs/nestable/nestable.css') . "\n\t"; ?>
        <?php echo $this->Html->css('jquery-file-uploader/jquery.fileupload.css') . "\n\t"; ?>
        <?php echo $this->Html->css('jquery-file-uploader/jquery.fileupload-ui.css') . "\n\t"; ?>
        <?php echo $this->Html->css('theme-default/libs/jquery-hex-colorpicker/jquery-hex-colorpicker.css') . "\n\t"; ?>
        <?php //echo $this->Html->css('theme-default/libs/DataTables/jquery.dataTables.css')."\n\t";?>
        <?php //echo $this->Html->css('theme-default/libs/DataTables/extensions/dataTables.colVis.css')."\n\t";?>
        <?php //echo $this->Html->css('theme-default/libs/DataTables/extensions/dataTables.tableTools.css'); ?>
        <?php // echo $this->Html->css('frontend/one-page_1.css') . "\n\t"; ?>
        <?php echo $this->Html->css('sge.css'); ?>
        <!-- END STYLESHEETS -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <?php echo $this->Html->script('libs/utils/html5shiv.js?1403934957') . "\n\t"; ?>
        <?php echo $this->Html->css('libs/utils/respond.min.js?1403934956') . "\n\t"; ?>
        <![endif]-->

        <script>
            var baseURL = baseUrl = "<?php echo $this->Html->url('/'); ?>";
            var baseSub = "<?php echo $this->webroot; ?>";
            var userId = "<?php echo $this->Session->read('Auth.User.id'); ?>";
            var userPhoto = "<?php echo $this->Session->read('Auth.User.photo'); ?>";
            var forms = '';
        </script>
    </head>
    <body id="page-top" data-spy="scroll" data-target=".navbar-custom" class="menubar-hoverable header-fixed menubar-pin frontend-one-page"> 

        <div id="page-loader"><img src="https://mir-s3-cdn-cf.behance.net/project_modules/disp/f07dcc31762183.565f4d8e4129a.gif" alt="" /></div>
        <!-- BEGIN HEADER-->
        <?php echo $this->element('layout/header'); ?>
        <!-- END HEADER-->

        <!-- BEGIN BASE-->
        <div id="base">
            <!-- BEGIN OFFCANVAS LEFT -->
            <div class="offcanvas">
            </div>
            <!-- END OFFCANVAS LEFT -->

            <!-- BEGIN CONTENT-->
            <div id="content">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->fetch('content'); ?>
            </div>
            <!-- END CONTENT -->

            <!-- BEGIN MENUBAR-->
            <?php echo $this->element('layout/menu'); ?>
            <!-- END MENUBAR -->

            <!-- BEGIN OFFCANVAS RIGHT -->
            <?php //echo $this->element('layout/canvas'); ?>
            <!-- END OFFCANVAS RIGHT -->
        </div>
        <!-- END BASE -->

        <?php echo $this->element('layout/modal', array('id' => 'nivel1')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'nivel2')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'nivel3')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'nivel4')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'nivel5')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'nivel6')); ?>
        <?php echo $this->element('layout/modal', array('id' => 'raspadinha100')); ?>

        <!-- BEGIN TIMER -->
        <?php echo $this->element('timer'); ?>
        <!-- END TIMER -->

        <!-- BEGIN JAVASCRIPT -->
        <?php echo $this->Html->script('core/libs/jquery/jquery-1.11.2.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jQuery-File-Upload-9.19.1/js/vendor/jquery.ui.widget.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jQuery-File-Upload-9.19.1/js/vendor/jquery.fileupload-validate.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jQuery-File-Upload-9.19.1/js/jquery.fileupload.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jQuery-File-Upload-9.19.1/js/jquery.iframe-transport.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jQuery-File-Upload-9.19.1/js/jquery.fileupload-process.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jquery/jquery-migrate-1.2.1.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/bootstrap/bootstrap.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/bootstrap-datepicker/bootstrap-datepicker.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/bootstrap-validator/bootstrap-validator.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/bootstrap-validator/language/pt_BR.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/spin.js/spin.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/autosize/jquery.autosize.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/select2/select2.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/moment/moment-with-locales.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/nestable/jquery.nestable.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jquery-hex-colorpicker/jquery-hex-colorpicker.js') . "\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/jquery.flot.min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/jquery.flot.time.min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/jquery.flot.resize.min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/jquery.flot.orderBars.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/jquery.flot.pie.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/flot/curvedLines.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/jquery-knob/jquery.knob.min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/sparkline/jquery.sparkline.min.js')."\n"; ?>
        <?php echo $this->Html->script('core/libs/nanoscroller/jquery.nanoscroller.min.js') . "\n"; ?>
        <?php //echo $this->Html->script('core/libs/d3/d3.min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/d3/d3.v3.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/rickshaw/rickshaw.min.js')."\n"; ?>
        <?php echo $this->Html->script('core/libs/toastr/toastr.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/toastr/ui-toastr-notifications.js') . "\n"; ?>
        <?php //echo $this->Html->script('core/libs/raphael/raphael-min.js')."\n"; ?>
        <?php //echo $this->Html->script('core/libs/morris.js/morris.min.js')."\n"; ?>
        <?php echo $this->Html->script('core/libs/highcharts/highcharts.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/tinymce/tinymce.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/tinymce/jquery.tinymce.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/tinymce/langs/pt_BR.js') . "\n"; ?>
        <!-- NUCLEOS -->
        <?php echo $this->Html->script('core/nucleos/jquery.chosen.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.multiple.select.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.multi-select.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.quicksearch.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.meiomask.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/inputmask/inputmask/jquery.inputmask.js') . "\n"; ?>
        <?php echo $this->Html->script('core/libs/jquery-maskmoney/dist/jquery.maskMoney.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.idletimeout.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.idletimer.js') . "\n"; ?>        
        <?php echo $this->Html->script('core/nucleos/jquery.priceFormat.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/jquery.notify.min.js') . "\n"; ?>
        <?php echo $this->Html->script('core/nucleos/w2ui-1.4.1.min.js') . "\n"; ?>
        <!-- UPLOAD IMAGENS -->
        <?php echo $this->Html->script('../css/vendors/dropzone/js/dropzone.js') . "\n"; ?>
        <?php echo $this->Html->script('../css/vendors/jquery-file-upload/js/jquery.iframe-transport.js') . "\n"; ?>

        <?php echo $this->Html->script('core/libs/owl-carousel/owl-carousel/owl.carousel.min.js') . "\n"; ?>

        <!-- MATIRIAL ADMIN -->
        <?php echo $this->Html->script('core/source/App.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppNavigation.js') . "\n"; ?>
        <?php //echo $this->Html->script('core/source/AppOffcanvas.js')."\n"; ?>
        <?php echo $this->Html->script('core/source/AppCard.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppForm.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppGrid.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppNavSearch.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppOffcanvas.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppVendor.js') . "\n"; ?>
        <?php echo $this->Html->script('core/source/AppHandleAjaxError.js') . "\n"; ?>
        <?php echo $this->Html->script('core/demo/Demo.js') . "\n"; ?>
        <?php echo $this->Html->script('sge/DemoUILists.js') . "\n"; ?>
        <?php // echo $this->Html->script('basics.js') . "\n"; ?>

        <!--CORE JAVASCRIPT-->
        <?php echo $this->Html->script('frontend-one-page.js') . "\n"; ?>
        <?php echo $this->Html->script('basics.js') . "\n"; ?>

        <!-- MÓDULOS SGE -->
        <?php echo $this->Html->script('sge/AppDashboard.js') . "\n"; ?>
        <?php echo $this->Html->script('sge/AppRaspadinhas.js') . "\n"; ?>
        <?php echo $this->Html->script('sge/AppSocJogos.js') . "\n"; ?>

        <!-- PAGE'S SCRIPT -->
        <?php echo $this->fetch('script') . "\n"; ?>
        <!-- END JAVASCRIPT -->
        <script>
            var tamanhoW = $(document).width();
        </script>

        <div id="fb-root"></div>
<!--        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1194020284000011";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>-->

        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>