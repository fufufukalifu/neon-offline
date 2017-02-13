<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admincabang extends MX_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->model('admincabang_model');
		$this->load->model('cabang/mcabang');
		$this->load->model('toback/mtoback');


	}

	public function index() {
		$data['judul_halaman'] = "Dashboard Admin Cabang";
		$data['files'] = array(
			APPPATH . 'modules/admin/views/v-container.php',
			);
		$data['to'] = $this->mtoback->get_To();
		
		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses == 'admin_cabang') {
			$this->parser->parse('v-index-admincabang', $data);
		} elseif ($hakAkses == 'guru') {
			redirect(site_url('guru/dashboard/'));
		} elseif ($hakAkses == 'siswa') {
			redirect(site_url('welcome'));
		} else {
			redirect(site_url('login'));
		}
	}

	// untuk infograph
	public function infograph() {
		$idto=85;
		// untuk graph 1 : partisipasi
		$jumlah_siswa_terdaftar = $this->admincabang_model->get_registered_siswa_to($idto)[0]['jumlahSiswa'];
		$jumlah_siswa_partisipasi = $this->admincabang_model->get_participants_siswa_to($idto)[0]['jumlahSiswa'];
		echo "Terdaftar $jumlah_siswa_terdaftar <br>";
		echo "Berpartiipasi $jumlah_siswa_partisipasi<br><hr>";

		// untuk graph 2 : to selesai
		//siswa yang berhasil menyelesaikan to
		//siswa yang berpartisipasi

		// untuk graph 3 : paket selesai
		$jumlah_paket = $this->admincabang_model->get_paket_by_id_to($idto)[0]['jumlahPaket']*$jumlah_siswa_terdaftar;		
		$jumlah_paket_dikerjakan = $this->admincabang_model->get_paket_by_id_to($idto)[0]['jumlahPaket'] * $jumlah_siswa_partisipasi;
		echo "Terdaftar paket $jumlah_paket <br>";
		echo "Dikerjakan paket $jumlah_paket_dikerjakan";

		/*
		
		$data['judul_halaman'] = "Dashboard Admin Cabang - infograph Tryout";
		$data['files'] = array(
			APPPATH . 'modules/admincabang/views/v-daftar-grafik.php',
			);
		$data['to'] = $this->mtoback->get_To();

		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses == 'admin_cabang') {
			$this->parser->parse('v-index-admincabang', $data);
		} elseif ($hakAkses == 'guru') {
			redirect(site_url('guru/dashboard/'));
		} elseif ($hakAkses == 'siswa') {
			redirect(site_url('welcome'));
		} else {
			redirect(site_url('login'));
		}*/
	}

	//laporan to ajax
	public function laporanto($cabang="all",$tryout="all",$paket="all"){
		$datas = ['cabang'=>$cabang,'tryout'=>$tryout,'paket'=>$paket];

		$all_report = $this->admincabang_model->get_report_paket($datas);

		$data = array();

		foreach ( $all_report as $item ) {
			$row = array();
			$row[] = $item ['id_report'];
			$row[] = $item ['namaPengguna'];
			$row[] = $item ['nm_paket'];
			$row[] = $item ['namaCabang'];
			$row[] = $item ['namaDepan']." ".$item ['namaBelakang'];
			$row[] = $item ['jmlh_benar'];
			$row[] = $item ['jmlh_salah'];
			$row[] = $item ['jmlh_kosong'];
			$row[] = $item ['poin'];
			$row[] = $item ['total_nilai'];			
			$row[] = $item['tgl_pengerjaan'];	
			
			$data[] = $row;
		}

		$output = array(

			"data"=>$data,
			);

		echo json_encode( $output );
	}

	// laporan paket
	public function laporanpaket(){
		$data['judul_halaman'] = "Laporan Paket TO";
		$data['files'] = array(
			APPPATH . 'modules/admincabang/views/v-daftar-paket.php',
			);
		# get cabang
		$data['cabang'] = $this->mcabang->get_all_cabang();
		# get to
		$data['to'] = $this->mtoback->get_To();
		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses == 'admin_cabang') {
			$this->parser->parse('v-index-admincabang', $data);
		} elseif ($hakAkses == 'guru') {
			redirect(site_url('guru/dashboard/'));
		} elseif ($hakAkses == 'siswa') {
			redirect(site_url('welcome'));
		} else {
			redirect(site_url('login'));
		}
	}

    // function get paket
	public function get_paket( $to_id ) {
		$data = $this->output
		->set_content_type( "application/json" )
		->set_output( json_encode( $this->admincabang_model->get_paket( $to_id ) ) );
	}

}
?>