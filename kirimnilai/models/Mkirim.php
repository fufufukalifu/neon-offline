<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Mkirim extends CI_model {

	//get report all
	function get_report_paket($data){
		$this->db->select('*');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->group_by('pkt.id_paket');

		if ($data['paket']!="all") {
			$this->db->where('mmto.id_paket', $data['paket']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_paket()
	{
		$this->db->select('id_paket, nm_paket');
		$this->db->from('tb_paket');
		$query = $this->db->get();
		return $query->result_array();

	}

	public function ambil_nilai($id)
	{
		$this->db->select('pk.*, p.namaPengguna, pkt.nm_paket');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->where('pkt.id_paket',$id);
		$query = $this->db->get();
		return $query->result_array();

	}

}
?>