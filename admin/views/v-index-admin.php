<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
  <!-- START META SECTION -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{judul_halaman}</title>
  <meta name="author" content="pampersdry.info">
  <meta name="description" content="Adminre is a clean and flat backend and frontend theme build with twitter bootstrap 3.1.1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= base_url('assets/image/touch/apple-touch-icon-144x144-precomposed.png') ?>">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= base_url('assets/image/touch/apple-touch-icon-114x114-precomposed.png') ?>">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= base_url('assets/image/touch/apple-touch-icon-72x72-precomposed.png') ?>">
  <link rel="apple-touch-icon-precomposed" href="<?= base_url('assets/image/touch/apple-touch-icon-57x57-precomposed.png') ?>">
  <link rel="shortcut icon" href="<?= base_url('assets/image/favicon.ico') ?>">
  <script type="text/javascript" src="<?= base_url('assets/library/jquery/js/jquery.min.js') ?>"></script>
  <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/css/jquery.datatables.min.css'); ?>">
    <script src="<?= base_url('assets/sal/sweetalert-dev.js');?>"></script>
    <link rel="stylesheet" href="<?= base_url('assets/sal/sweetalert.css');?>">
  <script>var base_url = '<?php echo base_url() ?>';</script>
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

  <!-- START JAVASCRIPT SECTION - Load only modernizr script here -->
  <script src="<?= base_url('assets//library/modernizr/js/modernizr.min.js') ?>"></script>
  <!--/ END JAVASCRIPT SECTION -->
</head>
<!--/ END Head -->

<!-- START Body -->
<body>
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
     <form  class="panel panel-default form-horizontal form-bordered" action="<?=base_url();?>index.php/banksoal/listsoal" method="get" >
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

    <div  class="form-group">
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
      
      <!--/ Notification dropdown -->

    </ul>
    <!--/ END Left nav -->

    <!-- START Right nav -->
    <ul class="nav navbar-nav navbar-right">
      <!-- Profile dropdown -->
      <li class="dropdown profile">
        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
          <span class="meta">
            <span class="avatar"><img src="<?= base_url('assets/image/avatar/avatar7.jpg') ?>" class="img-circle" alt="" /></span>
            <span class="text hidden-xs hidden-sm pl5"><?=$this->session->userdata['USERNAME'];?></span>
            <span class="caret"></span>
          </span>
        </a>
        <ul class="dropdown-menu" role="menu">

          <li><a href="<?=base_url('index.php/logout');?>"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
        </ul>
      </li>
      <!-- Profile dropdown -->

      <!-- Offcanvas right This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->

      <!--/ Offcanvas right -->
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
        <a href="<?= base_url('index.php/admin') ?>">
          <span class="figure"><i class="ico-trophy"></i></span>
          <span class="text">Dashboard</span>
        </a>
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
 <a href="<?= base_url('index.php/toback/listTo');?>">
  <span class="text">Daftar Try Out</span>
</a>
</li>
<li>
 <a href="<?= base_url('index.php/admincabang/laporanpaket');?>">
  <span class="text">Laporan Try Out</span>
</a>
</li>

</ul>
</li>

<li>
  <a href="<?= base_url('index.php/toback/report_tryout') ?>">
    <span class="figure"><i class=" ico-bars6"></i></span>
    <span class="text">Report Tryout</span>
  </a>
</li>

 <li>
  <a href="<?= base_url('index.php/admincontrol/pengerjaan') ?>">
    <span class="figure"><i class=" ico-bars6"></i></span>
    <span class="text">Admin Control</span>
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
        <h4 class="title semibold">{judul_halaman}</h4>
      </div>
      <div class="page-header-section">
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
<script type="text/javascript" src="<?= base_url('assets/js/custom.js') ?>"></script>
<script type="text/javascript">
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


 function hide_e_crtTo() {
  $("#e_crtTo").hide();
}
function hide_e_tglTo() {
  $("#e_tglTo").hide();
}
function crtTo() {
  var nm_paket   =   $('#to_nm').val();
  var tgl_mulai  =   $('#to_tglmulai').val();
  var tgl_akhir  =   $('#to_tglakhir').val();
  var wkt_mulai  =   $('#to_wktakhir').val();
  var wkt_akhir  =   $('#to_wktmulai').val();
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
      alert('Error adding / update data');
    }
  });
   } else {
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
              var tingkat_id = {"tingkat_id": $('#stkt').val()};
              // tingkat id untuk modal video
              // var tingkat_idv = {"tingkat_id": $('vstkt').val()}
              var idTingkat;

              $.ajax({
               type: "POST",
               data: tingkat_id,
               url: "<?= base_url() ?>index.php/videoback/getTingkat",
               success: function (data) {

                $('.gettkt').html('<option value="">-- Pilih Tingkat  --</option>');
                $.each(data, function (i, data) {
                 $('.gettkt').append("<option value='" + data.id + "'>" + data.aliasTingkat + "</option>");
                 return idTingkat = data.id;
               });
              }
            });
              // event untuk modal bank soal
              // #############################
              $('#stkt').change(function () {
               tingkat_id = {"tingkat_id": $('#stkt').val()};
               loadPel($('#stkt').val());
             });
              $('#spel').change(function () {
               pelajaran_id = {"pelajaran_id": $('#spel').val()};
               loadBb($('#spel').val());
             });
              $('#sbab').change(function () {
               loadSubb($('#sbab').val());
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
               $('#spel').html('<option value="">-- Pilih Mata Pelajaran  --</option>');
               $.each(data, function (i, data) {
                $('#spel').append("<option value='" + data.id + "'>" + data.keterangan + "</option>");
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

               $('#sbab').html('<option value="">-- Pilih Bab Pelajaran  --</option>');

               $.each(data, function (i, data) {
                $('#sbab').append("<option value='" + data.id + "'>" + data.judulBab + "</option>");
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
               $('#ssub').html('<option value="">-- Pilih Sub Bab Pelajaran  --</option>');

               $.each(data, function(i, data){
                $('#ssub').append("<option value='"+data.id+"'>"+data.judulSubBab+"</option>");
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