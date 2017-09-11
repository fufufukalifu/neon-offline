<?php 
/**
 * 
 */
 class Help_admin extends MX_Controller
 {

 	function __construct()
 	{
 		parent::__construct();
		$this->load->library('parser');
		$this->load->model('M_hadmin');

		if ($this->session->userdata('loggedin')==true) {
			if ($this->session->userdata('HAKAKSES')=='siswa'){
				redirect('login');
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

 	public function index()
 	{
 		$data['judul_halaman'] = "User Guide - Admin";
		$data['files'] = array(
				APPPATH . 'modules/help_admin/views/v-user_guide_admin.php',
				);

		$hakAkses = $this->session->userdata['HAKAKSES'];
		if ($hakAkses=='adminOffline') {
			$this->parser->parse('admin/v-index-admin', $data);
		} else {
			redirect(site_url('login'));
		}
 	}

 	//get list  pdf user guide admin
 	public function get_list_user_guide_admin($value='')
 	{
 		// get data user_guide
 		$data=$this->M_hadmin->sc_user_guide_admin();
 		
 		foreach ($data as $key ) {
 			$status_user_guide=$key->status_user_guide;
 		} 		
 		
 		echo json_encode($dat);
 	}

 }
?>