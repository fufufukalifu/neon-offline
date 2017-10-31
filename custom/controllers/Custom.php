<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Custom extends MX_Controller {

	function __construct(){
		$this->load->model('toback/Mtoback');
		$this->load->library('parser');
		$this->load->model('custom_model');
		$this->load->model('admincabang/admincabang_model');
		$this->load->model('Datatables_model_query');
	}

	function index(){
		echo phpinfo();
	}

	function set_nilai_peserta_lks(){
		$data['judul_halaman'] = "Input Nilai Peserta LKS";
		$data['files'] = array(
			APPPATH . 'modules/custom/views/v-laporan-peserta-lks.php',
		);

        # get to
		$data['to'] = $this->Mtoback->get_To();

		$hakAkses = $this->session->userdata['HAKAKSES'];

		if ($hakAkses=='adminOffline') {
        // jika admin
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif($hakAkses=='guru'){
            // jika guru
			$this->load->view('templating/index-b-guru', $data);  
		} elseif($hakAkses=='admin_cabang'){
            // jika guru
			$this->load->view('admincabang/v-index-admincabang', $data);  
		}else{
            // jika siswa redirect ke welcome
			redirect(site_url('welcome'));
		}
	}

	function ajax_report_test(){
		$datas = $this->custom_model->get_report_paket_siswa();
		$list = array();
		$no = 0;
	        //mengambil nilai list
		$baseurl = base_url();
		foreach ($datas as $list_item) {
			$no++;
			$row = array();
			$sumBenar=$list_item ['jmlh_benar'];
			$sumSalah=$list_item ['jmlh_salah'];
			$sumKosong=$list_item ['jmlh_kosong'];
	            //hitung jumlah soal
			$jumlahSoal=$sumBenar+$sumSalah+$sumKosong;

			$nilai=0;
	            // cek jika pembagi 0
			if ($jumlahSoal != 0) {
	            //hitung nilai
	            // cek jenis penilaian
				if ($list_item ['jenis_penilaian']=='SBMPTN') {
					$nilai= (($sumBenar * 4) + ($sumSalah * (-1)) + ($sumKosong * 0)) * 100 / ($jumlahSoal * 4);
				} else {
					$nilai=$sumBenar/$jumlahSoal*100;
				}
			}
			$row[] = $no;
			$row[] = $list_item['namaDepan'];
			$row[] = $list_item['nm_paket'];
			$row[] = $jumlahSoal;
			$row[] = $list_item['jmlh_benar'];
			$row[] = $list_item['jmlh_salah'];
			$row[] = $list_item['jmlh_kosong'];
			$row[] = round($nilai,1);

			$array = array("id_tryout"=>$list_item['id_tryout'],
				"id_mm_tryout_paket"=>$list_item['id_mm-tryout-paket'],
				"id_paket"=>$list_item['id_mm-tryout-paket']);

			$row[] ='<input class="form-control" type="number" type="number" onKeyPress="return check(event,value)" onInput="checkLength(3,this)" name="'.$list_item['id_report'].'"> ';

			$list[] = $row;   

		}

		$output = array(
			"data" => $list,
		);
		echo json_encode($output);

	}

	function proses_nilai_praktek(){
		if($this->input->post()){
			$post = $this->input->post();
			$nilai_akhir = array();
			foreach ($post as $key=> $value) {
				array_push($nilai_akhir, ['nilai_praktek'=>$value,'id_report_paket'=>$key]);	
			}
			$this->custom_model->insert_into_custom_lks($nilai_akhir);
			echo 1;
		}else{
			redirect('custom/set_nilai_peserta_lks');
		}
	}

	public function laporan_pdf_nilai_akhir($tryout="all",$paket="all"){
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
				// var_dump($data);
		$this->parser->parse('v-laporan-pdf-peserta.php',$data);
	}

	function laporan_nilai_akhir(){
		$data['judul_halaman'] = "Laporan Nilai Akhir Peserta LKS";
		$data['files'] = array(
			APPPATH . 'modules/custom/views/v-laporan-nilai-akhir.php',
		);
        # get to
		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses=='adminOffline') {
        // jika admin
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif($hakAkses=='guru'){
            // jika guru
			$this->load->view('templating/index-b-guru', $data);  
		} elseif($hakAkses=='admin_cabang'){
            // jika guru
			$this->load->view('admincabang/v-index-admincabang', $data);  
		}else{
            // jika siswa redirect ke welcome
			redirect(site_url('welcome'));
		}
	}

	function json(){
		$id_paket=$this->input->post("id_paket");
		$this->load->library('datatables');
		$this->datatables->select('id_report,namaDepan,namaBelakang,nm_tryout,nm_paket,jumlah_soal,jmlh_salah,jmlh_benar,nilai_praktek,nilai,nilai_akhir');
		$this->datatables->from('laporan_nilai_akhir');
		if ($id_paket!="all") {
			$this->datatables->where('id_paket',$id_paket);
		}
		return print_r($this->datatables->generate());
	}


public function listener(){
         $table = "laporan_nilai_akhir";
         $columns = array("id_report","namaDepan","namaBelakang","nm_tryout","nm_paket","jumlah_soal","jmlh_salah","jmlh_benar","nilai_praktek","nilai","nilai_akhir");
         $index = "id_report";
         echo $this->Datatables_model_query->generate($table, $columns, $index);
       }

public function report_LKS($id_paket)
{
	$this->load->library('Pdf');
	$all_report=$this->custom_model->get_report_LKS($id_paket);
	// var_dump($all_report);
	$no=0;
	$maxNilai=0;
	$minNilai=100;
	$sum_nilai_akhir=0;
	foreach ( $all_report as $item ) {
		$no++;
		$paket=$item ['nm_paket'];
		$nilai_akhir=$item['nilai_akhir'];
		$data['all_report'][]=array(
			'no'=>$no,
			'namaDepan'=>$item['namaDepan'],
			'namaBelakang'=>$item['namaBelakang'],
			'nm_paket'=>substr($paket,0,15),
			'jumlah_soal'=>$item['jumlah_soal'],
			'jmlh_salah'=>$item['jmlh_salah'],
			'jmlh_benar'=>$item['jmlh_benar'],
			'nilai_praktek'=>$item['nilai_praktek'],
			'nilai'=>$item['nilai'],
			'nilai_akhir'=>$nilai_akhir,
		);
			//sum Nilai
			// $sumNilai += $nilai;

			//set Max nilai
			if ($maxNilai<$nilai_akhir) {
				$maxNilai=$nilai_akhir;
				$data["nama_max"]=$item['namaDepan']." ".$item['namaBelakang'];
			}else if($minNilai>$nilai_akhir){
				$minNilai=$nilai_akhir;
			}
			$sum_nilai_akhir+=$nilai_akhir;

	}
	$data['maxNilai'] =$maxNilai;
	$data['minNilai'] =$minNilai;
	$data['jmlh_peserta']=$no;
	if ($no!=0) {
		$data['avg']=$sum_nilai_akhir/$no;
	}
	
	$data['paket'] = $paket;
	$this->parser->parse('v-laporan-LKS-pdf.php',$data);
	
}

public function get_paket($value='')
{
	$arr_paket=$this->custom_model->get_paket();
	// var_dump($arr_paket)
	$op_paket='<option value="all" selected >Semua</option>';
	foreach ($arr_paket as $key) {
		$op_paket.='<option value="'.$key->id_paket.'">'.$key->nm_paket.'</option>';
	}
	echo json_encode($op_paket);
}


	
}