<link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/css/jquery.datatables.min.css'); ?>">
<section id="main" role="main">
    <div class="col-md-12">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">Daftar Siswa</h4>
                    <!-- Trigger the modal with a button -->
                    <a title="" class="btn btn-success pull-right" style="margin-top:-30px;" onclick="cek_jumlah_siswa()" >Cek Jumlah Siswa</a>
                    <br>
                </div>

                <table class="daftarsiswa table table-striped display responsive nowrap" style="font-size: 13px" width=100%>
                    <thead>
                        <tr>
                            <th>no</th>
                            <th>Id siswa</th>
                            <th>Nama Lengkap</th>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var tb_siswa;
    $(document).ready(function () {
        tb_siswa = $('.daftarsiswa').DataTable({
            "ajax": {
                "url": base_url + "siswa/ajax_daftar_siswa",
                "type": "POST"
            },
            "emptyTable": "Tidak Ada Data Siswa",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entries",
        });
    });

    function dropSiswa(idsiswa, idpengguna) {
        if (confirm('Apakah Anda yakin akan menghapus data ini? ')) {
            // ajax delete data to database

            $.ajax({
                url: base_url + "index.php/siswa/deleteSiswa/" + idsiswa + "/" + idpengguna,
                data: "idsiswa=" + idsiswa + "&idpengguna=" + idpengguna,
                type: "POST",
                dataType: "TEXT",
                success: function (data, respone)
                {
                    reload_tblist();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                    // console.log(jqXHR);
                    // console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    }

    function reload_tblist() {
        tb_siswa.ajax.reload(null, false);
    }

    function cek_jumlah_siswa(){
      var url_get_jmlh_siswa=base_url+"siswa/cek_sinkronisasi_siswa";

      $.ajax({
        url:url_get_jmlh_siswa,
        dataType:"json",
        type:"post",
        success:function(data){
            swal(data);
        },
        error:function(){

        }
      });

    }

</script>