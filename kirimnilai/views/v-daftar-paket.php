<!-- Start Modal salah upload gambar -->
<div class="modal fade" id="cekInput" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title text-center text-danger">Peringatan</h2>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Silahkan pilih  nama tryout dan nama paket ! </h3>
        <!-- <h5 class="text-center">Type yang bisa di upload hanya ".jpg", ".jpeg", ".bmp", ".gif", ".png"</h5> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="row">
  <div class="col-md-12 kirim_token">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Paket TO    </h3> 
        <div class="panel-toolbar text-right">
         <div class="col-sm-2">

      </div>

</div>
</div>

<div class="panel-body">
 <!--  <form  class="panel panel-default form-horizontal form-bordered form-step"  method="post" >
         <div  class="form-group">
           <label class="col-sm-2 control-label">Paket</label>
           <div class="col-sm-9">
            <select class="form-control" name="paket">
             <?php foreach ($paket as $item): ?>
                <option value="<?=$item['id_paket'] ?>"><?=$item['nm_paket'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </form> -->
  <table class="daftarpaket table table-striped display responsive nowrap" style="font-size: 13px" width=100%>
    <thead>
      <tr>
        <th>id</th>
        <th>Nama Paket</th>
        <th>
          <span class="checkbox custom-checkbox check-all">
            <input type="checkbox" name="checkall" id="check-all">
              <label for="check-all">&nbsp;&nbsp;</label>
          </span> 
        </th>

      </tr>
    </thead>

    <tbody>

    </tbody>
  </table>
  <a class="btn btn-primary upload_nilai">Upload Nilai</a>
</div>

</div>
</div>   
</div>
<script type="text/javascript">
$(document).ready(function(){
  var mySelect = $('select[name=paket]').val();
  dataTablePaket = $('.daftarpaket').DataTable({
    "ajax": {
      "url": base_url+"kirimnilai/laporanpaket",
      "type": "POST"
    },
    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });


});


// PAKET KETIKA DI CHANGE
$('select[name=paket]').change(function(){

  paket = $('select[name=paket]').val();

  url = base_url+"kirimnilai/laporanpaket/"+paket;
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

// KETIKA BUTTON UPLOAD DIKLIK
$('.upload_nilai').click(function(){
  kirim_nilai();
});

function kirim_nilai() {
  //tampung id paket
  id_paket = [];

  $('.daftarpaket tbody td :checkbox:checked').each(function(i){
     id_paket[i] = $(this).val();
     $.ajax({
      type: "POST",
      url: "<?php echo base_url() ?>kirimnilai/get_nilai/"+id_paket[i],
      success: function(data){

       $.each(data, function(i, data){
        console.log('nama_pengguna', data);
      });
     }

    });
   }); 

  
}

$('[name="checkall"]:checkbox').click(function () {
 if($(this).attr("checked")){
  $('table.daftarpaket tbody input:checkbox').prop( "checked", true );
} else{ 
  $('table.daftarpaket tbody input:checkbox').prop( "checked", false );
}
});


</script>