<div class="row">
  <!-- LAPORAN SEMUA PAKET TRYOUT -->
  <div class="col-md-12">
    <div class="panel panel-teal">
      <!--Start untuk menampilkan nama tabel -->
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Nilai Akhir Test CBT & Praktek</h3>
        <div class="panel-toolbar text-right">
          <button href="" class="btn btn-success" onclick="proses_nilai()">Laporan</a>

          </div>
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
// ## datatable report tryout
url = base_url+"custom/json";

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
</script>
