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
 <!-- MODAL -->
 <div class="modal fade" id="modal_paket">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Modal title</h4>
      </div><div class="container"></div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <a href="#" data-dismiss="modal" class="btn">Batal</a>
        <a href="#" class="btn btn-primary" onclick="kerjakan_paket()">Mulai Tryout</a>
      </div>
    </div>
  </div>
</div>
<!-- MODAL -->


<br>
<div class="container">
  <div class="parallaxed">
    <div class="parallax-image" data-parallax-left="0.5" data-parallax-top="0.3" data-parallax-scroll-speed="0.5" style="transform: translateY(-193.647px) translateZ(0px); left: -284.5px;">
      <img src="<?=base_url('assets/back/img/parallax.png') ?>" alt="" style="height: auto; width: auto;">
    </div>
    <div class="them-mask bg-color-2"></div>
    <div class="grid-row center-text">
      <div class="font-style-1 margin-none">Masukan Token</div>
      <div class="divider-mini"></div>
      <p class="parallax-text">Untuk memulai tryout online, silahkan masukan token terlebih dahulu.</p>
      <form class="subscribe" id="cek_token">
        <input type="text" name="token" value="" size="40" placeholder="Masukan token anda..." aria-required="true"><input type="submit" value="Submit">
      </form>
    </div>
  </div>
</div>

<script>
  var global_properties = {
    id_paket:"",
    id_tryout:"",
    id_mm_tryoutpaket:""
  };

  // KETIKA USER MELAKUKAN AKSI SUBMIT PADA FORM
  $('#cek_token').submit(function(){
    validasi_token_tryout();
    return false;
  });

  // CEK TOKEN TERSEBUT PAKET APA
  function validasi_token_tryout(){
    url_ajax = base_url+"tryout/ajax_cek_validasi_tokentryout";

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
          }else{
          show_modal_paket(hasil_paket);            
          }
        }
      },error:function(data){
        sweetAlert("Oops...", "wah, gagal menghubungkan!", "error");
      }
    });
  }

  // MENAMPILKAN MODAL PAKET
  function show_modal_paket(data){  
    console.log(data);
    // parameter untuk memulai tryout  
    global_properties.id_paket = data.id_paket;
    global_properties.id_tryout = data.id_tryout;
    global_properties.id_mm_tryoutpaket = data.mm_id;

    $('#modal_paket').modal('show');
    $('#modal_paket .modal-title').html("Nama Tryout : "+data.nm_tryout);
    var konten ="<span> <b>Kode Token</b> : "+data.token+"</span><br>" +
                "<span> <b>Nama Paket</b> : "+data.nm_paket+"</span>" +
                "<p><b>Deskripsi : <br> </b>"+data.deskripsi+"</p>" +
                "<span><b>Jumlah Soal :</b> "+data.jumlah_soal+" Soal </span><br>" +
                "<span><b>Tanggal Tryout : </b>"+data.tgl_mulai+" - "+data.tgl_berhenti+"</span><br>" +
                "<span><b>Durasi : </b>"+data.durasi+" Menit </span>";
    $('#modal_paket .modal-body').html(konten);
  }

  //MULAI TRYOUT
  function kerjakan_paket(){      
    url = base_url+"index.php/tryout/buatto";

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