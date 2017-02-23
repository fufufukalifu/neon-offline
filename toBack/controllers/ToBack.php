<?php

class Toback extends MX_Controller{
	// private $web_link = "http://neonjogja.com/webservice/";
	private $web_link = "http://localhost:9090/neon/webservice/";


	public function __construct() {
		
		ini_set('max_execution_time', 0);
		header('Access-Control-Allow-Origin: *');
		$this->load->library('form_validation');
		$this->load->library( 'parser' );
		$this->load->model('Mtoback');
		$this->load->model('cabang/mcabang');

		$this->load->model( 'paketsoal/mpaketsoal' );
		$this->load->model('siswa/msiswa');
		$this->load->model('templating/mtemplating');
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

	#START Function buat TO#
	public function buatTo()
	{
		
		$nmpaket=htmlspecialchars($this->input->post('nmpaket'));
		$tglMulai=htmlspecialchars($this->input->post('tglmulai'));
		$tglAkhir=htmlspecialchars($this->input->post('tglakhir'));
		$publish=htmlspecialchars($this->input->post('publish'));
		$UUID = uniqid();
		$wktMulai=htmlspecialchars($this->input->post('wktmulai'));
		$wktAkhir=htmlspecialchars($this->input->post('wktakhir'));

		$dat_To=array(
			'nm_tryout'=>$nmpaket,
			'tgl_mulai'=>$tglMulai,	
			'tgl_berhenti'=>$tglAkhir,	
			'wkt_mulai'=>$wktMulai,	
			'wkt_berakhir'=>$wktAkhir,	
			'publish'=>$publish,
			'UUID' =>$UUID
			);

		$this->Mtoback->insert_to($dat_To);
		redirect(site_url('toback/addPaketTo/'.$UUID));
	}
	#END Function buat TO#

	#START Function add pakket to Try Out#
	// menampilkan halaman add to
	public function addPaketTo($UUID='')
	{	
		if ($UUID!=null) {
			$this->cek_PaketTo($UUID);
		} else {
			$data['files'] = array(
				APPPATH . 'modules/templating/views/v-data-notfound.php',
				);
			$data['judul_halaman'] = "Bundle Paket";
			 #START cek hakakses#
			$hakAkses=$this->session->userdata['HAKAKSES'];
			if ($hakAkses =='admin') {
	            // jika admin
				if ($babID == null) {
					redirect(site_url('admin'));
				} else {
					$this->parser->parse('admin/v-index-admin', $data);
				}

			} elseif($hakAkses=='guru'){
	             // jika guru
				if ($babID == null) {
					redirect(site_url('guru/dashboard/'));
				} else {
					$this->parser->parse('templating/index-b-guru', $data);
				}

			}else{
	            // jika siswa redirect ke welcome
				redirect(site_url('welcome'));
			}
	        #END Cek USer#
		}
		
	}

	public function cek_PaketTo($UUID)
	{
		$data['tryout'] = $this->mpaketsoal->get_id_by_UUID($UUID);
		if (!$data['tryout']==array()) {		
			$id_to = $data['tryout']['id_tryout'];
			$data['id_to']=$data['tryout']['id_tryout'];
			$data['nm_to']=$data['tryout']['nm_tryout'];
			$data['siswa'] = $this->msiswa->get_siswa_blm_ikutan_to($id_to);
			$data['files'] = array(
				APPPATH . 'modules/toback/views/v-bundlepaket.php',
				);
			$data['judul_halaman'] = "Bundle Paket";

		} else {
			$data['files'] = array(
				APPPATH . 'modules/templating/views/v-data-notfound.php',
				);
			$data['judul_halaman'] = "Bundle Paket";
		}

		 #START cek hakakses#
		$hakAkses=$this->session->userdata['HAKAKSES'];
		if ($hakAkses =='admin') {
            // jika admin 
			$this->parser->parse('admin/v-index-admin', $data);
		} elseif($hakAkses=='guru'){
             // jika guru     
			$this->parser->parse('templating/index-b-guru', $data);
		}else{
            // jika siswa redirect ke welcome
			redirect(site_url('welcome'));
		}
        #END Cek USer#
	}
	//add paket ke TO
	public function addPaketToTO()
	{
		$id_paket=$this->input->post('idpaket');
		$id_tryout=$this->input->post('id_to');
		// $id_paket=$this->input->post('test');
		// $this->Mtoback->inseert_addPaket();
		$dat_paket=array();//testing
		foreach ($id_paket as $key) {
			$dat_paket[] = array(
				'id_tryout'=>$id_tryout,
				'id_paket'=>$key);
			
		}
		$this->Mtoback->insert_addPaket($dat_paket);
		// var_dump(expression)
	}
	// add hak akses to siswa 
	public function addsiswaToTO()
	{
		$id_siswa=$this->input->post('idsiswa');
		$id_tryout=$this->input->post('id_to');
		// $id_paket=$this->input->post('test');
		// $this->Mtoback->inseert_addPaket();
		//menampung array id siswa
		$dat_siswa=array();
		foreach ($id_siswa as $key) {
			$dat_siswa[] = array(
				'id_tryout'=>$id_tryout,
				'id_siswa'=>$key);
			
		}
		//add siswa ke paket 
		$this->Mtoback->insert_addSiswa($dat_siswa);
		// var_dump(expression)
	}


	//menampikan paket yg sudah di add
	function ajax_listpaket_by_To($idTO) {
		$list = $this->load->Mtoback->paket_by_toID($idTO);
		$data = array();

		$baseurl = base_url();
		foreach ( $list as $list_paket ) {
			// $no++;
			$row = array();
			$row[] = $list_paket['paketID'];
			$row[] = $list_paket['nm_paket'];
			$row[] = $list_paket['deskripsi'];
			$row[] = '
			<a class="btn btn-sm btn-danger"  title="Hapus" onclick="dropPaket('."'".$list_paket['idKey']."'".')"><i class="ico-remove"></i></a>';

			$data[] = $row;
		}
		$output = array(
			"data"=>$data,
			);
		echo json_encode( $output );
	}




	function ajax_listsiswa_by_To($idTO) {
		

		$list = $this->load->Mtoback->siswa_by_totID($idTO);
		$data = array();

		$baseurl = base_url();
		foreach ( $list as $list_siswa ) {
			// $no++;
			$row = array();
			$row[] = $list_siswa ['siswaID'];
			$row[] = $list_siswa ['namaDepan'];
			$row[] = $list_siswa['aliasTingkat'];
			$row[] = '
			<a class="btn btn-sm btn-danger"  title="Hapus" onclick="dropSiswa('."'".$list_siswa['idKey']."'".')"><i class="ico-remove"></i></a>';

			$data[] = $row;

		}

		$output = array(
			
			"data"=>$data,
			);

		echo json_encode( $output );
	}

	#END Function add pakket to Try Out#

	#START Function di halaman daftar TO#
	//menampilkan halaman list TO
	public function listTO()
	{
		$data['files'] = array(
			APPPATH . 'modules/toback/views/v-list-to.php',
			);
		$data['judul_halaman'] = "List Try Out";
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
			<i class="ico-question-sign"></i></a>
			';

			

			$data[] = $row;

		}

		$output = array(

			"data"=>$data,
			);

		echo json_encode( $output );

	}
	public function dropTO($id_tryout)
	{
		$this->Mtoback->drop_TO($id_tryout);
	}

