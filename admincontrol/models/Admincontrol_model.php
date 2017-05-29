<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admincontrol_model extends CI_model {

	//get paket berdasarkan id to
	function get_paket($id_to){
		if ($id_to!="all") {
			
			$query = " SELECT nm_paket, p.id_paket FROM
			(
				SELECT id_paket FROM `tb_mm-tryoutpaket`
				WHERE id_tryout = $id_to
				) mmp JOIN `tb_paket` p ON p.`id_paket` = mmp.id_paket";

			$result = $this->db->query($query);
			return $result->result_array();
		} else {
			return $result=0;
		}
	}

}

?>