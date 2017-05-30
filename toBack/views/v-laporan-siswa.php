<div class="row">
  <!-- LAPORAN SEMUA PAKET TRYOUT -->
  <div class="col-md-12">
    <div class="panel panel-teal">
      <!--Start untuk menampilkan nama tabel -->
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Nilai Tryout</h3>
          <div class="panel-toolbar text-right">
            <div class="col-md-12">
              <div class="col-sm-4">  
              </div>
              <div class="col-sm-4">
               <select class="form-control" id="select_to">
                <option value="all">Semua Tryout</option>          
                <?php foreach ($to as $item): ?>
                  <option value="<?=$item['id_tryout']?>"><?=$item['nm_tryout'] ?></option>
                <?php endforeach ?>
              </select>
            </div>

              <div class="col-sm-4">
               <select class="form-control col-sm-6" id="select_paket">
                <option value="all">Semua paket</option>
              </select>
              <!-- <button class="btn btn-sm btn-inverse " onclick="pdf()">PDF</button> -->
            </div>
          </div>                  
        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped rpaket"  style="font-size: 13px" width="100%">
                            <thead>
                                <tr>
                                    <th>no</th>
            <th>Nama Siswa</th>
            <th>Nama Paket</th>
            <th>Nama Tryout</th>
            <th>Jumlah Soal</th>
            <th>Benar</th>
            <th>Salah</th>
            <th>Kosong</th>
            <th>Nilai</th>
            <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>


            </div>
<!-- LAPORAN SEMUA PAKET TRYOUT -->


<!--datatable-->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/js/jquery.datatables.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/tabletools/js/tabletools.min.js') ?>"></script>
<!--<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/tabletools/js/zeroclipboard.js') ?>"></script>-->
<script type="text/javascript" src="<?= base_url('assets/plugins/datatables/js/jquery.datatables-custom.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('assets/javascript/tables/datatable.js') ?>"></script>
<script type="text/javascript">
    
    // ## datatable report tryout
url = base_url+"toback/ajax_report_tryout";

dataTableReportPaket = $('.rpaket').DataTable({
  "ajax": {
    "url": url,
    "type": "POST",
  },
  "emptyTable": "Tidak Ada Data Pesan",
  "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
  "bDestroy": true,
});
// ## datatable report tryout

function reload(){
  url = base_url+"toback/ajax_report_tryout";

  dataTableReportPaket = $('.rpaket').DataTable({
    "ajax": {
      "url": url,
      "type": "POST",
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });
  // ## datatable report tryout 
}
function delete_report(id)
{

// =============
url = base_url+"toback/dropreporttry/"+id;
  swal({
    title: "Yakin akan menghapus Paket ini?",
    text: "Anda tidak dapat membatalkan ini.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya,Tetap hapus!",
    closeOnConfirm: false
  },

  function(){
    var datas = {id:id};
    $.ajax({
      dataType:"text",
      data:datas,
      type:"POST",
      url:url,
      success:function(){
        swal("Terhapus!", "Paket berhasil dihapus.", "success");
        reload();
      },
      error:function(){
        sweetAlert("Oops...", "Data gagal terhapus!", "error");
      }
    });
  });

// ======================

}

// TO KETIKA DI CHANGE
  $('#select_to').change(function(){
    tryout = $('#select_to').val();
    paket = $('#select_paket').val();
    filter_to(tryout);
    load_paket(tryout);
  });

//ketika paket di change
function load_paket(id_to){
  // masuk
 $.ajax({
  type: "POST",
  url: "<?php echo base_url() ?>admincontrol/get_paket/"+id_to,
  success: function(data){
   $('#select_paket').html('<option value="all">-- Pilih Paket  --</option>');
   $.each(data, function(i, data){
    $('#select_paket').append("<option value='"+data.id_paket+"'>"+data.nm_paket+"</option>");
  });
 }
});
}

function filter_to(id_to) {
  url=base_url+"toback/ajax_report_tryout/"+id_to;
    $.ajax({
      url:url,
      success:function(Data)
      {

        dataTableReportPaket = $('.rpaket').DataTable({
        "ajax": {
          "url": url,
          "type": "POST",
        },
        "emptyTable": "Tidak Ada Data Pesan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
        "bDestroy": true,
      });
      },
      error:function(e,jqXHR, textStatus, errorThrown)
      {
         sweetAlert("Oops...", e, "error");
      }
    });

}

 // PAKET KETIKA DI CHANGE
  $('#select_paket').change(function(){    
    filter_paket();
  });

  function filter_paket() {
    tryout = $('#select_to').val();
    paket = $('#select_paket').val();
  url=base_url+"toback/ajax_report_tryout/"+tryout+"/"+paket;
    $.ajax({
      url:url,
      success:function(Data)
      {

        dataTableReportPaket = $('.rpaket').DataTable({
        "ajax": {
          "url": url,
          "type": "POST",
        },
        "emptyTable": "Tidak Ada Data Pesan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
        "bDestroy": true,
      });
      },
      error:function(e,jqXHR, textStatus, errorThrown)
      {
         sweetAlert("Oops...", e, "error");
      }
    });

}

</script>