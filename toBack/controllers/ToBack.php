<?php
class Toback extends MX_Controller{
	// private $web_link = "http://localhost:9090/neon-admin/webservice/";
	// anggi
	private $web_link = rest_url;
	private $project_host = "http://soc.neonjogja.com";

	public function __construct() {
		
		ini_set('max_execution_time', 0);
		header('Access-Control-Allow-Origin: *');
		$this->load->library('form_validation');
		$this->load->library( 'parser' );
		$this->load->model('Mtoback');
		$this->load->model('banksoal/mbanksoal');

		$this->load->model('cabang/mcabang');

		$this->load->model( 'paketsoal/mpaketsoal' );
		$this->load->model('siswa/msiswa');
		$this->load->model('templating/mtemplating');
		$this->load->model( 'kirimnilai/mkirim' );
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
	}

	//menampilkan halaman list TO
	public function listTO(){
		$data['files'] = array(
			APPPATH . 'modules/toback/views/v-list-to.php',
			);
		$data['judul_halaman'] = "Daftar Try Out";
		$hakAkses=$this->session->userdata['HAKAKSES'];
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

	// menampilkan list to
	public function ajax_listsTO(){

		$list =$this->Mtoback->get_To();
		$data = array();

		$baseurl = base_url();
		foreach ( $list as $list_to ) {
			// $no++;
			if ($list_to['publish']=='1') {
				$publish='Publish';
			} else {
				$publish='Tidak Publish';
			}
			$penggunaID = $list_to['penggunaID'];
			$sesPenggunaID = $this->session->userdata['id'];

			$row = array();
			$row[] = $list_to ['id_tryout'];
			$row[] = $list_to ['nm_tryout'];
			$row[] = $list_to['tgl_mulai'];
			$row[] = $list_to['wkt_mulai'];
			$row[] = $list_to['tgl_berhenti'];
			$row[] = $list_to['wkt_berakhir'];
			$row[] = $publish;
			$row[] = '
			<a class="btn btn-sm btn-primary"  title="Sinkron Paket" onclick="insert_paket('."'".$list_to['id_tryout']."'".')">
			<i class="ico-file5"></i></a>
			
			<a class="btn btn-sm btn-primary"  title="Sinkron Siswa" onclick="download_siswa_pengguna('."'".$list_to['id_tryout']."'".')">
			<i class="ico-user"></i></a>
			
			<a class="btn btn-sm btn-primary"  title="Sinkron Soal" onclick="download_soal('."'".$list_to['id_tryout']."'".')">
			<i class="ico-question-sign"></i></a>';
		
			$row[] = '<a class="btn btn-sm btn-primary"  title="Ubah" onclick="edit_TO('."'".$list_to['id_tryout']."'".')">
			<i class="ico-pencil"></i></a>

			<a href="'.base_url().'kirimnilai/listpaket/'.$list_to['id_tryout'].'" class="btn btn-sm btn-primary"  title="Kirim Nilai">
			<i class="ico-folder-upload2"></i></a>

			<a href="'.base_url().'toback/list_paket/'.$list_to['id_tryout'].'" class="btn btn-sm btn-primary"  title="Lihat Paket">
			<i class="ico-file"></i></a>
			';

			$data[] = $row;

		}
		$output = array(
			"data"=>$data,
			);
		echo json_encode( $output );
	}

	#END Function di halaman daftar TO#

	#####OPIK#########################################

	public function reportto($uuid){
		$data['tryout'] = $this->Mtoback->get_to_byuuid($uuid);

		if (!$data['tryout']==array()) {
			$id_to  = $data['tryout'][0]['id_tryout'];
			$data['daftar_peserta'] =$this->Mtoback->get_report_peserta_to($id_to);
			$data['files'] = array(
				APPPATH . 'modules/toback/views/v-list-peserta.php',
				);
			$data['judul_halaman'] = "Laporan Untuk TO : ".$data['tryout'][0]['nm_tryout'];
		} else {
			$data['files'] = array(
				APPPATH . 'modules/templating/views/v-data-notfound.php',
				);
			$data['judul_halaman'] = "Daftar Peserta";
			$this->load->view('templating/v-data-notfound');
		}
		$hakAkses=$this->session->userdata['HAKAKSES'];
		
		if ($hakAkses=='admin') {
		// jika admin
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif($hakAkses=='guru'){
			 // jika guru
			$this->load->view('templating/index-b-guru', $data);  
		}else{
			// jika siswa redirect ke welcome
			redirect(site_url('welcome'));
		}
	}
	
	// menampilkan list Pkaet by to for Report
	public function reportPaketSiswa(){
		$data['id_to']=htmlspecialchars($this->input->get('id_to'));
		$penggunaID=htmlspecialchars($this->input->get('id_pengguna'));
		$data['idPengguna']=$penggunaID;
		$data['siswa']=$this->Mtoback->get_nama_siswa($penggunaID)[0];
		$data['reportPaket']=$this->Mtoback->get_report_paket($data);
		$data['files'] = array(
			APPPATH . 'modules/toback/views/v-report-paket-siswa.php',
			);
		$data['judul_halaman'] = "Report Siswa Perpaket";
		$this->load->view('templating/index-b-guru', $data);
	}

	//menampilkan report paket 
	public function reportpaket($idpaket)
	{
		$data['report']=$this->Mtoback->get_all_report_paket($idpaket);
		$data['files'] = array(
			APPPATH . 'modules/paketsoal/views/v-report-paket.php',
			);
		$data['judul_halaman'] = "Report Siswa Perpaket";
		$this->load->view('templating/index-b-guru', $data);
	}

	
	public function detailpaketsiswa(){
		$idto = $this->uri->segment(3);
		$idpengguna =  $this->uri->segment(4);
            // $idto = $this->uri->segmen(3);
		$data['reportpaket'] = $this->msiswa->get_reportpaket_to($idpengguna,$idto);
		$data['ratarata'] = $this->msiswa->ratarata_to($idpengguna,$idto);

		$data['judul_halaman'] = "Report Siswa";
		$data['files'] = array(
			APPPATH . 'modules/siswa/views/v-report-paket.php',
			);

		$hakAkses=$this->session->userdata['HAKAKSES'];
		
		if ($hakAkses=='admin') {
		// jika admin
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif($hakAkses=='guru'){
			 // jika guru
			$this->load->view('templating/index-b-guru', $data);  
		}else{
			// jika siswa redirect ke welcome
			redirect(site_url('welcome'));
		}
	}

	#================================================================# WEB SERVICE #===============================================================================#
	function ajax_insert_to(){
		$post = $this->input->post();
		$dat_To=array(
			'id_tryout'=>$post['id_tryout'],
			'nm_tryout'=>$post['nm_tryout'],
			'tgl_mulai'=>$post['tgl_mulai'],	
			'tgl_berhenti'=>$post['tgl_berhenti'],	
			'wkt_mulai'=>$post['wkt_mulai'],	
			'wkt_berakhir'=>$post['wkt_berakhir'],	
			'publish'=>$post['publish'],
			'UUID' =>$post['UUID'],
			);

		$validate = $this->Mtoback->validate_to($post['id_tryout']);

		if (!$validate) {
			$data = array("status"=>1);
			$this->Mtoback->insert_to($dat_To);			
		}else{
			$data = array("status"=>0);
		}
		echo json_encode($data);
	}
	
//  ------------------------------------ SINKRONISASI PAKET ------------------------------------
	function get_paket_from_service($data){
		$json_paket = file_get_contents($data['url_paket']);
		$data_paket['paket'] = json_decode($json_paket);

		$json_paket = file_get_contents($data['url_mm_to']);
		$data_paket['mm_to'] = json_decode($json_paket);

		return $data_paket;
	}

	function get_paket_local(){
		$data_paket_local['paket'] = $this->Mtoback->get_all_paket();
		$data_paket_local['mm_to'] = $this->Mtoback->get_mm_paket();

		return $data_paket_local;
	}

	// compare array kalo ada yang sama.
	function my_array_diff($arraya, $arrayb){
	    foreach ($arraya as $keya => $valuea){
	        if (in_array($valuea, $arrayb)){
	            unset($arraya[$keya]);
	        }
	    }
	    return $arraya;
	}

	// insert paket dan mm tryout
	public function inserpaket($id){
		$url['url_paket'] = $this->web_link.'get_paket_by_toid?id_tryout='.$id;
		$url['url_mm_to'] = $this->web_link.'get_mm_tryout_paket?id_tryout='.$id;

		//get paket
		$data_paket['service'] = $this->get_paket_from_service($url)['paket']->PilihanJawaban;
		$data_paket['lokal'] = $this->get_paket_local()['paket'];
		$data_paket['insert'] = $this->my_array_diff($data_paket['service'], $data_paket['lokal']);
		// get mm
		$data_paket['mm_to_service'] = $this->get_paket_from_service($url)['mm_to']->TryoutPengguna;
		$data_paket['mm_to_local'] = $this->get_paket_local()['mm_to'];
		$data_paket['mm_insert'] = $this->my_array_diff($data_paket['mm_to_service'], $data_paket['mm_to_local']);			
				var_dump($data_paket['service']);
		echo "<hr>";
		var_dump($data_paket['lokal']);
		echo "<hr>";
		var_dump($data_paket['insert']);
		echo "<hr>";

		//insert batch to database
		$jumlah_paket = count($data_paket['insert']);
		$jumlah_mm = count($data_paket['mm_insert']);

		if($jumlah_paket>0){
			$this->Mtoback->insert_batch($data_paket['insert'], 'tb_paket');			
		}

		if ($jumlah_mm>0) {
			$this->Mtoback->insert_batch($data_paket['mm_insert'], 'tb_mm-tryoutpaket');			
			# code...
		}

		// keterangan jumlah paket
		$output = array("jumlah_paket"=>$jumlah_paket);
		echo json_encode($output);
	}
//  ------------------------------------ SINKRONISASI PAKET ------------------------------------

	
//  ------------------------------------ SINKRONISASI SISWA ------------------------------------
	function get_users_webservice(){
		$id = $this->session->userdata('sekolahID');
		// select siswa berdasarkan sekolah
		$url = $this->web_link.'get_siswa_at_school/?sekolahID='.$id;
		$json = file_get_contents($url);
		$data_dari_server['siswa'] = json_decode($json);

		// select pengguna berdasarkan sekolah
		$url2 = $this->web_link.'get_pengguna_on_tryout/?sekolahID='.$id;
		$json = file_get_contents($url2);
		$data_dari_server['pengguna'] = json_decode($json);
		return $data_dari_server;
	}

	//select siswa dan pengguna di db
	function get_user_local(){
		$data_dari_db = $this->msiswa->get_siswa_and_user();
		return $data_dari_db;
	}

	//compare siswa terdaftar dan db
	function validate_users(){
		$data_dari_db = $this->get_user_local();
		$data_dari_server = $this->get_users_webservice();
		$jumlah_siswa = 0;

		if ($data_dari_server['siswa']->ReportPengguna=="Tidak Ada Data Report Berdasarkan Pengguna") {
			$data_dari_server['siswa']->ReportPengguna = array();
		}
		
		if ($data_dari_server['pengguna']->PenggunaOnTryout=="Tidak Ada Data Report Berdasarkan Pengguna") {
			$data_dari_server['pengguna']->PenggunaOnTryout = array();
		}

		// ambil siswa yang belum terdaftar
		$siswa_akan_daftar['siswa']=$this->my_array_diff($data_dari_server['siswa']->ReportPengguna,$data_dari_db['siswa']);
		$siswa_akan_daftar['pengguna']=$this->my_array_diff($data_dari_server['pengguna']->PenggunaOnTryout,$data_dari_db['pengguna']);
		$siswa_akan_daftar['jumlah_siswa'] = count($siswa_akan_daftar['siswa']);
		// var_dump($siswa_akan_daftar);
		return $siswa_akan_daftar;		

	}
	## masukin mahasiswa dan pengguna  ke local db
	public function insert_mahasiswa(){
		$siswa_akan_daftar = $this->validate_users();

		//insert ke db
		if ($siswa_akan_daftar['jumlah_siswa']>0) {
			$this->msiswa->insert_siswa_and_user($siswa_akan_daftar);			
		}

		$output = array("jumlah_siswa"=>$siswa_akan_daftar['jumlah_siswa']);
		echo json_encode($output);
	}
//  ------------------------------------SINKRONISASI SISWA ------------------------------------

// ------------------------------------ SINKRONISASI SOAL
	function get_soal_webservice($id){
		$url = $this->web_link.'get_soal_on_tryout/?id_tryout='.$id;
		$json = file_get_contents($url);
		$data_soal = json_decode($json);

		return $data_soal->Soal;
	}

	//select siswa dan pengguna di db
	function get_soal_local($id){
		$data_dari_db =  $this->mbanksoal->get_all_soal($id);
		return $data_dari_db;
	}

	function get_mm_soal_paket_webservice($id){
		$url = $this->web_link.'get_mm_paket/?id_tryout='.$id;

		$json = file_get_contents($url);
		$data_mm = json_decode($json);

		return $data_mm->MMPaket;
	}

	function get_mm_soal_paket_local($id){
		$data_dari_db =  $this->mbanksoal->get_mm_paket_to($id);
		return $data_dari_db;
	}

	## masukin soal ke local db
	public function insert_soal($id){
		//	 keperluan bank soal
		$soal['service'] = $this->get_soal_webservice($id);
		$soal['local'] = $this->mbanksoal->get_soal_all();
		$soal['insert'] = $this->my_array_diff($soal['service'],$soal['local']);
		$jumlah_soal=count($soal['insert']);


		// jika bank soalnya sudah diupload semua
		if ($jumlah_soal>0) {
			$this->Mtoback->insert_batch($soal['insert'], 'tb_banksoal');	
		}

		// MM Banksoal to PAket //
		$soal['mmsoal_paket_service'] = $this->get_mm_soal_paket_webservice($id); 
		$soal['mmsoal_paket_local'] = $this->get_mm_soal_paket_local($id); 
		$soal['insert_mm'] = $this->my_array_diff($soal['mmsoal_paket_service'],$soal['mmsoal_paket_local']);

		if (count($soal['insert'])>0) {
			$this->Mtoback->insert_batch($soal['mmsoal_paket_service'], 'tb_mm-paketbank');	
		}

		$this->copy_files($soal['insert']);
		$this->insert_pil_jawaban($id);

		$output = array("jumlah_soal"=>$jumlah_soal);
		echo json_encode($output);
	}


		function copy_files($soal){
			foreach ($soal as $item) {

				$gambar = $item->gambar_soal;
				// COPY GAMBAR
				if ($gambar!="") {
					$copy_image = ['namaFile'=>$gambar,
					'url'=>	$this->project_host.'/assets/image/soal/'.$gambar,
					'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/soal/'
					];
					$this->copy_gambar($copy_image);
				}


				//copy audio
				$audio = $item->audio;
				if ($audio!="") {
					$copy_audio = ['namaFile'=>$audio,
					'url'=> $this->project_host.'/assets/audio/soal/'.$audio,
					'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/audio/soal/'
					];
					$this->copy_audio($copy_audio);
				}

				// COPY GAMBAR PEMBAHASAN

				$gambar_pembahasan = $item->gambar_pembahasan;
				if ($gambar_pembahasan!="") {
					$copy_pembahasan = ['namaFile'=>$gambar_pembahasan,
					'url'=> $this->project_host.'/assets/image/pembahasan/'.$gambar_pembahasan,
					'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/pembahasan/'
					];
					$this->copy_gambar($copy_pembahasan);
				}

			}	
		}

	## masukin mm paket soal akses ke local db
	public function insert_mm($id){

		$json = file_get_contents($url);
		$data_mm = json_decode($json);

		foreach ($data_mm->MMPaket as $item) {
			$validate_data = ['id'=>$item->id,'tabel'=>'tb_mm-paketbank','key'=>'id'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				$this->Mtoback->insert_mm($item);			
			}
		}

	}

	## masukin pilihan jawaban

	function get_pil_jawaban_webservice($id_tryout){
		$url = $this->web_link.'get_pilihan_jawaban/?id_tryout='.$id_tryout;
		$json = file_get_contents($url);
		$data_pilihan_jawaban = json_decode($json);
		return $data_pilihan_jawaban->PilihanJawaban;
	}

	//select siswa dan pengguna di db
	function get_pil_jawaban_local($id_tryout){
		$data_pilihan_jawaban = $this->mbanksoal->get_pilihan_jawaban($id_tryout);
		return $data_pilihan_jawaban;
	}

	public function insert_pil_jawaban($id){
		$data_pilihan_jawaban['service'] = $this->get_pil_jawaban_webservice($id);
		$data_pilihan_jawaban['lokal'] = $this->get_pil_jawaban_local($id);
		$data_pilihan_jawaban['insert'] = $this->my_array_diff($data_pilihan_jawaban['service'],$data_pilihan_jawaban['lokal']);

		//copy image dari pilihan jawaban
		foreach ($data_pilihan_jawaban['insert'] as $item) {				
			if ($item->gambar!="") {
				// panggil untuk ngopi pilihan jawaban
				$copy_image_pilihan_jawaban = ['namaFile'=>$item->gambar,
				'url'=>'http://soc.neonjogja.com/assets/image/jawaban/'.$item->gambar,
				'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/jawaban/'
				];
				$this->copy_gambar($copy_image_pilihan_jawaban);
			}

	}
	if (count($data_pilihan_jawaban['insert'])>0) {
		$this->Mtoback->insert_batch($data_pilihan_jawaban['insert'],'tb_piljawaban');
	}

}
// ------------------------------------- SINKRONISASI SOAL


	## cacah untuk di datatable
	function data_table_all_to(){
		$url = $this->web_link.'get_all_to/?penggunaID='.$this->session->userdata('id');

		$json = file_get_contents($url);
		$data_to = json_decode($json);

		$data = array();

		$baseurl = base_url();
		foreach ( $data_to->TryoutPengguna as $list_to ) {
			// $no++;
			if ($list_to->publish=='1') {
				$publish='Publish';
			} else {
				$publish='Tidak Publish';
			}
			$penggunaID = $list_to->penggunaID;

			$row = array();
			$row[] = $list_to->id_tryout;
			$row[] = $list_to->nm_tryout;
			$row[] = $list_to->tgl_mulai;
			$row[] = $list_to->wkt_mulai;
			$row[] = $list_to->tgl_berhenti;
			$row[] = $list_to->wkt_berakhir;
			$row[] = $publish;
			$row[] = '
			<a class="btn btn-sm btn-primary"  title="Downnload Tryout" onclick="download_tryout('."'".$list_to->id_tryout."'".')">
			<i class="ico-file5"></i></a>
			';

			$data[] = $row;
		}
		$output = array(
			"data"=>$data,
			);
		echo json_encode( $output );
	}

	## COPY IMAGE DARI SERVER LAIN
	function copy_gambar($data){
		$url = $data['url'];
		$destination_folder = $data['target'];
    	$newfname = $destination_folder .$data['namaFile']; //set your file ext

    	// check filenya ada atau enggak
    	$ch = curl_init($url);    
    	curl_setopt($ch, CURLOPT_NOBODY, true);
    	curl_exec($ch);
    	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    	if($code == 200){
    		$status = true;
    	}else{
    		$status = false;
    	}
    	curl_close($ch);
    	// check filenya ada atau enggak

    	if ($status) {
    		$file = fopen ($url, "rb");

    		if ($file) {
	      $newf = fopen ($newfname, "a"); // to overwrite existing file

	      if ($newf)
	      	while(!feof($file)) {
	      		fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
	      	}
	      }

	      if ($file) {
	      	fclose($file);
	      }

	      if ($newf) {
	      	fclose($newf);
	      }
	  }
	}

	  	## COPY IMAGE DARI SERVER LAIN
	function copy_audio($data){
		$url = $data['url'];
		$destination_folder = $data['target'];
    	$newfname = $destination_folder .$data['namaFile']; //set your file ext

    	// check filenya ada atau enggak
    	$ch = curl_init($url);    
    	curl_setopt($ch, CURLOPT_NOBODY, true);
    	curl_exec($ch);
    	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    	if($code == 200){
    		$status = true;
    	}else{
    		$status = false;
    	}
    	curl_close($ch);
    	// check filenya ada atau enggak

    	if ($status) {
    		$file = fopen ($url, "rb");

    		if ($file) {
	      $newf = fopen ($newfname, "a"); // to overwrite existing file

	      if ($newf)
	      	while(!feof($file)) {
	      		fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
	      	}
	      }

	      if ($file) {
	      	fclose($file);
	      }

	      if ($newf) {
	      	fclose($newf);
	      }
	  }

	}

	#================================================================# WEB END SERVICE #===============================================================================#


	#======================FUNGSI BARU========================================#

	// fungsi untuk melihat semua daftar paket berdarkan id to
	public function list_paket($id){
		$data['files'] = array(
			APPPATH . 'modules/toback/views/v-daftar-paket.php',
			);
		$data['judul_halaman'] = "List Paket";

		// get daftar paket
		$data['daftar_paket'] = $this->Mtoback->get_paket_by_to($id);
		// get nama tryout
		$data['nm_to'] = $this->mkirim->get_nm_to($id);

		$hakAkses=$this->session->userdata['HAKAKSES'];
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

	// function view halaman report siswa
	public function report_tryout(){
        $data['judul_halaman'] = "Report Nilai Tryout";
        $data['files'] = array(
            APPPATH . 'modules/toback/views/v-laporan-siswa.php',
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

    // ajax untuk report siswa
    function ajax_report_tryout($id_to="all", $id_paket="all"){
    	$data = ['id_to'=>$id_to,'id_paket'=>$id_paket];
	    $datas = $this->Mtoback->get_report_paket_siswa($data);

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
	        $row[] = $list_item['jenis_penilaian'];
	        //kondisi jika orang tua yang login maka akan ditampikan nama tryout
	        $row[] = $list_item['nm_tryout'];
	        $row[] = $jumlahSoal;
	        $row[] = $list_item['jmlh_benar'];
	        $row[] = $list_item['jmlh_salah'];
	        $row[] = $list_item['jmlh_kosong'];
	        $row[] = $nilai;

	        $array = array("id_tryout"=>$list_item['id_tryout'],
	            "id_mm_tryout_paket"=>$list_item['id_mm-tryout-paket'],
	            "id_paket"=>$list_item['id_mm-tryout-paket']);



	        $row[] ='<a class="btn btn-sm btn-danger  modal-on'.$list_item['id_report'].'" 
	        data-todo='.htmlspecialchars(json_encode($array)).' 

	        title="Hapus Report" onclick="delete_report('."'".$list_item['id_report']."'".')"><i class="ico-remove"></i></a> ';
	        

	        $list[] = $row;   

	    }

	    $output = array(
	        "data" => $list,
	        );
	    echo json_encode($output);

	}

	// function untuk delete report
	function dropreporttry($id ) {
        $this->Mtoback->dropreport_t( $id );
    }

    public function ajax_edit( $id_tryout) {
		$data = $this->Mtoback->get_TO_by_id( $id_tryout );
		echo json_encode( $data );
	}

	public function editTryout(){
			$data['id_tryout']=htmlspecialchars($this->input->post('id_tryout'));
			$nm_tryout=htmlspecialchars($this->input->post('nama_tryout'));
			$tglMulai=htmlspecialchars($this->input->post('tgl_mulai'));
			$tglAkhir=htmlspecialchars($this->input->post('tgl_berhenti'));
			$publish=htmlspecialchars($this->input->post('publish'));

			$wktMulai=htmlspecialchars($this->input->post('wkt_mulai'));
			$wktAkhir=htmlspecialchars($this->input->post('wkt_akhir'));

			$data['tryout']=array(
				'nm_tryout'=>$nm_tryout,
				'tgl_mulai'=>$tglMulai,
				'tgl_berhenti'=>$tglAkhir,
				'wkt_mulai'=>$wktMulai,
				'wkt_berakhir'=>$wktAkhir,
				'publish'=>$publish,
				);

			$this->Mtoback->ch_To($data);
		}
	
}
?>