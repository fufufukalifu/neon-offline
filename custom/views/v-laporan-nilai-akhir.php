<div class="row">
  <!-- LAPORAN SEMUA PAKET TRYOUT -->
  <div class="col-md-12">
    <div class="panel panel-teal">
      <!--Start untuk menampilkan nama tabel -->
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Nilai Akhir Test CBT & Praktek</h3>
        <!-- toolbar -->
        <div class="panel-toolbar text-right">
          <div class="btn-group" role="group" data-toggle="buttons">
            <!-- <div class="col-md-6 mr0 pr0"> -->
               <select class="btn" style="border: 2px solid #ccc; border-left: none;" id="fil_paket">
              </select>
            <!-- </div> -->
            <!-- <div class="col-md-6 ml0 pl0"> -->
               <!-- <a href="<?=base_url()?>custom/report_LKS" class="btn btn-success"  target="_blank">Laporan</a> -->
                <a href="javascript:void(0)" class="btn btn-success"  onclick="open_report_LKS()">Laporan</a>
            <!-- </div> -->
          </div>
          </div>
          <!-- /toolbar -->
        </div>
        <div class="panel-body">
          <table class="table table-striped rpaket"  style="font-size: 13px" width="100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama Depan</th>
                <th>Nama Belakang</th>
                <th>Nama Tryout</th>
                <th>Nama Paket</th>
                <th>Jumlah Soal</th>
                <th>Jumlah Salah</th>
                <th>Jumlah Benar</th>
                <th>nilai Praktek</th>
                <th>Nilai CBT</th>
                <th>Nilai Akhir</th>
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
    var id_paket="all";
    var dataTableReportPaket;
  $(document).ready(function(){
    // ## datatable report tryout
    
    var url = base_url+"custom/json";
    dataTableReportPaket = $('.rpaket').DataTable({
      "ajax": {
        "url": url,
        "data":{id_paket:id_paket},
        "type": "POST",
      },
      "emptyTable": "Tidak Ada Data Pesan",
      "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
      "bDestroy": true,
    });
    // ## datatable report tryout
    set_paket();

    //event filter report by paket
    $("#fil_paket").change(function(){
      id_paket = $("#fil_paket").val();
      reload();
    });
  });


function reload(){
 dataTableReportPaket.ajax.reload();
 console.log(id_paket);
}

//se paket
function set_paket() {
 var url_post = base_url+"custom/get_paket";
 $.ajax({
  url:url_post,
  type:"post",
  dataType:"text",
  success:function(dat_return){
    console.log(dat_return);
    var ob_data = JSON.parse(dat_return);
    $("#fil_paket").append(ob_data);
  },
  error:function (argument) {
        // body...
      }
 });
}
 function open_report_LKS(){
  if (id_paket != "all") {
    var url_target = base_url+"custom/report_LKS/"+id_paket;
    window.open(url_target, '_blank');
  }else{
    swal("opps!","Silahkan pilih paket terlebih dagulu!","error");
  }
  
 }
</script>
