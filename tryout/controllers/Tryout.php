<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tryout extends MX_Controller {

    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        
        $this->load->library('parser');
        $this->load->model('Mtryout');
        $this->load->model('siswa/msiswa');

        $this->load->model('tesonline/Mtesonline');
        parent::__construct();

        # check session
        if ($this->session->userdata('loggedin') == true) {
            if ($this->session->userdata('HAKAKSES') == 'siswa') {

            } else if ($this->session->userdata('HAKAKSES') == 'guru') {
                redirect('guru/dashboard');
            } else {
                redirect('login');
            }
        } else {
            redirect('login');
        }
        ##
    }

    public function ajax_get_paket($id_tryout) {
        $data = $this->Mtryout->get_paket_by_id_to($id_tryout);

        $output = array('data' => $data);
        echo json_encode($output);
    }

    //# fungsi indeks, masukan token.
    public function validasitoken() {
        $this->session->unset_userdata('id_tryout');
        $data = array(
            'judul_halaman' => 'Neon - Tryout',
            'judul_header' => 'Daftar Tryout',
            'judul_tingkat' => '',
            );

        $konten = 'modules/tryout/views/v-form-input-tokenpaket.php';

        $data['files'] = array(
            APPPATH . 'modules/homepage/views/v-header-login.php',
            APPPATH . $konten,
            );

        $this->parser->parse('templating/index', $data);
    }

    public function index() {
        $this->session->unset_userdata('id_tryout');
        $data = array(
            'judul_halaman' => 'Neon - Tryout',
            'judul_header' => 'Daftar Tryout',
            'judul_tingkat' => '',
            );

        $konten = 'modules/tryout/views/v-daftar-to.php';

        $data['files'] = array(
            APPPATH . 'modules/homepage/views/v-header-login.php',
            APPPATH . 'modules/templating/views/t-f-pagetitle.php',
            APPPATH . $konten,
            APPPATH . 'modules/testimoni/views/v-footer.php',
            );

        $datas['id_siswa'] = $this->Mtryout->get_id_siswa();
        $data['tryout'] = $this->Mtryout->get_tryout_akses($datas);
        $this->parser->parse('templating/index', $data);
    }
    public function create_seassoin_idto($id_to) {
        $this->session->set_userdata('id_tryout', $id_to);
        redirect("tryout/daftarpaket");
    }

    public function daftarpaket_backup() {
        $id_to = $this->session->userdata('id_tryout');
        $datas['id_tryout'] = $id_to;
        $datas['id_pengguna'] = $this->session->userdata('id');
        $datas['id_siswa'] = $this->msiswa->get_siswaid();

        $data['nama_to'] = $this->Mtryout->get_tryout_by_id($id_to)[0]['nm_tryout'];
        $data_to = $this->Mtryout->get_tryout_by_id($id_to)[0];
        
        $date = new DateTime(date("Y-m-d H:i:s"));
        
        // concat tanggal mlai dan tanggai akhir
        $mulai = date("Y-m-d H:i:s ", strtotime($data_to['tgl_mulai']." ".$data_to['wkt_mulai']));
        $akhir = date("Y-m-d H:i:s ", strtotime($data_to['tgl_berhenti']." ".$data_to['wkt_berakhir']));

        //buat date
        $date_mulai =  new DateTime($mulai);
        $date_berhenti =  new DateTime($akhir);


        // kalo tanggal mulainya lebih dari hari ini dan kurang dari sama dengan tanggal berhenti
        if (($date>= $date_mulai) && ($date <= $date_berhenti)) {
            //TO BISA DI AKSES
            $status_to = 'doing';
        }else{
            //TO TIDAK BISA DI AKSES
            if ($date>=$date_berhenti) {
                // SELESAI
                $status_to = 'done';             
            }else{
                // BELUM DIMULAI
                $status_to = 'yet';             
            }
        }

        if (isset($id_to)) {
            $data = array(
                'judul_halaman' => 'Neon - Daftar Paket',
                'judul_header' => 'Tryout : ' . $data['nama_to'],
                'judul_tingkat' => '',
                'nama_to' => $data_to['nm_tryout'],
                );

            // FILES
            $konten = 'modules/tryout/views/v-daftar-paket.php';
            $data['files'] = array(
                APPPATH . 'modules/homepage/views/v-header-login.php',
                APPPATH . 'modules/templating/views/t-f-pagetitle.php',
                APPPATH . $konten,
                // APPPATH . 'modules/homepage/views/v-footer.php',
                // APPPATH . 'modules/testimoni/views/v-footer.php',
                );
            // DAFTAR PAKET
            $data['paket_dikerjakan'] = $this->Mtryout->get_paket_reported($datas);
            $data['paket'] = $this->Mtryout->get_paket_undo($datas);
            $data['status_to'] = $status_to;


            $this->parser->parse('templating/index', $data);
            //unset session
            $this->session->unset_userdata('id_paketpembahasan');
            $this->session->unset_userdata('id_tryoutpembahasan');
            $this->session->unset_userdata('id_mm-tryoutpaketpembahasan');
        } else {
            //kalo gak ada session
            redirect('tryout');
        }
        // var_dump($data['paket_dikerjakan']);*/
    }


    public function daftarpaket() {

        $id_to = $this->session->userdata('id_tryout');
        $datas['id_pengguna'] = $this->session->userdata('id');
        $datas['id_siswa'] = $this->msiswa->get_siswaid();
        
        $data['nama_to'] = $this->Mtryout->get_tryout_by_id($id_to)[0]['nm_tryout'];

        $date = new DateTime(date("Y-m-d H:i:s"));

        //buat date
        // if (isset($id_to)) {
        $data = array(
            'judul_halaman' => 'Neon - Daftar Paket',
            'judul_header' => 'Daftar Nilai Paket Tryout '.$data['nama_to'],
            'judul_tingkat' => '',
            // 'nama_to' => 'Daftar Nilai Paket Tryout '.$data['nama_to'],
            );

            // FILES
        $konten = 'modules/tryout/views/v-daftar-paket.php';
        $data['paket_dikerjakan'] = $this->Mtryout->get_report_by_pengguna_id();

        $data['files'] = array(
            APPPATH . 'modules/homepage/views/v-header-login.php',
            APPPATH . 'modules/templating/views/t-f-pagetitle.php',
            APPPATH . $konten,
            );

        $this->parser->parse('templating/index', $data);
        // } else {
            // redirect('tryout');
        // }
    }

