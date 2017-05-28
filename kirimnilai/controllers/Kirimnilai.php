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

	public function listpaket($id)
	{
		$data['judul_halaman'] = "Laporan Paket";
		$data['files'] = array(
				APPPATH . 'modules/kirimnilai/views/v-daftar-paket.php',
				);
		
		// get daftar paket
		$data['daftar_paket'] = $this->mkirim->get_report_paket($id);
		// get nama tryout
		$data['nm_to'] = $this->mkirim->get_nm_to($id);
		$data['id_to'] = $id;

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
	
	// function get kelas
	public function get_nilai( $id ) {
		$data = $this->output
		->set_content_type( "application/json" )
		->set_output( json_encode( $this->mkirim->ambil_nilai( $id ) ) );
	}

	// function update status kirim
	public function ubah_status()
	{	
		// update status kirim
		if ($this->input->post()) {
			$post = $this->input->post();
			$id = $post['id'];
			$this->mkirim->update_status_kirim( $id );
		} 	
	}

	//kirim nilai filter ajax
	public function kirimnilai_ajax($status="all", $id_to){

		$datas = ['status'=>$status, 'id_to'=>$id_to];

		$all_report = $this->mkirim->get_report_filter($datas);

		$data = array();
		$n=1;
		$nilai=0;
		foreach ( $all_report as $item ) {
			if ($item['status_kirim'] == '1') {
				$status="Sudah dikirim";
			} else {
				$status = "Belum dikirim";
			}
			$row = array();
			$row[] = $n;
			$row[] = $item ['id_paket'];
			$row[] = $item ['nm_paket'];
			$row[] = $status;
			$row[] = "<span class='checkbox custom-checkbox custom-checkbox-inverse'>
			<input type='checkbox' name="."report".$nilai." id="."soal".$item['id_paket']." value=".$item['id_paket'].">
			<label for="."soal".$item['id_paket'].">&nbsp;&nbsp;</label></span>";
			
			$data[] = $row;
			$n++;
		}

		$output = array(
			"data"=>$data,
			);

		echo json_encode( $output );
	}

}
?>