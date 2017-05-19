<?php
    defined('BASEPATH') or exit('No direct script access allowed');
class Kirimnilai extends MX_Controller {

	public function __construct() {
        $this->load->library('form_validation');
		$this->load->library( 'parser' );
		$this->load->model('toback/mtoback');
		$this->load->model('cabang/mcabang');

		$this->load->model( 'paketsoal/mpaketsoal' );
		$this->load->model('siswa/msiswa');
		$this->load->model('templating/mtemplating');
		$this->load->model('mkirim');
		parent::__construct();

		if ($this->session->userdata('loggedin')==true) {
			if ($this->session->userdata('HAKAKSES')=='siswa'){
				redirect('welcome');
			}else if($this->session->userdata('HAKAKSES')=='guru'){
               // redirect('guru/dashboard');
			}else if($this->session->userdata('HAKAKSES')=='adminOffline'){
               // redirect('guru/dashboard');
			}else if($this->session->userdata('HAKAKSES')=='admin_cabang'){

			}else{
				redirect('login');
			}
		}
        ##
    }

    public function index()
    {
    	$data['judul_halaman'] = "Laporan Paket";
		$data['files'] = array(
				APPPATH . 'modules/kirimnilai/views/v-daftar-paket.php',
				);
		# get to
		// $data['to'] = $this->mkirim->get_report_paket();
		// get paket
		$data['paket'] = $this->mkirim->get_paket();
		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses=='adminOffline') {
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif ($hakAkses == 'guru') {
			redirect(site_url('guru/dashboard/'));
		} elseif ($hakAkses == 'siswa') {
			redirect(site_url('welcome'));
		} else {
			redirect(site_url('login'));
		}
	}

	//laporan to ajax
	public function laporanpaket($paket="all"){
		$datas = ['paket'=>$paket];

		$all_report = $this->mkirim->get_report_paket($datas);

		$data = array();

		foreach ( $all_report as $item ) {
			$sumBenar=$item ['jmlh_benar'];
			$sumSalah=$item ['jmlh_salah'];
			$sumKosong=$item ['jmlh_kosong'];
			//hitung jumlah soal
			$jumlahSoal=$sumBenar+$sumSalah+$sumKosong;
			
			$nilai=0;
			// cek jika pembagi 0
			if ($jumlahSoal != 0) {
				//hitung nilai
				$nilai=$sumBenar/$jumlahSoal*100;
			}
			$row = array();
			$row[] = $item ['id_paket'];
			$row[] = $item ['nm_paket'];
			$row[] = "<span class='checkbox custom-checkbox custom-checkbox-inverse'>
			<input type='checkbox' name="."report".$nilai." id="."soal".$item['id_paket']." value=".$item['id_paket'].">
			<label for="."soal".$item['id_paket'].">&nbsp;&nbsp;</label></span>";
			

			
			$data[] = $row;
		}

		$output = array(

			"data"=>$data,
			);

		echo json_encode( $output );
	}

	// function get kelas
	public function get_nilai( $id ) {
		$data = $this->output
		->set_content_type( "application/json" )
		->set_output( json_encode( $this->mkirim->ambil_nilai( $id ) ) );
	}

}
?>