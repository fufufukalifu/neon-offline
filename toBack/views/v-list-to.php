</style>
<script type="text/javascript" src="<?=base_url('assets/javascript/components/button.js') ?>"></script>
<section id="main" role="main">
  <!-- MODAL EDIT TO -->
  <div class="modal fade" id="modal_editTO" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <!--START Header Modal -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h3 class="modal-title">Ubah Try Out</h3>
        </div>
        <!--END Header Modal -->
        <!--START Body Modal -->
        <div class="modal-body form">
          <!-- START PESAN ERROR EMPTY INPUT -->
          <div class="alert alert-dismissable alert-danger" id="e_editTo" hidden="true" >
            <button type="button" class="close" onclick="hide_e_editTo()" >×</button>
            <strong>O.M.G.!</strong> Tolong di ISI semua.
          </div>
          <!-- END PESAN ERROR EMPTY INPUT -->
          <!-- START PESAN ERROR EMPTY INPUT -->
          <div class="alert alert-dismissable alert-danger" id="e_editWkt" hidden="true" >
            <button type="button" class="close" onclick="hide_e_editWkt()" >×</button>
            <strong>Silahkan cek kembali!</strong> Waktu mulai dan waktu berakhir tidak sesuai.
          </div>
          <!-- END PESAN ERROR EMPTY INPUT -->
          <!-- START PESAN ERROR EMPTY INPUT -->
          <div class="alert alert-dismissable alert-danger" id="e_editTgl" hidden="true" >
            <button type="button" class="close" onclick="hide_e_editTgl()" >×</button>
            <strong>Silahkan cek kembali!</strong> Tanggal mulai dan tanggal akhir tidak sesuai.
          </div>
          <!-- END PESAN ERROR EMPTY INPUT -->
          <!-- Start Form Edit TO -->
          <form action="javascript:void(0);" id="formeditTO"  class="panel panel-default form-horizontal form-bordered">
            <div class="panel-body">
             <div class="form-group">
              <input type="hidden" value="" name="id_tryout"/>
              <label class="col-sm-3 control-label">Nama Tryout</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nama_tryout">
              </div>
            </div>
            <div  class="form-group">
              <label class="col-sm-3 control-label">Tanggal Mulai</label>
              <div class="col-sm-4">
                <input type="date" class="form-control" name="tgl_mulai">
              </div>
              <div class="col-sm-4">
               <input type="time" class="form-control" name="wkt_mulai"  >
             </div>
           </div>
           <div  class="form-group">
            <label class="col-sm-3 control-label">Tanggal Berakhir</label>
            <div class="col-sm-4">
              <input type="date" class="form-control" name="tgl_berhenti">
            </div>
            <div class="col-sm-4">
              <input type="time" class="form-control" name="wkt_akhir"  >
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label">Publish?</label>
            <div class="col-sm-8">
              <div class="checkbox custom-checkbox">  
                <input type="checkbox" name="publish" id="publish" value="1">  
                <label for="publish">&nbsp;&nbsp;</label>   
              </div>
            </div>
          </div> 
        </div>
        <div class="panel-footer">
          <button type="submit" class="btn btn-primary" name="proses" onclick="saveedit()" >Proses</button>
          <button type="reset" class="btn btn-inverse" id="btnReset">reset</button>
        </div>
      </form>
      <!-- END Form Edit TO   -->
    </div>
    <!--END Body Modal -->
  </div>
</div>
</div>
<!-- END MODAL EDIT TRYOUT -->
<!-- START MODAL EDIT TRYOUT -->
<script type="text/javascript">halaman = true;</script>
<div class="modal fade" id="modal_daftar" role="dialog">
  <div class="modal-dialog"  style="width:95%">
    <div class="modal-content">
      <!--START Header Modal -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Daftar Tryout</h3>
      </div>
      <!--END Header Modal -->
      <!--START Body Modal -->
      <div class="modal-body">
        <table class="table table-striped" id="table_to_modal" style="font-size: 13px" width=100%>
          <thead>
           <tr>
            <th>ID </th>
            <th>Nama TO</th>
            <th>Tanggal Mulai</th>
            <th>Waktu Mulai</th>
            <th>Tanggal Berakhir</th>
            <th>Waktu Berakhir</th>
            <th>Status Publish</th>
            <th>Aksi</th>

          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!--END Body Modal -->
  </div>
</div>
</div>
<!-- END MODAL EDIT TRYOUT -->

