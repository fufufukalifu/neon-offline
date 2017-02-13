<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admincabang_model extends CI_model {

	//get report all
	function get_report_paket($data){
		$this->db->select('id_report,p.namaPengguna,
			c.namaCabang,
			s.namaBelakang,
			s.namaDepan,
			jmlh_benar,
			jmlh_kosong,
			jmlh_salah,
			total_nilai,
			poin,
			nm_paket,
			pk.tgl_pengerjaan');

		$this->db->from('tb_report-paket pk');

		$this->db->join('tb_siswa s' , 'pk.siswaID=s.id');
		$this->db->join('tb_pengguna p' , 'p.id = pk.id_pengguna');
		$this->db->join('tb_mm-tryoutpaket mmto' , 'mmto.id = pk.id_mm-tryout-paket');
		$this->db->join('tb_paket pkt' , 'pkt.id_paket = mmto.id_paket');
		$this->db->join('tb_cabang c' , 'c.id = s.cabangID');

		if ($data['cabang']!="all") {
			$this->db->where('c.id', $data['cabang']);
		}

		if ($data['tryout']!="all") {
			$this->db->where('mmto.id_tryout', $data['tryout']);
		}
		if ($data['paket']!="all") {
			$this->db->where('mmto.id_paket', $data['paket']);
		}
		$query = $this->db->get();
		return $query->result_array();
	}

	//get paket berdasarkan id to
	function get_paket($id_to){
		$query = " SELECT nm_paket, p.id_paket FROM
		(
			SELECT id_paket FROM `tb_mm-tryoutpaket`
			WHERE id_tryout = $id_to
			) mmp JOIN `tb_paket` p ON p.`id_paket` = mmp.id_paket";

$result = $this->db->query($query);
return $result->result_array();
}

// jumlah siswa yang terdaftar to
function get_registered_siswa_to($id_to){
	$query = "SELECT  COUNT(id_siswa) AS jumlahSiswa FROM `tb_hakakses-to` 
	WHERE `id_tryout` = $id_to";

	$result = $this->db->query($query);
	return $result->result_array();
}

// jumlah siswa yang sudah ikut berpartisipasi
function get_participants_siswa_to($id_to){
	$query = "SELECT COUNT(DISTINCT(rpkt.`siswaID`)) as jumlahSiswa
	FROM `tb_mm-tryoutpaket` mmto
	JOIN `tb_hakakses-to` ha ON ha.`id_tryout` = mmto.id_tryout
	JOIN `tb_report-paket` rpkt ON `rpkt`.`id_mm-tryout-paket` - mmto.id
	WHERE ha.`id_tryout`=$id_to";

	$result = $this->db->query($query);

	return $result->result_array();
}

// jumlah paket
function get_paket_by_id_to($id_to){
		$query = "SELECT COUNT(id) as jumlahPaket FROM `tb_mm-tryoutpaket` WHERE id_tryout =$id_to";

	$result = $this->db->query($query);

	return $result->result_array();
}



}