	public function ajax_edit( $id_tryout) {
		$data = $this->Mtoback->get_TO_by_id( $id_tryout );
		echo json_encode( $data );
	}
	
	#END Function di halaman daftar TO#

	// Drop paketb to TO
	public function dropPaketTo($idKey){
		$this->Mtoback->drop_paket_toTO($idKey);
	}

	// Drop siswa to to
	public function dropSiswaTo($idKey){
		$this->Mtoback->drop_siswa_toTO($idKey);
	}
	
	public function editTryout()
	{
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
		##menampilkan paket yang belum ada di TO.
	function ajax_list_all_paket($id_to){
		$list = $this->mpaketsoal->get_paket_unregistered($id_to);
		$data = array();
		$baseurl = base_url();
		$n = 1;
		foreach ( $list as $list_paket ) {
			$row = array();
			$row[] = "<input type='checkbox' value=".$list_paket['id_paket']." id=".$list_paket['nm_paket'].$list_paket['id_paket']." name=".$list_paket['nm_paket'].$n.">";
			$row[] = $list_paket['id_paket'];
			$row[] = $list_paket['nm_paket'];
			$row[] = $list_paket['deskripsi'];
			$row[] = "<a onclick="."lihatsoal(".$list_paket['id_paket'].")"." class='btn btn-primary'>Lihat</a>";
			$data[] = $row;
			$n++;
		}

		$output = array(
			"data"=>$data,
			);
		echo json_encode( $output );
	}
			###menampilkan paket yang belum ada di TO.

	##menampilkan siswa yang belum ikutan TO.
	function ajax_list_siswa_belum_to($id){
		$list = $this->msiswa->get_siswa_blm_ikutan_to($id);
		$data = array();
		$baseurl = base_url();
		foreach ( $list as $list_siswa ) {
			$row = array();
			$row[] = "<input type='checkbox' value=".$list_siswa['id']." >";
			$row[] = $list_siswa ['id'];
			$row[] = $list_siswa ['namaDepan']." ".$list_siswa['namaBelakang'];
			if($list_siswa['namaCabang']!=null){
				$row[] = $list_siswa['namaCabang'];
			}else{
				$row[] = "Non-neutron";
			}
			// $row[] = '
			// <a class="btn btn-sm btn-danger"  title="Hapus" onclick="dropSiswa('."'".$list_siswa['id']."'".')"><i class="ico-remove"></i></a>';
			$data[] = $row;
		}
		
		$output = array(
			"data"=>$data,
			);
		echo json_encode( $output );
	}

	###menampilkan siswa yang belum ikutan TO.
	// menampilkan list Pkaet by to for Report
	public function reportPaketSiswa()
	{
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

	function get_cabang_all_cabang(){
		$data = $this->output
		->set_content_type( "application/json" )
		->set_output( json_encode( $this->mcabang->get_all_cabang() ) );
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
	
	# insert paket dari webservice
	public function inserpaket($id){
		$url = $this->web_link.'paketoffline/'.$id;
		$json = file_get_contents($url);
		$data_paket = json_decode($json);
		$jumlah_paket = 0;		
		foreach ($data_paket as $item) {
			$validate_data = ['id'=>$item->id_paket,'tabel'=>'tb_paket','key'=>'id_paket'];
			$validate = $this->Mtoback->validate($validate_data);
			// kalo gak ada recordna di tabel	
			if (!$validate) {
				// 	#data untuk di insert ke paket
				$jumlah_paket++;
				$this->Mtoback->insert_paket($item);

			}

			$url2 = $this->web_link.'mm_tryout_paket/'.$id;
			$json = file_get_contents($url2);
			$data_mm = json_decode($json);
				// 	#data untuk di insert ke mm paket to
			foreach ($data_mm as $item) {
				$validate_mm = $this->Mtoback->validate_mm($item->id);
				if (!$validate_mm) {
					// echo "string";
					$this->Mtoback->insert_mm_paket($item);		
				}
			}


		}
		// keterangan jumlah paket
		$output = array("jumlah_paket"=>$jumlah_paket);
		echo json_encode($output);

	}
	

	## masukin mahasiswa dan pengguna  ke local db
	public function insert_mahasiswa($id){
		$url = $this->web_link.'siswaoffline/'.$id;
		$json = file_get_contents($url);
		$data_siswa = json_decode($json);
		// var_dump($data_siswa);
		
		$jumlah_siswa = 0;		

		$url2 = $this->web_link.'penggunaffline/'.$id;
		$json = file_get_contents($url2);
		$data_pengguna = json_decode($json);

		foreach ($data_pengguna as $item) {
			$validate_data = ['id'=>$item->id,'tabel'=>'tb_pengguna','key'=>'id'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				$jumlah_siswa++;
				// 	#data untuk di insert ke tb pengguna
				$this->Mtoback->insert_pengguna($item);
			}
		}

		foreach ($data_siswa as $item) {
			$validate_data = ['id'=>$item->id,'tabel'=>'tb_siswa','key'=>'id'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				// 	#data untuk di insert ke tb pengguna
				$this->Mtoback->insert_siswa($item);
			}
		}
		$this->insert_hak_akses($id);

		$output = array("jumlah_siswa"=>$jumlah_siswa);
		echo json_encode($output);
	}


	## masukin hak akses ke local db
	public function insert_hak_akses($id){
		$url = $this->web_link.'hakaksesoffline/'.$id;
		$json = file_get_contents($url);
		$data_hak_akses = json_decode($json);

		foreach ($data_hak_akses as $item) {
			$validate_data = ['id'=>$item->id,'tabel'=>'tb_hakakses-to','key'=>'id'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				// 	#data untuk di insert ke tb pengguna
				$this->Mtoback->insert_hak_akses($item);					
			}
		}

	}

	## masukin soal ke local db
	public function insert_soal($id){
		$url = $this->web_link.'soaloffline/'.$id;
		$json = file_get_contents($url);
		$data_soal = json_decode($json);
		$jumlah_soal=0;
		foreach ($data_soal as $item) {	
			$validate_data = ['id'=>$item->id_soal,'tabel'=>'tb_banksoal','key'=>'id_soal'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
			// 	#data untuk di insert ke tb pengguna
				$jumlah_soal++;
				$gambar = $item->gambar_soal;
				// COPY GAMBAR
				if ($gambar!="") {
					$copy_image = ['namaFile'=>$gambar,
					'url'=>'http://neonjogja.com/assets/image/soal/'.$gambar,
					'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/soal/'
					];
					$this->copy_gambar($copy_image);
				}

				// COPY GAMBAR PEMBAHASAN
				$gambar_pembahasan = $item->gambar_pembahasan;
				if ($gambar_pembahasan!="") {
					$copy_pembahasan = ['namaFile'=>$gambar_pembahasan,
					'url'=>'http://neonjogja.com/assets/image/pembahasan/'.$gambar_pembahasan,
					'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/pembahasan/'
					];
					$this->copy_gambar($copy_pembahasan);
				}
				$this->Mtoback->insert_soal($item);
			}	
		}
		$this->insert_mm($id);
		$this->insert_pil_jawaban($id);	
		$output = array("jumlah_soal"=>$jumlah_soal);
		echo json_encode($output);

	}

	## masukin mm paket soal akses ke local db
	public function insert_mm($id){
		$url = $this->web_link.'mm_soal_paket/'.$id;

		$json = file_get_contents($url);
		$data_mm = json_decode($json);

		foreach ($data_mm as $item) {
			$validate_data = ['id'=>$item->id,'tabel'=>'tb_mm-paketbank','key'=>'id'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				$this->Mtoback->insert_mm($item);			
			}
		}

	}

	## masukin pilihan jawaban
	public function insert_pil_jawaban($id){
		$url = $this->web_link.'pilihan_jawaban_offline/'.$id;

		$json = file_get_contents($url);
		$data_pilihan_jawaban = json_decode($json);
		foreach ($data_pilihan_jawaban as $item) {				
			if ($item->gambar!="") {
					// panggil untuk ngopi pilihan jawaban
				$copy_image_pilihan_jawaban = ['namaFile'=>$item->gambar,
				'url'=>'http://neonjogja.com/assets/image/jawaban/'.$item->gambar,
				'target'=>$_SERVER['DOCUMENT_ROOT'].'/neon-offline/assets/image/jawaban/'
				];
				$this->copy_gambar($copy_image_pilihan_jawaban);
			}
			$validate_data = ['id'=>$item->id_pilihan,'tabel'=>'tb_piljawaban','key'=>'id_pilihan'];
			$validate = $this->Mtoback->validate($validate_data);
			if (!$validate) {
				$this->Mtoback->insert_pilihan_jawaban($item);
			}
		}

	}

	## cacah untuk di datatable
	function data_table_all_to(){
		$url = $this->web_link.'get_all_to/'.$this->session->userdata('id');
		$json = file_get_contents($url);
		$data_to = json_decode($json);

		$data = array();

		$baseurl = base_url();
		foreach ( $data_to as $list_to ) {
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
	#================================================================# WEB END SERVICE #===============================================================================#



	

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

}
?>