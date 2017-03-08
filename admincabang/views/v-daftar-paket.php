<div class="row">
  <div class="col-md-12 kirim_token">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Paket TO    </h3> 
        <div class="panel-toolbar text-right">

         <div class="col-sm-4">

      </div>

      <div class="col-sm-4">
       <select class="form-control" name="to">
        <option value="all">Semua Tryout</option>
        <?php foreach ($to as $item): ?>
        <option value="<?=$item['id_tryout']?>"><?=$item['nm_tryout'] ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="col-sm-4">
   <select class="form-control" name="paket">
    <option value="all">Semua paket</Paket>
      
  </select>
</div>



</div>
</div>

<div class="panel-body">
  <table class="daftarpaket table table-striped display responsive nowrap" style="font-size: 13px" width=100%>
    <thead>
      <tr>
        <th>id</th>
        <th>Username</th>
        <th>Nama Paket</th>
        <th>Nama SIswa</th>
        <th>Benar</th>
        <th>Salah</th>
        <th>Kosong</th>
        <th>Poin</th>
        <th>Total</th>
        <th>Waktu Mengerjakan</th>
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
<script type="text/javascript">
$(document).ready(function(){
  var mySelect = $('select[name=cabang]').val();
  dataTablePaket = $('.daftarpaket').DataTable({
    "ajax": {
      "url": base_url+"admincabang/admincabang/laporanto",
      "type": "POST"
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });


});


// CABANG KETIKA DI CHANGE
$('select[name=cabang]').change(function(){

  cabang = $('select[name=cabang]').val();
  tryout = $('select[name=to]').val();
  paket = $('select[name=paket]').val();

  url = base_url+"admincabang/admincabang/laporanto/"+cabang+"/"+tryout+"/"+paket;
  console.log(url);

  dataTablePaket = $('.daftarpaket').DataTable({
    "ajax": {
      "url": url,
      "type": "POST"
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });
});


// TO KETIKA DI CHANGE
$('select[name=to]').change(function(){
  cabang = $('select[name=cabang]').val();
  tryout = $('select[name=to]').val();
  paket = $('select[name=paket]').val();

  url = base_url+"admincabang/admincabang/laporanto/"+tryout+"/"+paket;

  dataTablePaket = $('.daftarpaket').DataTable({
    "ajax": {
      "url": url,
      "type": "POST"
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });

load_paket(tryout);

});

//ketika paket di change
function load_paket(id_to){
 $.ajax({
  type: "POST",
  url: "<?php echo base_url() ?>admincabang/get_paket/"+id_to,
  success: function(data){
   $('select[name=paket]').html('<option value="all">-- Pilih Paket  --</option>');

   $.each(data, function(i, data){
    $('select[name=paket]').append("<option value='"+data.id_paket+"'>"+data.nm_paket+"</option>");
  });
 }

});
}


// TO KETIKA DI CHANGE
$('select[name=paket]').change(function(){
  cabang = $('select[name=cabang]').val();
  tryout = $('select[name=to]').val();
  paket = $('select[name=paket]').val();

  url = base_url+"admincabang/admincabang/laporanto/"+tryout+"/"+paket;

  dataTablePaket = $('.daftarpaket').DataTable({
    "ajax": {
      "url": url,
      "type": "POST"
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });

});


// ketika klik hapus report
function drop_report(datas){
  url = base_url+"admincabang/drop_report";

  swal({
    title: "Yakin akan hapus report?",
    text: "Anda tidak dapat membatalkan ini.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya,Tetap hapus!",
    closeOnConfirm: false
  },
  function(){
    $.ajax({
      dataType:"text",
      data:{id_report:datas},
      type:"POST",
      url:url,
      success:function(){
        swal("Terhapus!", "Data report berhasil dihapus.", "success");
        dataTablePaket.ajax.reload(null,false);
      },
      error:function(){
        sweetAlert("Oops...", "Data gagal terhapus!", "error");
      }
    });
  });
}
</script>