 <style>
   form.subscribe input[name="token"]{
     display: inline-block;
     background-color: #ffffff;
     line-height: 40px;
     height: 40px;
     padding: 0 18px;
     border: 0;
     width: calc(100% - 120px);
     width: -moz-calc(100% - 125px);
     border-top-left-radius: 4px;
     -ms-border-top-left-radius: 4px;
     -moz-border-top-left-radius: 4px;
     -webkit-border-top-left-radius: 4px;
     border-bottom-left-radius: 4px;
     -ms-border-bottom-left-radius: 4px;
     -moz-border-bottom-left-radius: 4px;
     -webkit-border-bottom-left-radius: 4px;  
   }
 </style>


<br>
<div class="container">
  <div class="row">
    <div class="col-md-7">
      <div class="panel panel-default">
        <!-- panel heading/header -->
        <div class="panel-heading">
          <h3 class="panel-title">Konfirmasi Tes</h3>
        </div>
        <!--/ panel heading/header -->
        <!-- panel body -->
        <div class="panel-body">
          <?php foreach ($tryout as $to) : ?>
            <div class="form-group">
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Nama Tryout</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label"><?=$to->nm_tryout;?></label>
                </div>
              </div>
            <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Nama Paket</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label"><?=$to->nm_paket;?></label>
                </div>
              </div>
            <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Tanggal Tes</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label"><?=$to->tgl_mulai;?></label>
                </div>
              </div>
            <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Waktu Tes</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label"><?=$to->wkt_mulai;?></label>
                </div>
              </div>
            <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Alokasi Waktu Tes</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label"><?=$to->durasi;?> Menit</label>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12">
                  <label class="control-label">Jenis Penilaian</label>
                </div>
                <div class="col-sm-12">
                  <label class="control-label text-danger bold"><?=$to->jenis_penilaian;?></label>
                </div>
              </div>


            </div>
            <a class="modal-on"
                  data-todo='<?=json_encode($to)?>'></a>
          <?php endforeach ?>
        </div>
        <!-- end panel body -->
      </div>
   </div>
    <div class="col-md-5">
      <div class="alert alert-warning fade in">
        <p class="mb10">
          <i class="glyphicon glyphicon-info-sign"></i>
          Tombol MULAI akan aktif apabila waktu sekarang sudah melewati waktu mulai test. Tekan f5 untuk merefresh halaman.
        </p>
      </div>
        <a href="#" class="col-sm-12 btn btn-danger" onclick="kerjakan_paket()">Mulai Tryout</a>
    </div>
  </div>

<script>
  //MULAI TRYOUT
  function kerjakan_paket(){  
    var kelas = ".modal-on";
    var data_to = $(kelas).data('todo');
    url = base_url+"index.php/tryout/buatto";

    var global_properties = {
      id_paket: data_to.id_paket,
      id_tryout: data_to.id_tryout,
      id_mm_tryoutpaket: data_to.mm_id
    };

    $.ajax({
      url : url,
      type: "POST",
      data: global_properties,
      dataType: "TEXT",
      success: function(data){
       window.location.href = base_url + "index.php/tryout/mulaitest";
     },error: function (jqXHR, textStatus, errorThrown,data){
        // console.log(data);
        sweetAlert("Oops...", "wah, gagal menghubungkan!", "error");
    }
  });
}
</script>