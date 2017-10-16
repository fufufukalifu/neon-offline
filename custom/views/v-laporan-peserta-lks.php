<div class="row">
  <!-- LAPORAN SEMUA PAKET TRYOUT -->
  <div class="col-md-12">
    <div class="panel panel-teal">
      <!--Start untuk menampilkan nama tabel -->
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Nilai Tryout</h3>
        <div class="panel-toolbar text-right">
<!--           <div class="col-md-12">
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
           <button class="btn btn-sm btn-inverse " onclick="pdf()">PDF</button>         </div>
      </div>  
    -->                 
  </div>
</div>
<div class="panel-body">
  <table class="table table-striped rpaket"  style="font-size: 13px" width="100%">
    <thead>
      <tr>
        <th>no</th>
        <th>Nama Siswa</th>
        <th>Nama Paket</th>
        <th>Jumlah Soal</th>
        <th>Benar</th>
        <th>Salah</th>
        <th>Kosong</th>
        <th>Nilai</th>
        <th>Nilai Praktek</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
  <div class="container">
    <button href="" class="btn btn-primary" onclick="proses_nilai()">Proses</a>
    </div> 
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
url = base_url+"custom/ajax_report_test";

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
  url = base_url+"custom/ajax_report_test";
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



function proses_nilai(){
  var map = {};
  var status = 0;
  $('table input').each(function() {
    map[$(this).attr("name")] = $(this).val();
    if(map[$(this).attr("name")]==""){
      status = 0;
    }else{
      status = 1;
    }
  });
  if (status==1) {
    send_nilai_to_controller(map);             
  }else{
    swal('Oops','Nilai Ada yang Kosong, silahkan lengkapi nilai','error');
  }
}

function send_nilai_to_controller(map){
  $.ajax({
    type: "POST",
    url: base_url+"custom/proses_nilai_praktek",
    data: map,
    dataType: 'TEXT',
    success: function(data){
      swal('Yeah','Nilai berhasil di proses','success');
      reload();
    },error:function(data){
      swal('Oops','Gagal memproses','error');
    }
  });      
}
</script>

<script>
  function check(e,value){
    //Check Charater
    var unicode=e.charCode? e.charCode : e.keyCode;
    if (value.indexOf(".") != -1)if( unicode == 46 )return false;
    if (unicode!=8)if((unicode<48||unicode>57)&&unicode!=46)return false;
  }
  function checkLength(len,ele){
    var fieldLength = ele.value.length;
    if(fieldLength <= len){
      return true;
    }
    else
    {
      var str = ele.value;
      str = str.substring(0, str.length - 1);
      ele.value = str;
    }
  }
</script>