<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
 <!-- START META SECTION -->
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title><?=$judul_halaman;?></title>
 <meta name="author" content="pampersdry.info">
 <meta name="description" content="Adminre is a clean and flat backend and frontend theme build with twitter bootstrap 3.1.1">
 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

 <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url('assets/image/touch/apple-touch-icon-144x144-precomposed.png') ?>">
 <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url('assets/image/touch/apple-touch-icon-114x114-precomposed.png') ?>">
 <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url('assets/image/touch/apple-touch-icon-72x72-precomposed.png') ?>">
 <link rel="apple-touch-icon-precomposed" href="<?= base_url('assets/image/touch/apple-touch-icon-57x57-precomposed.png') ?>">
 <link rel="shortcut icon" href="<?= base_url('assets/image/favicon.ico') ?>">
 <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/css/jquery.datatables.min.css'); ?>">
 <script src="<?= base_url('assets/sal/sweetalert-dev.js');?>"></script>
 <link rel="stylesheet" href="<?= base_url('assets/sal/sweetalert.css');?>">

 <script type="text/javascript" src="<?= base_url('assets/library/jquery/js/jquery.min.js') ?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/plugins/owl/js/owl.carousel.min.js');?>"></script>
 
 <script>var base_url = '<?php echo base_url() ?>';var halaman = false;</script>
 <!--/ END META SECTION -->

 

 <!-- START STYLESHEETS -->
 <!-- Plugins stylesheet : optional -->


 <!--/ Plugins stylesheet -->

 <!-- Application stylesheet : mandatory -->
 <link rel="stylesheet" href="<?= base_url('assets/library/bootstrap/css/bootstrap.min.css') ?>">
 <link rel="stylesheet" href="<?= base_url('assets/stylesheet/layout.min.css') ?>">
 <link rel="stylesheet" href="<?= base_url('assets/stylesheet/uielement.min.css') ?>">
 <!--/ Application stylesheet -->
 <!-- END STYLESHEETS -->

  <link rel="stylesheet" href="<?= base_url('assets/plugins/steps/css/jquery-steps.min.css') ?>">

 <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
 <script src="<?= base_url('assets//library/modernizr/js/modernizr.min.js') ?>"></script>
 <!--/ END JAVASCRIPT SECTION -->
</head>
<!--/ END Head -->

<!-- START Body -->
<body>

 <!-- START Modal ADD BANK SOAL -->
 <div class="modal fade" id="modalmodul" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Form Modul</h4>
   </div>


   <!-- Start Body modal -->
   <div class="modal-body">
    <!--      <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/banksoal/listsoal" method="get" > -->
    <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/modulonline/filtermodul" method="post" >
      <div  class="form-group">
       <label class="col-sm-3 control-label">Tingkat</label>
       <div class="col-sm-8">
         <!-- stkt = soal tingkat -->
         <select class="form-control gettkt" name="tingkat" id="stkt">
           <option>-Pilih Tingkat-</option>
         </select>
       </div>
     </div>

     <div  class="form-group">
       <label class="col-sm-3 control-label">Mata Pelajaran</label>
       <div class="col-sm-8">
        <select class="form-control getpel" name="mataPelajaran" id="spel">

        </select>
      </div>
    </div>

    <!-- <div  class="form-group">
     <label class="col-sm-3 control-label">Bab</label>
     <div class="col-sm-8">
      <select class="form-control getbb" name="bab" id="sbab">

      </select>
    </div>
  </div>

  <div class="form-group">
   <label class="col-sm-3 control-label">Subab</label>
   <div class="col-sm-8">
    <select class="form-control subb" name="subbab" id="ssub">

    </select>
  </div>
</div> -->

</div>
<!-- END BODY modla-->
<div class="modal-footer">
  <button type="submit" id="myFormSubmit" class="btn btn-primary">Proses</button>                
</div>
</form> 
</div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END  Modal ADD BANK SOAL-->

