<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admincontrol extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('parser');
		$this->load->model('admincontrol_model');
		$this->load->model('cabang/mcabang');
		$this->load->model('toback/mtoback');
	}

	// LAPORAN PENGERJAAN TO //
	function pengerjaan(){

		# get to
		$data['to'] = $this->mtoback->get_To();

		$data['judul_halaman'] = "Pengerjaan Tryout";
		$data['files'] = array(
			APPPATH . 'modules/logtryout/views/v-daftar-tryout-log.php',
			);

		$this->parser->parse('admin/v-index-admin', $data);

	}
	// LAPORAN PENGERJAAN TO //

	// function get paket
	public function get_paket( $to_id ) {
		$data = $this->output
		->set_content_type( "application/json" )
		->set_output( json_encode( $this->admincontrol_model->get_paket( $to_id ) ) );
	}

}

?>