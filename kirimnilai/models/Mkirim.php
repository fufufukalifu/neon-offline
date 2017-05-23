<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Mkirim extends CI_model {

	//get report 
	function get_report_paket($id_to){
		$this->db->select('*');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->group_by('pkt.id_paket');
		$this->db->where('mmto.id_tryout', $id_to);

		$query = $this->db->get();
		return $query->result_array();
	}

	// get nilai 
	public function ambil_nilai($id)
	{
		$this->db->select('pk.*');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->where('pkt.id_paket',$id);
		// $this->db->select('pk.*');
		// $this->db->from('tb_report-paket pk');
		// $this->db->join('tb_mm-tryoutpaket mmto' , 'pk.id_mm-tryout-paket = mmto.id_paket');
		// $this->db->where('mmto.id_paket', $id);

		$query = $this->db->get();
		return $query->result_array();

	}

}
?>