<!-- START Modal ADD BANK SOAL -->
<div class="modal fade" id="modalsoal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Form Soal</h4>
   </div>


   <!-- Start Body modal -->
   <div class="modal-body">
    <!--      <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/banksoal/listsoal" method="get" > -->
    <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/banksoal/filtersoal2" method="get" >
      <div  class="form-group">
       <label class="col-sm-3 control-label">Tingkat</label>
       <div class="col-sm-8">
         <!-- stkt = soal tingkat -->
         <select class="form-control gettkt2" name="tingkat" id="stkt2">
           <option>-Pilih Tingkat-</option>
         </select>
       </div>
     </div>

     <div  class="form-group">
       <label class="col-sm-3 control-label">Mata Pelajaran</label>
       <div class="col-sm-8">
        <select class="form-control getpel2" name="mataPelajaran" id="spel2">

        </select>
      </div>
    </div>

    <div  class="form-group">
     <label class="col-sm-3 control-label">Bab</label>
     <div class="col-sm-8">
      <select class="form-control getbb2" name="bab" id="sbab2">

      </select>
    </div>
  </div>

  <div class="form-group">
   <label class="col-sm-3 control-label">Subab</label>
   <div class="col-sm-8">
    <select class="form-control subb2" name="subbab" id="ssub2">

    </select>
  </div>
</div>

</div>
<!-- END BODY modla-->
<div class="modal-footer">
  <button type="submit" id="myFormSubmit" class="btn btn-primary"  >Proses</button>                
</div>
</form> 
</div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END  Modal ADD BANK SOAL-->

<!-- START Modal Filter Video -->
<div class="modal fade" id="modalvideo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Filter Video</h4>
   </div>


   <!-- Start Body modal -->
   <div class="modal-body">
     <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/videoback/filter_video" method="post" >
      <div  class="form-group">
       <label class="col-sm-3 control-label">Tingkat</label>
       <div class="col-sm-8">
         <!-- vtkt = video tingkat -->
         <select class="form-control gettkt" name="tingkat" id="vtkt">
           <option>-Pilih Tingkat-</option>
         </select>
       </div>
     </div>

     <div  class="form-group">
       <label class="col-sm-3 control-label">Mata Pelajaran</label>
       <div class="col-sm-8">
        <select class="form-control getpel" name="mataPelajaran" id="vpel">

        </select>
      </div>
    </div>

    <div  class="form-group">
     <label class="col-sm-3 control-label">Bab</label>
     <div class="col-sm-8">
      <select class="form-control getbb" name="bab" id="vbab">

      </select>
    </div>
  </div>

  <div class="form-group">
   <label class="col-sm-3 control-label">Subab</label>
   <div class="col-sm-8">
    <select class="form-control subb" name="subbab" id="vsub">

    </select>
  </div>
</div>

</div>
<!-- END BODY modla-->
<div class="modal-footer">
  <button type="submit" id="myFormSubmit" class="btn btn-primary"  >Proses</button>                
</div>
</form> 
</div><!-- /.modal-content -->

</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- END  Modal Filter Video -->



