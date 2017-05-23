<div class="row">
  <div class="col-md-12 kirim_token">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Paket TO </h3> 
        <div class="panel-toolbar text-right">
         <div class="col-sm-2">

      </div>

</div>
</div>

<div class="panel-body">

  <table class="daftarpaket table table-striped display responsive nowrap" style="font-size: 13px" width=100%>
    <thead>
      <tr>
        <th>No</th>
        <th>ID</th>
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
      <?php 
      $i =1;
      $nilai=0;
      foreach ($daftar_paket as $paket): ?>
      <tr>
        <td><?=$i;?></td>
        <td><?=$paket['id_paket']?></td>
        <td><?=$paket['nm_paket']?></td>
        <td>
          <span class='checkbox custom-checkbox custom-checkbox-inverse'>
            <input type='checkbox' name="report"<?=$nilai?>" id="soal<?=$paket['id_paket']?>" value="<?=$paket['id_paket']?>">
            <label for="soal<?=$paket['id_paket']?>">&nbsp;&nbsp;</label>
          </span>
        </td>
      </tr>
      <?php 
      $i++;
      endforeach ?>
    </tbody>
  </table>
  <a class="btn btn-primary upload_nilai">Upload Nilai</a>
</div>

</div>
</div>   
</div>
<script type="text/javascript">
$(document).ready(function() {

dataTablePaket = $('.daftarpaket').DataTable({

    "emptyTable": "Tidak Ada Data Pesan",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
    "bDestroy": true,
  });
} );

// KETIKA BUTTON UPLOAD DIKLIK
$('.upload_nilai').click(function(){
  kirim_nilai();
});


function kirim_nilai() {
  //tampung id paket
  id_paket = [];
  // datas = [];
  $('.daftarpaket tbody td :checkbox:checked').each(function(i){
     id_paket[i] = $(this).val();
     $.ajax({
      type: "POST",
      url: "<?php echo base_url() ?>kirimnilai/get_nilai/"+id_paket[i],
      success: function(data){
       $.each(data, function(i, data){
        datas = data; 
        // kirim ke webservice
        kirim(datas); 
      });
       
     }
    });
   }); 
  
}

// kirim ke webservice
function kirim(datas) {
  url = "http://localhost:81/netjoo-admin/webservice/accept_report_to";
  $.ajax({
            url : url,
            type: "POST",
            data:datas,
            dataType: "JSON",
            success: function(data)
            {
                if (data.status==false) {
                    sweetAlert("Oops...", "Terjadi Kesalahan", "error");
                }else{
                    swal("Berhasil!", "Berhasil Upload Nilai", "success");
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                sweetAlert("Oops...", "gagal konek ke server", "error");
            }
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