<!-- START Template Container -->
<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title">Daftar Tryout Yang Sudah Di Download</h3>
     <div class="panel-toolbar text-right">
      <a class="btn btn-inverse btn-outline daftar-to" title="Daftar Tryout" onclick="daftar_tryout()"><i class="ico-th-list"></i></a>

    </div>
  </div>
  <div class="panel-body">

    <div class="indicator hide"><span class="spinner spinner8"></span></div>

  </div>

  <table class="table table-striped" id="tblistTO" style="font-size: 13px" width=100%>
    <thead>
     <tr>
      <th>ID </th>
      <th>Nama TO</th>
      <th>Tanggal Mulai</th>
      <th>Waktu Mulai</th>
      <th>Tanggal Berakhir</th>
      <th>Waktu Berakhir</th>
      <th>Status Publish</th>
            <th>Sync</th>
      
      <th>Aksi</th>

    </tr>
  </thead>
  <tbody>


  </tbody>
</table>
</div>

</div>
</div>
<script type="text/javascript">
var tblist_TO;
var daftar_to_modal;

// lihat daftar to
function daftar_tryout(){
  $('#modal_daftar').modal('show');
  
  daftar_to_modal = $('#table_to_modal').DataTable({ 
   "ajax": {
    "url": base_url+"toback/data_table_all_to",
    "type": "POST",
    "dataType": "json"
  },
  "processing": true,
  "bDestroy": true,
  
});

}
// INSERT TO YANG UDAH DI GET
function insert_to(obc){

  $('.indicator').removeClass('hide');
  $('.indicator').addClass('show');
  datas = obc;
  // download_paket(datas.UUID);
  url = base_url+"toback/ajax_insert_to";
  $.ajax({
    url : url,
    type: "POST",
    dataType: "json",
    data:datas,
    success: function(data)
    {
     $('.indicator').removeClass('show');
     $('.indicator').addClass('hide');
     if (data.status==1) {
      swal('Tryout Berhasil Di download');
      tblist_TO.ajax.reload();
    }else{
      swal('Tryout sudah tersedia');
      tblist_TO.ajax.reload();

    };
  },
  error: function (jqXHR, textStatus, errorThrown)
  {
    swal('Gagal koneksi ke server');
  }
});
}


// INSERT PAKET YANG SUDAH DI GET KE DATABASE
function insert_paket(datas){
  $('.indicator').removeClass('hide');
  $('.indicator').addClass('show');
  var message;
  
  url = base_url+"toback/inserpaket/"+datas;

  $.ajax({
    url : url,
    type : "post",
    data : datas,
    dataType : "json",
    success : function(data) {
      $('.indicator').removeClass('show');
      $('.indicator').addClass('hide');
      if (data.jumlah_paket==0) {
        message = "Paket sudah disinkronisasi semua";
      }else{
        message = "jumlah yang di sinkron : "+data.jumlah_paket;        
      }
      swal("Berhasil!", message, "success");
    },
    error : function(error) {
      sweetAlert("Oops...", "Gagal mensinkronisasi paket!", "error");
    }
  });
}


// download tryout (GET PAKET)
function download_tryout(id){
  // url = "http://localhost:9090/neon-admin/webservice/tryoutoffline";
  url = "http://localhost:81/netjoo-admin/webservice/tryoutoffline";

  $.ajax({
    url : url,
    type: "POST",
    data:{id_tryout:id},
    dataType: "json",
    success: function(data)
    {
      // console.log(data);
      $.each(data, function(index, value) {
        insert_to(value);
      });
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      console.log("gagal download");
    }
  });
}


// download paket tryout (GET PAKET)
function download_paket(uuid){
  $('.indicator').removeClass('hide');
  $('.indicator').addClass('show');
  url = "http://localhost:81/netjoo-admin/webservice/paketoffline/"+uuid;
  // url = "http://localhost:9090/neon-admin/webservice/paketoffline/"+uuid;

  $.ajax({
    url : url,
    type: "POST",
    dataType: "json",
    success: function(data)
    {
     $('.indicator').removeClass('show');
     $('.indicator').addClass('hide');
     $.each(data, function(index, value) {

      insert_paket(value);
        // console.log("Berhasil Get");
      });
   },
   error: function (jqXHR, textStatus, errorThrown)
   {

   }
 });
}


// download siswa dan pengguna
function download_siswa_pengguna(){
  $('.indicator').removeClass('hide');
  $('.indicator').addClass('show');
  url = base_url+"toback/insert_mahasiswa/";
  $.ajax({
    url : url,
    type: "POST",
    dataType: "json",
    success: function(data)
    {
      if (data.jumlah_siswa==0) {
        message = "Siswa sudah disinkronisasi semua";
      }else{
        message = "jumlah yang siswa di sinkron : "+data.jumlah_siswa;        
      }
      swal("Berhasil!", message, "success");
      $('.indicator').removeClass('show');
      $('.indicator').addClass('hide');
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      sweetAlert("Oops...", "Gagal mensinkronisasi Siswa!", "error");
    }
  });
}