<!-- START Modal ADD TO -->
<div class="modal fade" id="modalto" tabindex="-1" role="dialog">
  <!--START modal dialog  -->
  <div class="modal-dialog" role="document">
   <!-- STRAT MOdal Content -->
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Buat TO</h4>
   </div>

   <!-- START Modal Body -->
   <div class="modal-body">

     <!-- START PESAN ERROR EMPTY INPUT -->
     <div class="alert alert-dismissable alert-danger" id="e_crtTo" hidden="true" >
      <button type="button" class="close" onclick="hide_e_crtTo()" >×</button>
      <strong>O.M.G.!</strong> Tolong di ISI semua.
    </div>
    <!-- END PESAN ERROR EMPTY INPUT -->
    <!-- START PESAN ERROR EMPTY INPUT -->
     <div class="alert alert-dismissable alert-danger" id="e_wktTo" hidden="true" >
      <button type="button" class="close" onclick="hide_e_wktTo()" >×</button>
      <strong>ilahkan cek kembali!</strong> Waktu mulai dan tanggal waktu tidak sesuai.
    </div>
    <!-- END PESAN ERROR EMPTY INPUT -->
    <!-- START PESAN ERROR EMPTY INPUT -->
    <div class="alert alert-dismissable alert-danger" id="e_tglTo" hidden="true" >
      <button type="button" class="close" onclick="hide_e_tglTo()" >×</button>
      <strong>Silahkan cek kembali!</strong> Tanggal mulai dan tanggal akhir tidak sesuai.
    </div>
    <!-- END PESAN ERROR EMPTY INPUT -->
    <form class="panel panel-default form-horizontal form-bordered" action="javascript:void(0);" method="post" id="form_to">
      <div  class="form-group">
       <label class="col-sm-3 control-label">Nama Tryout</label>
       <div class="col-sm-8">
        <input type="text" class="form-control" name="nmpaket" id="to_nm">
      </div>
    </div>
    <div  class="form-group">
     <label class="col-sm-3 control-label">Tanggal Mulai</label>
     <div class="col-sm-4">
      <input type="date" class="form-control" name="tglmulai" id="to_tglmulai">
    </div >
    <div class="col-sm-4">
      <input type="time" class="form-control" name="wktmulai" id="to_wktmulai" >
    </div>
  </div>
  <div  class="form-group">
   <label class="col-sm-3 control-label">Tanggal Berakhir</label>
   <div class="col-sm-4">
    <input type="date" class="form-control" name="tglakhir" id="to_tglakhir">
  </div>
  <div class="col-sm-4">
    <input type="time" class="form-control" name="wktakhir" id="to_wktakhir" >
  </div>
</div>

<div class="form-group">
 <label class="col-sm-3 control-label">Publish</label>
 <div class="col-sm-8">
  <div class="checkbox custom-checkbox">  
   <input type="checkbox" name="publish" id="to_publish" value="1">  
   <label for="to_publish" >&nbsp;&nbsp;</label>   
 </div>
</div>
</div> 

</div>
<!-- END Modal Body -->
<!-- START Modal Footer -->
<div class="modal-footer">
  <button type="submit" id="myFormSubmit" class="btn btn-primary" onclick="crtTo()"  >Proses</button>
</div>
</form>
<!-- START Modal Footer -->

</div>
<!-- END MOdal Content -->

</div>
<!--END modal dialog  -->
</div>
<!-- END Modal ADD TO -->

<!-- START Template Header -->
<header id="header" class="navbar navbar-fixed-top">
  <!-- START navbar header -->
  <div class="navbar-header">
   <!-- Brand -->
   <a class="navbar-brand" href="javascript:void(0);">
    <span class="logo-figure"></span>
    <span class="logo-text"></span>
  </a>
  <!--/ Brand -->
</div>
<!--/ END navbar header -->

<!-- START Toolbar -->
<div class="navbar-toolbar clearfix">
 <!-- START Left nav -->
 <ul class="nav navbar-nav navbar-left">
  <!-- Sidebar shrink -->
  <li class="hidden-xs hidden-sm">
   <a href="javascript:void(0);" class="sidebar-minimize" data-toggle="minimize" title="Minimize sidebar">
    <span class="meta">
     <span class="icon"></span>
   </span>
 </a>
</li>
<!--/ Sidebar shrink -->

<!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
<li class="navbar-main hidden-lg hidden-md hidden-sm">
 <a href="javascript:void(0);" data-toggle="sidebar" data-direction="ltr" rel="tooltip" title="Menu sidebar">
  <span class="meta">
   <span class="icon"><i class="ico-paragraph-justify3"></i></span>
 </span>
</a>
</li>
<!--/ Offcanvas left -->

<!-- Notification dropdown -->
<li class="dropdown custom" id="header-dd-notification">
 <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
  <span class="meta">
   <span class="icon"><i class="ico-bell"></i></span>
   <span class="hasnotification hasnotification-danger"></span>
 </span>
</a>