//# fungsi indeks
    function buatto() {
        $data = array("id_paket" => $this->input->post('id_paket'),
            "id_tryout" => $this->input->post('id_tryout'),
            "id_mm-tryoutpaket" => $this->input->post('id_mm_tryoutpaket'),
            );
        $this->session->set_userdata('id_paket', $data['id_paket']);
        $this->session->set_userdata('id_tryout', $data['id_tryout']);
        $this->session->set_userdata('id_mm-tryoutpaket', $data['id_mm-tryoutpaket']);
        $insert = array("siswaID" => $this->msiswa->get_siswaid(),
            "id_mm-tryout-paket" => $this->session->userdata('id_mm-tryoutpaket'),
            "status_pengerjaan" => '2'
            );
    }

    function buatpembahasan() {
        $data = array("id_paket" => $this->input->post('id_paket'),
            "id_tryout" => $this->input->post('id_tryout'),
            "id_mm-tryoutpaket" => $this->input->post('id_mm_tryoutpaket'),
            );
        $this->session->set_userdata('id_paketpembahasan', $data['id_paket']);
        $this->session->set_userdata('id_tryoutpembahasan', $data['id_tryout']);
        $this->session->set_userdata('id_mm-tryoutpaketpembahasan', $data['id_mm-tryoutpaket']);
    }

    //# fungsi indeks

    function test2() {
        var_dump($this->session->userdata());
    }

    public function mulaitest() { 
        if (!empty($this->session->userdata['id_mm-tryoutpaket'])) { 
            $id = $this->session->userdata['id_mm-tryoutpaket']; 
            $data['topaket'] = $this->Mtryout->datatopaket($id); 

            $id_paket = $this->Mtryout->datapaket($id)[0]->id_paket; 
            $random = $this->Mtryout->dataPaketRandom($id_paket)[0]->random; 

            $data['paket'] = $this->Mtryout->durasipaket($id_paket); 

            $this->load->view('templating/t-headerto'); 
            if ($random == 0) { 
                $query = $this->load->Mtryout->get_soalnorandom($id_paket); 
            }else{ 
                $query = $this->load->Mtryout->get_soal($id_paket); 
            } 
            $data['soal'] = $query['soal']; 
            $data['pil'] = $query['pil']; 

            $this->load->view('vHalamanTo-bu.php', $data); 
            $this->load->view('templating/t-footerto', $data); 
        } else { 
            $this->errorTest(); 
        } 
    }

    public function errorTest() {
        $this->load->view('templating/t-headerto');
        $this->load->view('v-error-test.php');
    }

    public function cekJawaban() {
        if ($this->input->post()) {
            $data = $this->input->post('pil');

            $id = $this->session->userdata['id_mm-tryoutpaket'];
            $id_paket = $this->Mtryout->datapaket($id)[0]->id_paket;

            $result = $this->Mtryout->jawabansoal($id_paket);

            $benar = 0;
            $salah = 0;
            $kosong = 0;
            $koreksi = array();
            $idSalah = array();
            $status = false;
            $rekap_hasil_koreksi = [];

            //untuk cek hawaban
            for ($i = 0; $i < sizeOf($result); $i++) {
                $id = $result[$i]['soalid'];
                if (!isset($data[$id])) {
                    // untuk jawaban kosong
                    $kosong++;
                    $koreksi[] = $result[$i]['soalid'];
                    $idSalah[] = $i;
                    $status = 3;
                } else if ($data[$id][0] == $result[$i]['jawaban']) {
                    // untuk jawaban benar
                    $benar++;
                    $status = 1;
                } else {
                    // untuk jawaban salah
                    $salah++;
                    $koreksi[] = $result[$i]['soalid'];
                    $idSalah[] = $i;
                    $status = 2;
                }

                $tempt['id_soal'] = $id;
                $tempt['status_koreksi'] = $status;
                $rekap_hasil_koreksi[] = $tempt;
            }

            $json_rekap_hasil_koreksi = json_encode($rekap_hasil_koreksi);       

            $hasil['id_pengguna'] = $this->session->userdata['id'];
            $hasil['siswaID'] = $this->msiswa->get_siswaid();
            $hasil['id_mm-tryout-paket'] = $this->session->userdata['id_mm-tryoutpaket'];
            ;
            $hasil['jmlh_kosong'] = $kosong;
            $hasil['jmlh_benar'] = $benar;
            $hasil['jmlh_salah'] = $salah;
            $hasil['total_nilai'] = $benar;
            $hasil['poin'] = $benar;
            $hasil['status_pengerjaan'] = 1;
            $hasil['rekap_hasil_koreksi'] = $json_rekap_hasil_koreksi;

            $result = $this->load->Mtryout->inputreport($hasil);
            $this->session->unset_userdata('id_mm-tryoutpaket');
            redirect(base_url('index.php/tryout/selesaitryout'));
        }else{
            redirect(base_url('index.php/tryout/selesaitryout'));
        }
    }

    //end fungsi ilham
    public function pembahasanto() {
        if (!empty($this->session->userdata['id_pembahasan'])) {
            $id = $this->session->userdata['id_pembahasan'];
            $this->load->view('templating/t-headersoal');

            $query = $this->load->mtesonline->get_soal($id);
            $data['soal'] = $query['soal'];
            $data['pil'] = $query['pil'];

            $this->load->view('vPembahasan.php', $data);
            $this->load->view('footerpembahasan.php');
        } else {
            $this->errorTest();
        }
    }

    public function mulaipembahasan() {
        if (!empty($this->session->userdata['id_mm-tryoutpaketpembahasan'])) {
            $id = $this->session->userdata['id_mm-tryoutpaketpembahasan'];
            $data = ['id_mm'=>$id, 'id_pengguna'=>$this->session->userdata('id')];
            $data['rekap_jawaban'] = json_decode($this->Mtryout->get_report_paket_by_mmid($data)->rekap_hasil_koreksi);
            $data['topaket'] = $this->Mtryout->datatopaket($id);
            $jumlah_soal = count($data['rekap_jawaban']);

            $id_paket = $this->Mtryout->datapaket($id)[0]->id_paket;

            $this->load->view('templating/t-headerto');
            $query = $this->load->Mtryout->get_pembahasan($id_paket);
            $data['soal'] = $query['soal'];
            $data['pil'] = $query['pil'];
            
            for ($i=0; $i <$jumlah_soal ; $i++) { 
                $rekap_id = $data['rekap_jawaban'][$i]->id_soal;
                $soal_id = $data['soal'][$i]['soalid'];

                if ($rekap_id == $soal_id) {
                    $data['soal'][$i]['status_koreksi'] = $data['rekap_jawaban'][$i]->status_koreksi;
                }
            }


            $this->load->view('v-pembahasanto.php', $data);
            $this->load->view('footerpembahasan', $data);
        } else {
            $this->errorTest();
        }
    }


    // cek validasi token tryout
    function ajax_cek_validasi_tokentryout(){
        if ($this->input->post()) {
            $data['post'] = $this->input->post();
            // $data['post'] = ['token'=>1];

            $data['paket'] = $this->Mtryout->get_paket_by_token($data['post']);
            if (empty($data['paket'])) {
                echo json_encode(['status'=>'false']);
            }else{
                $data['param'] = [
                'id_mm'=>$data['paket'][0]->mm_id,
                'id_pengguna'=>$this->session->userdata('id')
                ];
                // select ke report, paketnya pernah dikerjain belum ?
                $data['jumlah_report'] = $this->Mtryout->cek_report_paket_by_idpengguna($data['param']);

                // kalo belum pernah ngerjain, tampilkan paket data                    
                if ($data['jumlah_report']==0) {
                    echo json_encode($data['paket'][0]);
                }else{
                    echo json_encode(['status'=>'done']);
                }
            }
        }else{
            echo json_encode('gagal');
        }
    }

    // selesai tryout
    function selesaitryout(){
        $this->load->view('templating/t-headersoal');
        $this->load->view('v-selesai-tryout.php');
    }

}
?>