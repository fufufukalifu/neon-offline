<main>
    <section class="fullwidth-background bg-2">
        <div class="grid-row">
            <div class="login-block" style="min-width: 35%">
                <div class="logo">
                    <!--<h4>Login</h4>-->
                </div>
                <div class="">
                    <div class="page-header-section">
                        <h4 class="title font-alt text-center">{judul_login}</h4>
                    </div>
                </div>

                <div class="clear-both"></div>

                <?php if ($this->session->flashdata('notif') != '') { ?>
                <div class="alert alert-warning">
                    <span class="semibold">Note :</span><?php echo $this->session->flashdata('notif'); ?>
                </div>
                <?php } else { ?>
                <div class="alert alert-warning">
                    Siap berpetualang? Isi form, tekan Login!
                </div>
                <?php }; ?>
                <hr>
                <br>
                <form class="form-login" method = "post">
                    <div class="form-group">
                        <input type="text" name="username" class="login-input" placeholder="Username / email" required>
                        <span class="input-icon">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="form-group">
                        <input name="password" type="password" class="login-input" placeholder="Password" required>
                        <span class="input-icon">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="" style="float: left;">
                            <p class="small">
                                <a href="<?= base_url('index.php/register/lupapassword'); ?>">Lupa Password?</a>
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="small">
                                <a href="<?= base_url('index.php/login'); ?>" class="text-info">Anda Peserta? Login Disini</a>
                            </p>
                            <!---->
                        </div>

                        <div class="clear-both"></div>
                    </div>
                    <div class="form-group nm">
                        <a class="button-fullwidth cws-button bt-color-3 alt login-btn"><span class="semibold">Login</span></a>
                    </div>
                </form>
            </div>
        </div>
        <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
    </section>
</main>

<script>
$('.login').click(function(){
        login();
});

$('input[name=username]').keypress(function (e) {
    if (e.which == 13) {
        login();
    }
});

$('input[name=password]').keypress(function (e) {
    if (e.which == 13) {
        login();
    }
});

function login(){
    site_url = base_url+"login/login_admin";

    datas = {
     username:$('input[name=username]').val(),
     password:$('input[name=password]').val()
 };



 $.ajax({
    url : site_url,
    type: "POST",
    data:datas,
    dataType: "JSON",
    success: function(data)
    {
        if (data.status=='Gagal') {
            sweetAlert("Oops...", "Username atau password Salah", "error");
        }else{
            // console.log(data);
            // swal("Berhasil!", "Berhasil login", "success");
            get_admin(data);
        }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        sweetAlert("Oops...", "gagal konek ke server", "error");
    }
});

};

// ================================== # User Defined Function #===================================

//lempar fungsi ke controller untuk di direct.
function get_admin(data){
    site_url = base_url+"admin/create_session_offline"
 $.ajax({
    url : site_url,
    type: "POST",
    data:data,
    dataType: "json",
    success: function(data)
    {
        if (data.status_login==1) {
            window.location.replace(base_url+"toback/listto");
        };
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        sweetAlert("Oops...", "gagal konek ke server", "error");
    }
});
}
</script>