<!-- Dropdown menu -->
<div class="dropdown-menu" role="menu">
  <div class="dropdown-header">
   <span class="title">Notification <span class="count"></span></span>
   <span class="option text-right"><a href="javascript:void(0);">Clear all</a></span>
 </div>
 <div class="dropdown-body slimscroll">
   <!-- indicator -->
   <div class="indicator inline"><span class="spinner"></span></div>
   <!--/ indicator -->

   <!-- Message list -->
   <div class="media-list">
    <a href="javascript:void(0);" class="media read border-dotted">
     <span class="media-object pull-left">
      <i class="ico-basket2 bgcolor-info"></i>
    </span>
    <span class="media-body">
      <span class="media-text">Duis aute irure dolor in <span class="text-primary semibold">reprehenderit</span> in voluptate.</span>
      <!-- meta icon -->
      <span class="media-meta pull-right">2d</span>
      <!--/ meta icon -->
    </span>
  </a>

  <a href="javascript:void(0);" class="media read border-dotted">
   <span class="media-object pull-left">
    <i class="ico-call-incoming"></i>
  </span>
  <span class="media-body">
    <span class="media-text">Aliquip ex ea commodo consequat.</span>
    <!-- meta icon -->
    <span class="media-meta pull-right">1w</span>
    <!--/ meta icon -->
  </span>
</a>

<a href="javascript:void(0);" class="media read border-dotted">
 <span class="media-object pull-left">
  <i class="ico-alarm2"></i>
</span>
<span class="media-body">
  <span class="media-text">Excepteur sint <span class="text-primary semibold">occaecat</span> cupidatat non.</span>
  <!-- meta icon -->
  <span class="media-meta pull-right">12w</span>
  <!--/ meta icon -->
</span>
</a>

<a href="javascript:void(0);" class="media read border-dotted">
 <span class="media-object pull-left">
  <i class="ico-checkmark3 bgcolor-success"></i>
</span>
<span class="media-body">
  <span class="media-text">Lorem ipsum dolor sit amet, <span class="text-primary semibold">consectetur</span> adipisicing elit.</span>
  <!-- meta icon -->
  <span class="media-meta pull-right">14w</span>
  <!--/ meta icon -->
</span>
</a>
</div>
<!--/ Message list -->
</div>
</div>
<!--/ Dropdown menu -->
</li>
<!--/ Notification dropdown -->


</ul>
<!--/ END Left nav -->

<!-- START navbar form -->
<div class="navbar-form navbar-left dropdown" id="dropdown-form">
  <form action="" role="search">
   <div class="has-icon">
    <input type="text" class="form-control" placeholder="Search application...">
    <i class="ico-search form-control-icon"></i>
  </div>
</form>
</div>
<!-- START navbar form -->

<!-- START Right nav -->
<ul class="nav navbar-nav navbar-right">
  <!-- Profile dropdown -->
  <li class="dropdown profile">
   <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
    <span class="meta">
     <span class="avatar"></span>
     <span class="text hidden-xs hidden-sm pl5"><?=$this->session->userdata['NAMAGURU'];?></span>
     <span class="caret"></span>
   </span>
 </a>
 <ul class="dropdown-menu" role="menu">
  <li><a href="javascript:void(0);"><span class="icon"><i class="ico-user-plus2"></i></span> My Accounts</a></li>
  <li><a href="<?=base_url('index.php/guru/pengaturanProfileguru');?>"><span class="icon"><i class="ico-cog4"></i></span> Profile Setting</a></li>
  <li><a href="javascript:void(0);"><span class="icon"><i class="ico-question"></i></span> Help</a></li>
  <li class="divider"></li>
  <li><a href="<?=base_url('index.php/logout');?>"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
</ul>
</li>
<!-- Profile dropdown -->


</ul>
<!--/ END Right nav -->
</div>
<!--/ END Toolbar -->
</header>
<!--/ END Template Header -->

