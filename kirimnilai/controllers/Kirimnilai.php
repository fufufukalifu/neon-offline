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

}
?>