<div class="row">
  <div class="col-md-12 kirim_token">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Paket TO <?=$nm_to?> </h3> 
        <div class="panel-toolbar text-right">
         <div class="col-sm-2">

         </div>

       </div>
     </div>

     <div class="panel-body">
      <form  class="panel panel-default form-horizontal form-bordered form-step"  method="post" >
       <div  class="form-group">
         <label class="col-sm-1 control-label">Status</label>
         <div class="col-sm-10">
          <input type="text" name="id_to" value="<?=$id_to?>" hidden="true">
          <!-- stkt = soal tingkat -->
          <select class="form-control" name="status">
            <option value="all">-- Pilih Status --</option>
            <option value="1">Sudah dikirim</option>
            <option value="0">Belum dikirim</option>
          </select>
        </div>
      </div>
    </form>
    <table class="daftarpaket table table-striped display responsive nowrap" style="font-size: 13px" width=100%>
      <thead>
        <tr>
          <th>No</th>
          <th>ID</th>
          <th>Nama Paket</th>
          <th>Status</th>
          <th>
            <span class="checkbox custom-checkbox check-all">
              <input type="checkbox" name="checkall" id="check-all">
              <label for="check-all">&nbsp;&nbsp;</label>
            </span> 
          </th>
          <th>Aksi</th>

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
          <?php 
          $status = $paket[ 'status_kirim'];
          if ($status == 1) : ?>
          <td>Sudah dikirim</td>
        <?php else : ?>
          <td>Belum dikirm</td>
        <?php endif; ?>
        <td>
          <span class='checkbox custom-checkbox custom-checkbox-inverse'>
            <input type='checkbox' name="report"<?=$nilai?>" id="soal<?=$paket['id_paket']?>" value="<?=$paket['id_paket']?>">
            <label for="soal<?=$paket['id_paket']?>">&nbsp;&nbsp;</label>
          </span>
        </td>
        <td><a class="btn btn-sm btn-danger"  title="Hapus" onclick="dropReport('<?=$paket['id_report']?>')">
          <i class="ico-remove"></i></a></td>
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
  var dataTablePaket;
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


// untuk kirim nilai
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
  url_rest = "<?php echo rest_url ?>";
  url = url_rest+"addReport";
  $.ajax({
    url : url,
    type: "POST",
    data:JSON.stringify(datas),
    dataType: "JSON",
    contentType: 'application/json',
    success: function(data)
    {
      if (data.status==false) {
        sweetAlert("Oops...", "Terjadi Kesalahan", "error");
      }else{
        swal("Berhasil!", "Berhasil Upload Nilai", "success");
                    // jika berhasil update status_kirim menjadi 1
                    update_status(datas.id_report);
                    reload();
                  }
                },
                error: function (data, jqXHR, textStatus, errorThrown)
                {
                  console.log(textStatus);
                // sweetAlert("Oops...", "gagal konek ke server", "error");
              }
            });

}

// update status kirimnya
function update_status(id_report) {
  var datas = {id:id_report}
  $.ajax({
    url : "<?php echo base_url() ?>kirimnilai/ubah_status",
    type : "POST",
    dataType:"text",
    data : datas,
    success: function (data) {
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



// STATUS KETIKA DI CHANGE
$('select[name=status]').change(function(){

  status_kirim = $('select[name=status]').val();
  id_to = $('input[name=id_to]').val();

  url = base_url+"kirimnilai/kirimnilai_ajax/"+status_kirim+"/"+id_to;

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

  // drop report
  function dropReport(id_report) {
    // if (confirm('Apakah Anda yakin akan menghapus data ini? ')) {
      swal({
        title: "Yakin akan menghapus soal ini?",
        text: "Anda tidak dapat membatalkan ini.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya,Tetap hapus!",
        closeOnConfirm: false
      },
      function(){
        // ajax delete data to database
        $.ajax({
          url : base_url+"index.php/kirimnilai/dropReport/"+id_report,
          type: "POST",
          dataType: "TEXT",
          success: function(data,respone)
          {  
            swal('Report Berhasil Dihapus');
            reload();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error deleting data');
          }
        });
      });
      
    }

    function reload() {
      status_kirim = $('select[name=status]').val();
      id_to = $('input[name=id_to]').val();

      url = base_url+"kirimnilai/kirimnilai_ajax/"+status_kirim+"/"+id_to;

      dataTablePaket = $('.daftarpaket').DataTable({
        "ajax": {
          "url": url,
          "type": "POST"
        },
        "emptyTable": "Tidak Ada Data Pesan",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
        "bDestroy": true,
      });
    }



  </script>