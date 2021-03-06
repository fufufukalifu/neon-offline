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
	public function laporanto($tryout="all",$paket="all"){
		$datas = ['tryout'=>$tryout,'paket'=>$paket];

		$all_report = $this->admincabang_model->get_report_paket($datas);

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
				// cek jenis penilaian
	        	if ($item ['jenis_penilaian']=='SBMPTN') {
	        		$nilai= (($sumBenar * 4) + ($sumSalah * (-1)) + ($sumKosong * 0)) * 100 / ($jumlahSoal * 4);
	        	} else {
	        		$nilai=$sumBenar/$jumlahSoal*100;
	        	}
			}
			$row = array();
			$row[] = $item ['id_report'];
			$row[] = $item ['namaPengguna'];
			$row[] = $item ['nm_paket'];
			$row[] = $item['jenis_penilaian'];
			$row[] = $item ['namaDepan']." ".$item ['namaBelakang'];
			$row[] = $jumlahSoal;
			$row[] = $item ['jmlh_benar'];
			$row[] = $item ['jmlh_salah'];
			$row[] = $item ['jmlh_kosong'];
			$row[] = number_format($nilai,2);				
			$row[] = $item['tgl_pengerjaan'];
			if ($item['jmlh_benar']==0 && $item['jmlh_salah']==0) {
				$row[] = '<a class="btn btn-sm btn-danger"  title="Hapus" onclick="drop_report('."'".$item['id_report']."'".')"><i class="ico-remove"></i></a>';
			}else{
				$row[] = "-";	

			}

			
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
		# get to
$data['to'] = $this->mtoback->get_To();
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

    // function get paket
public function get_paket( $to_id ) {
	$data = $this->output
	->set_content_type( "application/json" )
	->set_output( json_encode( $this->admincabang_model->get_paket( $to_id ) ) );
}


function drop_report(){
	if ($this->input->post()) {
		$data = $this->input->post();
		$this->mtoback->delete_report($data);
	}
}
	public function laporanPDF($tryout="all",$paket="all")
	{
		$this->load->library('Pdf');
		$datas = ['tryout'=>$tryout,'paket'=>$paket];
		$all_report = $this->admincabang_model->get_report_paket($datas);	
		$data['all_report'] = array();
		$no=0;
		$sumNilai=0;
		$maxNilai=0;
		$minNilai=100;
		$avg = 0;
		foreach ( $all_report as $item ) {
			$no++;
			$sumBenar=$item ['jmlh_benar'];
			$sumSalah=$item ['jmlh_salah'];
			$sumKosong=$item ['jmlh_kosong'];
			//hitung jumlah soal
			$jumlahSoal=$sumBenar+$sumSalah+$sumKosong;
						// cek jika pembagi 0
			if ($jumlahSoal != 0) {
				//hitung nilai
				$nilai=$sumBenar/$jumlahSoal*100;
			}
			
			$paket=$item ['nm_paket'];
			$data['all_report'][]=array(
                'no'=>$no,
                'jumlah_soal'=>$jumlahSoal,
                'nama'=>$item ['namaDepan']." ".$item ['namaBelakang'],
                'jmlh_benar'=>$item ['jmlh_benar'],
                'jmlh_salah'=>$item ['jmlh_salah'],
                'jmlh_kosong'=>$item ['jmlh_kosong'],
                'jumlah_soal'=>$jumlahSoal,
                'nilai'=>number_format($nilai,2),
                'tgl_pengerjaan'=>$item ['tgl_pengerjaan']
                );
			//sum Nilai
			$sumNilai += $nilai;

			//set Max nilai
			if ($maxNilai<$nilai) {
				$maxNilai=$nilai;
			}else if($minNilai>$nilai){
				$minNilai=$nilai;
			}

		}
		if ($no!=0) {
			//hitung rata2 nilai
		$avg=$sumNilai/$no;
		}
		
		//format rata2 max 2 digit di belakang koma
		$formattedAvg = number_format($avg,2);
		$data['avg']=$formattedAvg;
		$data['jumlahSiswa']=$no;
		$data['maxNilai']=number_format($maxNilai,2);
		$data['minNilai']=number_format($minNilai,2);
		$data['paket'] = $paket;
		if ($tryout !="all" && $paket !="all") {
			// var_dump($data);
			$this->parser->parse('v-laporanPDF-to.php',$data);
		}else{
			 redirect(site_url('admincabang/laporanpaket'));
		}
		
	}

	public function info($value='')
	{
		echo phpinfo();
	}
}
?>