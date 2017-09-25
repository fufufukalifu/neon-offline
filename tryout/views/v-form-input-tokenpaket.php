 <br>
<div class="container">
  <!-- row -->
  <div class="row">
    <!-- col-md-2 -->
    <div class="col-md-2">
    </div>
    <!--/ col-md-2 -->

     <!-- col-md-8 -->
    <div class="col-md-8">
      <!-- panel panel-default -->
      <div class="panel panel-default">
        <!-- panel heading/header -->
        <div class="panel-heading">
          <h3 class="panel-title">Konfirmasi Data Peserta</h3>
        </div>
        <!--/ panel heading/header -->
        <!-- panel body -->
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <label class="control-label"><b>Nama Peserta</b></label>
            </div>
            <div class="col-sm-12">
              <label class="control-label"><?=$this->session->userdata('NAMASISWA') ?></label>
            </div>
          </div>
          <hr>
          <form id="cek_token">
          <div class="row">
            <div class="col-sm-12">
              <label class="control-label"><b>Token</b></label>
            </div>
            <div class="col-sm-4">
                <input type="text" name="token" value="" size="40" placeholder="Masukan token anda..." aria-required="true">
            </div>
          </div>
          <hr style="margin-top: 10px; margin-bottom: 10px;">
            <div class="col-sm-9">
            </div>
            <div class="col-sm-3">
              <input type="submit" value="Submit" class="col-sm-12 btn btn-success">
            </div>
          </form>
        </div>
        <!--/ panel body -->
      </div>
      <!-- panel panel-default -->
    </div>
    <!--/ col-md-8 -->
  </div>
  <!--/ row -->
</div>

<script>
  // KETIKA USER MELAKUKAN AKSI SUBMIT PADA FORM
  $('#cek_token').submit(function(){
    validasi_token_tryout();
    return false;
  });

  // CEK TOKEN TERSEBUT PAKET APA
  function validasi_token_tryout(){
    url_ajax = base_url+"tryout/ajax_cek_validasi_tokentryout";
    kode_token = $('input[name=token]').val();

    $.ajax({
      type: "POST",
      dataType: "TEXT",
      url: url_ajax,
      data: $('#cek_token').serialize(),
      success: function(data){
        hasil_paket = JSON.parse(data);
        if (hasil_paket.status=='false') {
          sweetAlert("Oops...", "wah, token yang kamu masukan tidak ditemukan!", "error");
        }else{
          if (hasil_paket.status=='done') {
            sweetAlert("Wah...", "token yang kamu masukan sudah dikerjakan, silahkan masukan token lain!", "success");
          }else if(hasil_paket.status=='forbidden'){
            sweetAlert("Wah...", "token yang kamu masukan sudah habis waktunya, silahkan masukan token lain!", "error");
          }else if(hasil_paket.status=='yet'){
            sweetAlert("Wah...", "token yang kamu masukan belum bisa dikerjakan, silahkan masukan token lain!", "error");
          }else{
            next(kode_token);         
          }
        }
      },error:function(data){
        sweetAlert("Oops...", "wah, gagal menghubungkan!", "error");
      }
    });
  }

  // konfirmasi tes
  function next(kode_token) {
    console.log(kode_token);
    url_ajax = base_url+"tryout/next";

    var global_properties = {
      token: kode_token
    };

    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: url_ajax,
      data: global_properties,
      success: function(data){
        // console.log(data);
        window.location.href = base_url + "tryout/konfirmasi";  
      },error:function(data){
        sweetAlert("Oops...", "wah, gagal menghubungkan!", "error");
      }

    });
  }
</script>