<!-- START Template Sidebar (Left) -->
<aside class="sidebar sidebar-left sidebar-menu">
  <!-- START Sidebar Content -->
  <section class="content slimscroll">
   <h5 class="heading">Main Menu</h5>
   <!-- START MENU -->
   <ul class="topmenu topmenu-responsive" data-toggle="menu">
    <li >
     <a href="<?= base_url('index.php/guru/dashboard/') ?>">
      <span class="figure"><i class="ico-trophy"></i></span>
      <span class="text">Dashboard</span>
    </a>
  </li>

  <li>
   <a href="javascript:void(0);" data-target="#video" data-toggle="submenu" data-parent=".topmenu">
    <span class="figure"><i class="ico-facetime-video"></i></span>
    <span class="text">Video</span>
    <span class="arrow"></span>
  </a>

  <ul id="video" class="submenu collapse ">
    <li class="submenu-header ellipsis">Video</li>

    <li >
     <a href="<?=base_url('index.php/videoback/formupvideo')?>">
      <span class="text">Upload Video</span>
    </a>
  </li>

  <li>
    <a href="javascript:void(0);" data-target="#filtervideo" data-toggle="submenu"  >

      <span class="text">Daftar video</span>

      <span class="arrow"></span>

    </a>

    <ul id="filtervideo" class="submenu collapse ">

      <li class="submenu-header ellipsis">Daftar video</li>

      <li><a href="<?=base_url()?>index.php/videoback/managervideo"><span class="text">My video</span></a></li>
      <li >
       <a href="<?=base_url('/index.php/videoback/listvideo')?>">
        <span class="text">Daftar Semua video</span>
      </a>
    </li>

    <li><a href="javascript:void(0);" onclick="filter_video()"><span class="text">Filter Video</span></a></li>
  </ul>
</li>
</ul>
</li>

<li>
 <a href="javascript:void(0);" data-target="#banksoal" data-toggle="submenu" data-parent=".topmenu">
  <span class="figure"><i class="ico-clipboard2"></i></span>
  <span class="text">Bank Soal</span>
  <span class="arrow"></span>
</a>

<ul id="banksoal" class="submenu collapse ">
  <li class="submenu-header ellipsis">Bank Soal</li>

  <li >
   <a href="javascript:void(0);" onclick="add_soal()">
    <span class="text">Tambahkan Bank Soal</span> 
  </a>
</li>
<li >
 <a href="javascript:void(0);" data-target="#subbanksoal" data-toggle="submenu"  >
  <span class="text">Daftar Bank Soal</span>
  <span class="arrow"></span>
</a>
<ul id="subbanksoal" class="submenu collapse ">
  <li class="submenu-header ellipsis">Sub Bank Soal</li>
  <li><a href="<?=base_url('index.php/banksoal/allsoal')?>"><span class="text">Daftar Semua Soal</span>
  </a></li>
        <li><a href="<?=base_url('index.php/banksoal/listsoal')?>"><span class="text">View full Soal</span>
  </a></li>
  <li><a href="javascript:void(0);" onclick="add_soal()"><span class="text">Filter Bank Soal</span>
  </a></li>


</ul>
</li>

</ul>
</li>

<li>
 <a href="javascript:void(0);" data-target="#tryout" data-toggle="submenu" data-parent=".topmenu">
  <span class="figure"><i class="ico-clipboard"></i></span>
  <span class="text">Try Outs</span>
  <span class="arrow"></span>
</a>

<ul id="tryout" class="submenu collapse ">
  <li class="submenu-header ellipsis">Try Out</li>

  <li >
   <a href="<?= base_url('index.php/paketsoal/tambahpaketsoal');?>">
    <span class="text">Paket Soal</span>
  </a>
</li>

<li >
 <a href="javascript:void(0);" onclick="add_to()">
  <span class="text">Tambahkan Try Out</span>
</a>
</li>
<li >
 <a href="<?= base_url('index.php/toback/listTo');?>">
  <span class="text">Daftar Try Out</span>
</a>
</li>

</ul>
</li>

<!--Start menu konsultasi -->
<li>
 <a href="javascript:void(0);" data-target="#konsultasi" data-toggle="submenu" data-parent=".topmenu">
  <span class="figure"><i class="ico-clipboard"></i></span>
  <span class="text">Konsultasi Forum</span>
  <span class="arrow"></span>
</a>

<ul id="konsultasi" class="submenu collapse ">
  <li class="submenu-header ellipsis">Konsultasi Forum/li>

    <li >
     <a href="<?= base_url('index.php/konsulback/listkonsul');?>">
      <span class="text">Daftar Konsultasi Forum</span>
    </a>
  </li>

  <li >
   <a href="<?= base_url('index.php/konsulback/myhistory');?>">
    <span class="text">History</span>
  </a>
</li>

</ul>
</li>

