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
		$this->db->select('pk.*, id_mm-tryout-paket as id_mm_tryout_paket');

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

	// get nama tryout
	public function get_nm_to($id)
	{
		$this->db->select('nm_tryout');
		$this->db->from('tb_tryout');
		$this->db->where('id_tryout' , $id);
		$query = $this->db->get();
		// cek jika hasil query null
        if($query->num_rows() == 1) {
            return $query->result_array()[0]['nm_tryout'];
        }else{
             return $query='';
        }
	}

	// update status kirim
	public function update_status_kirim($id)
	{
		$this->db->where('id_report', $id);
		$this->db->set('status_kirim', 1);
		$this->db->update('tb_report-paket');
	}

	//get report 
	function get_report_filter($data){
		$this->db->select('*');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->group_by('pkt.id_paket');
		$this->db->where('mmto.id_tryout', $data['id_to']);

		if ($data['status']!="all") {
			$this->db->where('pk.status_kirim', $data['status']);
		}

		$query = $this->db->get();
		return $query->result_array();
	}

	//drop  report
	public function delete_report($id_report)
	{
		$this->db->where('id_report',$id_report);
		$this->db->delete('tb_report-paket');
	}
}
?>