// download siswa dan pengguna
function download_soal(data){
  $('.indicator').removeClass('hide');
  $('.indicator').addClass('show');
  url = base_url+"toback/insert_soal/"+data;
  $.ajax({
    url : url,
    type: "POST",
    dataType: "json",
    success: function(data)
    {
      if (data.jumlah_soal==0) {
        message = "Soal sudah disinkronisasi semua";
      }else{
        message = "jumlah yang soal di sinkron : "+data.jumlah_soal;        
      }
      swal("Berhasil!", message, "success");
      $('.indicator').removeClass('show');
      $('.indicator').addClass('hide');     
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      sweetAlert("Oops...", "Gagal mensinkronisasi Soal!", "error");
    }
  });
}

var tblist_TO;
$(document).ready(function() {
  tblist_TO = $('#tblistTO').DataTable({ 
   "ajax": {
    "url": base_url+"index.php/toback/ajax_listsTO/",
    "type": "POST"
  },
  "processing": true,
});
});


    // ##opik##
    function show_peserta(uuid){
      window.location = 'reportto/'+uuid;
    }

    // 
    function hide_e_editTo() {
     $("#e_editTo").hide();
   }
   function hide_e_editTgl() {
     $("#e_editTgl").hide();
   }
   function hide_e_editWkt() {
     $("#e_editWkt").hide();
   }

   function edit_TO(id_tryout) 
   {
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string  
            $('#modal_editTO').modal('show'); 
            $.ajax({
              url : base_url+"index.php/toback/ajax_edit/" + id_tryout,
              type: "GET",
              dataType: "JSON",
              success: function(data)
              {
                $('[name="id_tryout"]').val(data.id_tryout);
                $('[name="nama_tryout"]').val(data.nm_tryout);
                $('[name="tgl_mulai"]').val(data.tgl_mulai);
                $('[name="wkt_mulai"]').val(data.wkt_mulai);
                $('[name="tgl_berhenti"]').val(data.tgl_berhenti);
                $('[name="wkt_akhir"]').val(data.wkt_berakhir);
                     // $('[name="publish"]').val(data.publish);
                     if (data.publish==1) {
                      $('#publish').attr('checked',true)
                    } else {
                      $('#publish').attr('unchecked',true)
                    }
                    $('#modal_editTO').modal('show');  // show bootstrap modal when complete loaded
                    // $('.modal-title').text('Edit Paket Soal'); // Set title to Bootstrap modal title

                  },
                  error: function (jqXHR, textStatus, errorThrown)
                  {
                    alert('Error get data from ajax');
                  }
                });
}

  // menyimpan data yang diedit
  function saveedit(){

    var url;


            // VAR U/ PENGECEKAN INPUT
            var nm_paket   =   $('[name="nama_tryout"]').val();
            var tgl_mulai  =   $('[name="tgl_mulai"]').val();
            var tgl_akhir  =   $('[name="tgl_berhenti"]').val();
            var wkt_mulai  =   $('[name="wkt_mulai"]').val();
            var wkt_akhir  =   $('[name="wkt_akhir"]').val();
            // /
            // pengecekan inputan pembuatan to
            // cek inputan kosong
            if (nm_paket != "" && tgl_mulai != "" && tgl_akhir!= "" && wkt_mulai != "" && wkt_akhir != "" ) {
                // validasi tanggal mulai dan tanggal akhir
                if (tgl_mulai<tgl_akhir) {
                  var datas = $('#formeditTO').serialize();
                  // JIKA BERHASIL
                  url = base_url+"index.php/toback/editTryout/";
                  // ajax adding data to database
                  $.ajax({
                    url : url,
                    type: "POST",
                    data: datas,
                    dataType: "TEXT",
                    success: function(data)
                    {
                      $('#modal_editTO').modal('hide'); 
                      reload_tblist(); 
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                      alert('Error adding / update data');

                    }
                  });
                }else if(tgl_mulai==tgl_akhir) {
                  if (wkt_mulai>=wkt_akhir) {
                    $("#e_editWkt").show();
                  }else{
                    var datas = $('#formeditTO').serialize();
                      // JIKA BERHASIL
                      url = base_url+"index.php/toback/editTryout/";
                      // ajax adding data to database
                      $.ajax({
                        url : url,
                        type: "POST",
                        data: datas,
                        dataType: "TEXT",
                        success: function(data)
                        {
                          $('#modal_editTO').modal('hide'); 
                              // reload_tblist(); 
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                              alert('Error adding / update data');

                            }
                          });
                    }
                  }else {
                   $("#e_editTgl").show();
                 }

               }else{
                 $("#e_editTo").show();
               }

             }

             function reload_tblist(){
              tblist_TO.ajax.reload(null,false); 
            }
            </script>
          </section>