<li>
  <a href="<?=base_url('komenback') ?>" data-toggle="submenu" data-parent=".topmenu">
    <span class="figure"><i class="ico-comments"></i></span>
    <span class="text">Komen</span>
    <span class="arrow"></span>
  </a>
</li>
<!--END menu konsultasi -->



<li>
 <a href="javascript:void(0);" data-target="#modulonline" data-toggle="submenu" data-parent=".topmenu">
  <span class="figure"><i class="ico-clipboard2"></i></span>
  <span class="text">Modul Online</span>
  <span class="arrow"></span>
</a>

<ul id="modulonline" class="submenu collapse ">
  <li class="submenu-header ellipsis">Modul Online</li>

  <li >
   <a href="javascript:void(0);" onclick="add_modul()">
    <span class="text">Tambahkan Modul</span> 
  </a>
</li>
<li >
 <a href="<?=base_url('index.php/modulonline/allsoal')?>" data-target="#submodul" data-toggle="submenu"  >
  <span class="text">Daftar Modul</span>
</a>
</li>

</ul>
</li>
<li>
 <a href="<?= base_url('learningline') ?>">
  <span class="figure"><i class="ico-list-ol"></i></span>
  <span class="text">Learningline</span>
</a>
</li>
</ul>
<!--/ END Template Navigation/Menu -->
</section>
<!--/ END Sidebar Container -->
</aside>
<!--/ END Template Sidebar (Left) -->

<!-- START Template Main -->
<section id="main" role="main">
  <!-- START Template Container -->
  <div class="container-fluid">
   <!-- Page Header -->
   <div class="page-header page-header-block">
    <div class="page-header-section">
     <h4 class="title semibold"><?=$judul_halaman;?></h4>
   </div>

 </div>

 <?php
 foreach ($files as $file) {
  include $file;
}
?>

<!-- Page Header -->
</div>
<!--/ END Template Container -->

<!-- START To Top Scroller -->
<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
<!--/ END To Top Scroller -->

</section>
<!--/ END Template Main -->



<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
<!-- Library script : mandatory -->
<script type="text/javascript" src="<?= base_url('assets/library/jquery/js/jquery-migrate.min.j') ?>s"></script>
<script type="text/javascript" src="<?= base_url('assets/library/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/library/core/js/core.min.js') ?>"></script>
<!--/ Library script -->

<!-- App and page level script -->
<script type="text/javascript" src="<?= base_url('assets/plugins/sparkline/js/jquery.sparkline.min.js') ?>"></script><!-- will be use globaly as a summary on sidebar menu -->
<script type="text/javascript" src="<?= base_url('assets/javascript/app.min.js') ?>"></script>

<!--datatable-->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/js/jquery.datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/tabletools/js/tabletools.min.js') ?>"></script>
<!--<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/tabletools/js/zeroclipboard.js') ?>"></script>-->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/js/jquery.datatables-custom.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/javascript/tables/datatable.js') ?>"></script>

   <script type="text/javascript" src="<?=base_url('assets/javascript/forms/wizard.js')?>"></script>
    <script type="text/javascript" src="<?=base_url('assets/plugins/parsley/js/parsley.min.js')?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/steps/js/jquery.steps.min.js')?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/plugins/inputmask/js/inputmask.min.js')?>"></script>
<script type="text/javascript">

  function add_modul() {
$('#modalmodul').modal('show'); // show bootstrap modal
}

//panggil modal
function add_soal() {
$('#modalsoal').modal('show'); // show bootstrap modal
}

function filter_video() {
$('#modalvideo').modal('show'); // show bootstrap modal
}

function add_to() {
 if (halaman) {
 $('#modalto').modal('show'); // show bootstrap modal
}else{
 var konfirm = window.confirm("Anda akan dialihkan pada halaman tryout?");
 if (konfirm) {
  document.location.href = base_url+"index.php/toback/listTo";
}
}

}

