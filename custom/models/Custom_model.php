<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Custom_model extends CI_Model
{
	function __construct(){

	}

	function insert_into_custom_lks($data){
		$this->db->insert_batch('tb_custom_nilai_test', $data);
	}

	function get_report_paket_siswa(){
		$query = "SELECT * FROM `tb_report-paket` AS p
		JOIN `tb_mm-tryoutpaket` mm ON mm.`id` = p.`id_mm-tryout-paket`
		JOIN `tb_paket` pkt ON pkt.`id_paket` = mm.`id_paket`
		JOIN tb_tryout t ON t.`id_tryout` = mm.`id_tryout`
		JOIN `tb_siswa` sis ON sis.`id` = p.`siswaID`
		WHERE p.`id_report` NOT IN (SELECT `id_report_paket` FROM `tb_custom_nilai_test`)
		";
		$result = $this->db->query($query);
		return $result->result_array(); 
	}

	function get_report_paket_siswa_pdf(){
		$query = "SELECT id_report,sis.`namaDepan`, sis.`namaBelakang`, 
		t.`nm_tryout`, pkt.`nm_paket`,pkt.jumlah_soal,p.`jmlh_salah`,p.`jmlh_benar`,
		cm.nilai_praktek, ROUND((jmlh_benar * 100 / jumlah_soal)) AS nilai,
		(ROUND((jmlh_benar * 100 / jumlah_soal)) * 0.3 + `nilai_praktek` * 0.70 ) AS nilai_akhir
		
		FROM `tb_report-paket` AS p
		JOIN `tb_mm-tryoutpaket` mm ON mm.`id` = p.`id_mm-tryout-paket`
		JOIN `tb_paket` pkt ON pkt.`id_paket` = mm.`id_paket`
		JOIN tb_tryout t ON t.`id_tryout` = mm.`id_tryout`
		JOIN `tb_siswa` sis ON sis.`id` = p.`siswaID`
		JOIN `tb_custom_nilai_test`cm ON cm.`id_report_paket` = p.`id_report`
		";
		$result = $this->db->query($query);
		return $result->result_array(); 
	}

	public function get_report_LKS()
	{
		$this->db->select("*");
		$this->db->from("laporan_nilai_akhir");
		$this->db->order_by("nilai_akhir","desc");
		$query= $this->db->get();
		return $query->result_array();
	}
}
?>