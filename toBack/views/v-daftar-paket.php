<div class="row">
  <div class="col-md-12 kirim_token">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Paket <?=$nm_to;?></h3> 
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
        <th>Token</th>

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
        <td><?=$paket['token']?></td>
      </tr>
      <?php 
      $i++;
      endforeach ?>
    </tbody>
  </table>
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

</script>