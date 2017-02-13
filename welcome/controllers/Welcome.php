<?php



defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );



class Welcome extends MX_Controller {



    /**

     * Index Page for this controller.

     *

     * Maps to the following URL

     *   http://example.com/index.php/welcome

     *  - or -

     *   http://example.com/index.php/welcome/index

     *  - or -

     * Since this controller is set as the default controller in

     * config/routes.php, it's displayed at http://example.com/

     *

     * So any other public methods not prefixed with an underscore will

     * map to /index.php/welcome/<method_name>

     *

     * @see https://codeigniter.com/user_guide/general/urls.html

     */

    public function __construct() {

        parent::__construct();

        $this->load->model( 'matapelajaran/mmatapelajaran' );

        $this->load->model( 'tingkat/MTingkat' );



        $this->load->library( 'parser' );

                if ($this->session->userdata('loggedin')==true) {

            if ($this->session->userdata('HAKAKSES')=='siswa'){

               // redirect('welcome');

            }else if($this->session->userdata('HAKAKSES')=='guru'){

               redirect('guru/dashboard');

            }else{



            }

    }



    }



    public function index() {

        $data = array(

            'judul_halaman' => 'Neon - Welcome',

            'judul_header' =>'Welcome',

            'judul_header2' =>'Video Belajar'



        );



        $data['files'] = array( 

            APPPATH.'modules/homepage/views/v-header-login.php',

            APPPATH.'modules/welcome/views/v-welcome.php',

            APPPATH.'modules/welcome/views/v-tampil-tes.php',

            APPPATH.'modules/testimoni/views/v-footer.php',

        );

        $data['tingkat'] = $this->load->MTingkat->gettingkat();

        // print_r($data['tingkat']);
        $data['pelajaran_sma'] = $this->mmatapelajaran->daftarMapelSMA();
        $data['pelajaran_sma_ips'] = $this->mmatapelajaran->daftarMapelSMAIPS();
        $data['pelajaran_smp'] = $this->mmatapelajaran->daftarMapelSMP();
        $data['pelajaran_sd'] = $this->mmatapelajaran->daftarMapelSD();
        $data['pelajaran_sma_ipa'] = $this->mmatapelajaran->daftarMapelSMAIPA();

        $this->parser->parse( 'templating/index', $data );

    }


    public function faq()
    {

         $data = array(

            'judul_halaman' => 'Neon - FAQ',

            'judul_header' =>'FAQ HASIL DETECTION',

            'judul_header2' =>'Video Belajar'



        );

        $data['files'] = array( 

            APPPATH.'modules/homepage/views/v-header-login.php',

            APPPATH.'modules/welcome/views/v-faq.php',

            // APPPATH.'modules/welcome/views/v-tampil-tes.php',

            APPPATH.'modules/testimoni/views/v-footer.php',

        );
        $this->parser->parse( 'templating/index', $data );
    }



}