</script>
<!-- drop down dependend for get subbab -->
<script type="text/javascript">
  $.ajax({
   type: "POST",
   url: "<?= base_url() ?>guru/get_avatar_guru",
   success: function (data) { 
    console.log(data);
    $('span.avatar').html(data);
  }
});

  function hide_e_crtTo() {
    $("#e_crtTo").hide();
  }
  function hide_e_tglTo() {
    $("#e_tglTo").hide();
  }
  function hide_e_wktTo() {
    $("#e_wktTo").hide();
  }
  function crtTo() {
    var nm_paket   =   $('#to_nm').val();
    var tgl_mulai  =   $('#to_tglmulai').val();
    var tgl_akhir  =   $('#to_tglakhir').val();
    var wkt_mulai  =   $('#to_wktmulai').val();
    var wkt_akhir  =   $('#to_wktakhir').val();
    var publish;
    if ($('#to_publish:checked')==true) {
     publish = 1;
   } else{
     publish = 0;
   }
// pengecekan inputan pembuatan to
// cek inputan kosong
if (nm_paket != "" && tgl_mulai != "" && tgl_akhir!= "" && wkt_mulai != "" && wkt_akhir != "" ) {
    // validasi tanggal mulai dan tanggal akhir
    if (tgl_mulai<tgl_akhir) {

      
     var url = base_url+"index.php/toback/buatTo";
     $.ajax({
      url : url,
      type: "POST",
      data: { nmpaket : nm_paket,
       tglmulai:tgl_mulai,
       tglakhir:tgl_akhir,
       wktmulai:wkt_mulai,
       wktakhir:wkt_akhir,
       publish :publish 

     },
       // cache: false,
       // dataType: "JSON",
       success: function(data,respone)
      {   
        reload_tblist();  
        $("#e_crtTo").hide(); 
        $('#modalto').modal('hide'); 
        $('#form_to')[0].reset(); // reset form on modals
        $('#modalto').removeClass('has-error'); // clear error class  

        },
        error: function (jqXHR, textStatus, errorThrown)
        {

                            // $("#e_crtTo").show();
        lert('Error adding / update data');
        }
        });
   }else if(tgl_mulai==tgl_akhir) {
    if (wkt_mulai>=wkt_akhir) {
      $("#e_wktTo").show();
    }else{
          var url = base_url+"index.php/toback/buatTo";
     $.ajax({
      url : url,
      type: "POST",
      data: { nmpaket : nm_paket,
       tglmulai:tgl_mulai,
       tglakhir:tgl_akhir,
       wktmulai:wkt_mulai,
       wktakhir:wkt_akhir,
       publish :publish 

     },
       // cache: false,
       // dataType: "JSON",
       success: function(data,respone)
      {   
        reload_tblist();  
        $("#e_crtTo").hide(); 
        $('#modalto').modal('hide'); 
        $('#form_to')[0].reset(); // reset form on modals
        $('#modalto').removeClass('has-error'); // clear error class  

        },
        error: function (jqXHR, textStatus, errorThrown)
        {

                            // $("#e_crtTo").show();
        lert('Error adding / update data');
        }
        });
    }
    
   }else {
     $("#e_tglTo").show();
   }
   
 }else{

   $("#e_crtTo").show();
 }



}
// ####################################################
            //buat load tingkat untuk modal buat soal
            // load tingkat untuk modal bank soal
            function loadTkt() {
             jQuery(document).ready(function () {
              var tingkat_id = {"tingkat_id": $('#stkt2').val()};
              // tingkat id untuk modal video
              // var tingkat_idv = {"tingkat_id": $('vstkt').val()}
              var idTingkat;

              $.ajax({
               type: "POST",
               data: tingkat_id,
               url: "<?= base_url() ?>index.php/videoback/getTingkat",
               success: function (data) {

                $('.gettkt2').html('<option value="">-- Pilih Tingkat  --</option>');
                $.each(data, function (i, data) {
                 $('.gettkt2').append("<option value='" + data.id + "'>" + data.aliasTingkat + "</option>");
                 return idTingkat = data.id;
               });
              }
            });
              // event untuk modal bank soal
              // #############################
              $('#stkt2').change(function () {
               tingkat_id = {"tingkat_id": $('#stkt2').val()};
               loadPel($('#stkt2').val());
             });
              $('#spel2').change(function () {
               pelajaran_id = {"pelajaran_id": $('#spel2').val()};
               loadBb($('#spel2').val());
             });
              $('#sbab2').change(function () {
               loadSubb($('#sbab2').val());
               // loadPel(idTingkat);
             });
              // #############################

              // event untuk modal video
              // ##############################
              $('#vtkt').change(function () {
               tingkat_id = {"tingkat_id": $('#vtkt').val()};
               loadPelv($('#vtkt').val());
             });
              $('#vpel').change(function () {
               pelajaran_id = {"pelajaran_id": $('#vpel').val()};
               loadBbv($('#vpel').val());
             });
              $('#vbab').change(function () {
               loadSubbv($('#vbab').val());
               // loadPel(idTingkat);
             });
               // ##############################
             })
           }
           ;

            //buat load pelajaran untuk  modal bank soal
            function loadPel(tingkatID) {
             $.ajax({
              type: "POST",
              data: tingkatID.tingkat_id,
              url: "<?php echo base_url() ?>index.php/videoback/getPelajaran/" + tingkatID,
              success: function (data) {
               $('#spel2').html('<option value="">-- Pilih Mata Pelajaran  --</option>');
               $.each(data, function (i, data) {
                $('#spel2').append("<option value='" + data.id + "'>" + data.keterangan + "</option>");
              });
             }
           });
           }
            //buat load pelajaran untuk  modal filter video
            function loadPelv(tingkatID) {
             $.ajax({
              type: "POST",
              data: tingkatID.tingkat_id,
              url: "<?php echo base_url() ?>index.php/videoback/getPelajaran/" + tingkatID,
              success: function (data) {
               $('#vpel').html('<option value="">-- Pilih Mata Pelajaran  --</option>');
               $.each(data, function (i, data) {
                $('#vpel').append("<option value='" + data.id + "'>" + data.keterangan + "</option>");
              });
             }
           });
           }
            // load bab untuk modal bank soal
            function loadBb(mapelID) {
             $.ajax({
              type: "POST",
              data: mapelID.mapel_id,
              url: "<?php echo base_url() ?>index.php/videoback/getBab/" + mapelID,
              success: function (data) {

               $('#sbab2').html('<option value="">-- Pilih Bab Pelajaran  --</option>');

               $.each(data, function (i, data) {
                $('#sbab2').append("<option value='" + data.id + "'>" + data.judulBab + "</option>");
              });
             }

           });
           }
             //load bab untuk modal video
             function loadBbv(mapelID) {
               $.ajax({
                type: "POST",
                data: mapelID.mapel_id,
                url: "<?php echo base_url() ?>index.php/videoback/getBab/" + mapelID,
                success: function (data) {

                 $('#vbab').html('<option value="">-- Pilih Bab Pelajaran  --</option>');

                 $.each(data, function (i, data) {
                  $('#vbab').append("<option value='" + data.id + "'>" + data.judulBab + "</option>");
                });
               }

             });
             }

            //load sub bab untuk modal soal
            function loadSubb(babID){
             $.ajax({
              type: "POST",
              data: babID.bab_id,
              url: "<?php echo base_url() ?>index.php/videoback/getSubbab/"+babID,
              success: function(data){
               $('#ssub2').html('<option value="">-- Pilih Sub Bab Pelajaran  --</option>');

               $.each(data, function(i, data){
                $('#ssub2').append("<option value='"+data.id+"'>"+data.judulSubBab+"</option>");
              });
             }

           });
           }
            // load sub bab untk modal video
            function loadSubbv(babID){
             $.ajax({
              type: "POST",
              data: babID.bab_id,
              url: "<?php echo base_url() ?>index.php/videoback/getSubbab/"+babID,
              success: function(data){
               $('#vsub').html('<option value="">-- Pilih Sub Bab Pelajaran  --</option>');

               $.each(data, function(i, data){
                $('#vsub').append("<option value='"+data.id+"'>"+data.judulSubBab+"</option>");
              });
             }

           });
           }



           loadTkt();
// ####################################################

</script>
<!-- Cometchat -->
<link type="text/css" href="/cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="/cometchat/cometchatjs.php" charset="utf-8"></script>
<!--/ App and page level script -->
<!--/ END JAVASCRIPT SECTION -->
</body>
<!--/ END Body -->
</html>