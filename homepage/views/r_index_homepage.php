<!DOCTYPE html>
<!-- 
TEMPLATE NAME : Adminre frontend
VERSION : 1.2.0
AUTHOR : JohnPozy
AUTHOR URL : http://themeforest.net/user/JohnPozy
EMAIL : pampersdry@gmail.com
LAST UPDATE: 23/06/2014

** A license must be purchased in order to legally use this template for your project **
** PLEASE SUPPORT ME. YOUR SUPPORT ENSURE THE CONTINUITY OF THIS PROJECT **
-->
<html class="frontend">
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$title;?></title>
        <meta name="author" content="pampersdry.info">
        <meta name="description" content="Adminre is a clean and flat backend and frontend theme build with twitter bootstrap 3.1.1">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?=base_url('assets/image/touch/apple-touch-icon-144x144-precomposed.png');?>">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?base_url('assets/image/touch/apple-touch-icon-114x114-precomposed.png');?>">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?base_url('assets/image/touch/apple-touch-icon-72x72-precomposed.png');?>">
        <link rel="apple-touch-icon-precomposed" href="<?=base_url('assets/image/touch/apple-touch-icon-57x57-precomposed.png');?>">
        <link rel="shortcut icon" href="<?=base_url('assets/image/favicon.ico');?>">
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Plugins stylesheet : optional -->
        <link rel="stylesheet" href = "<?=base_url('assets/stylesheet/icons/iconfont/fonts/iconfont.woff');?>">
        
        <link rel="stylesheet" href="<?=base_url('assets/plugins/owl/css/owl.carousel.min.css');?>">
        <link rel = "stylesheet" href="<?=base_url('assets/plugins/layerslider/css/blank.gif');?>">
        
        <link rel="stylesheet" href="<?=base_url('assets/plugins/layerslider/css/layerslider.min.css');?>">
        
        <!--/ Plugins stylesheet -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="<?=base_url('assets/library/bootstrap/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?=base_url('assets/stylesheet/layout.css');?>">
        <link rel="stylesheet" href="<?=base_url('assets/stylesheet/uielement.css');?>">
        <link rel="stylesheet" href = "<?=base_url('assets/plugins/layerslider/skins/fullwidth/skin.css');?> ">
        <!--/ Application stylesheet -->
        <!-- END STYLESHEETS -->

        <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
        <script src="<?=base_url('assets/library/modernizr/js/modernizr.min.js');?>"></script>
        <!--/ END JAVASCRIPT SECTION -->
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
    <?php include 'r_header_homepage.php';?>
    <?php include 'r_layerslider_homepage.php';?>
    <?php include 'r_feature_homepage.php';?>
    <?php include 'r_aboutus_homepage.php';?>
    <?php include 'r_contactus_homepage.php';?>
    <?php include 'r_footer_homepage.php';?>

        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Library script : mandatory -->
        <script type="text/javascript" src="<?=base_url('assets/library/jquery/js/jquery.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/library/jquery/js/jquery-migrate.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/library/bootstrap/js/bootstrap.min.js');?>"></script>
        <script type="text/javascript" src="<?=base_url('assets/library/core/js/core.min.js');?>"></script>
        <!--/ Library script -->

        <!-- App and page level script -->
        <script type="text/javascript" src="<?=base_url('assets/plugins/sparkline/js/jquery.sparkline.min.js');?>"></script><!-- will be use globaly as a summary on sidebar menu -->
        <script type="text/javascript" src="<?=base_url('assets/javascript/app.min.js');?>"></script>
        
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/owl/js/owl.carousel.min.js');?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/layerslider/js/greensock.min.js');?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/layerslider/js/transitions.min.js');?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/layerslider/js/layerslider.min.js');?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/javascript/pages/frontend/home.js');?>"></script>
        
        <!--/ App and page level scrip -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>