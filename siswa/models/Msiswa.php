<?php

class Msiswa extends CI_Model {
    #Start function pengaturan profile siswa#

    public function update_siswa($data) {
        $penggunaID = $this->session->userdata['id'];
        $this->db->where('penggunaID', $penggunaID);
        $this->db->update('tb_siswa', $data);
        redirect(site_url('siswa/profilesetting'));
    }

    public function update_email($data) {
        $id = $this->session->userdata['id'];
        $this->db->where('id', $id);
        $this->db->update('tb_pengguna', $data);
        $sess_array = array(
            'eMail' => $data['eMail'],
            );
        $this->session->set_userdata($sess_array);
        redirect(site_url('siswa/profilesetting'));
    }

    public function update_katasandi($data) {
        $id = $this->session->userdata['id'];
        $this->db->where('id', $id);
        $this->db->update('tb_pengguna', $data);
        redirect(site_url('siswa/profilesetting'));
    }

    public function update_photo($photo) {
        $data = array(
            'photo' => $photo
            );
        $penggunaID = $this->session->userdata['id'];
        $this->db->where('penggunaID', $penggunaID);
        $this->db->update('tb_siswa', $data);
        redirect(site_url('siswa/profilesetting'));
    }

    public function get_siswa() {
        $penggunaID = $this->session->userdata['id'];
        //select from 2 table di join semuanya
        $this->db->select('namaDepan');
        $this->db->from('tb_guru guru');
        $this->db->join('tb_pengguna pengguna', 'pengguna.id=guru.penggunaID');

        //where 
        $this->db->where('penggunaID', $penggunaID);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_siswa_numbers() {
        //select from 2 table di join semuanya
        $this->db->select('id');
        $this->db->from('tb_siswa');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_datsiswa() {

        $penggunaID = $this->session->userdata['id'];
        $this->db->select('namaDepan,namaBelakang,alamat,noKontak,namaSekolah,alamatSekolah,biografi,photo');
        $this->db->from('tb_siswa');
        $this->db->where('penggunaID', $penggunaID);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_password() {
        $ID = $this->session->userdata['id'];
        $this->db->select('kataSandi');
        $this->db->from('tb_pengguna');
        $this->db->where('id', $ID);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_allsiswa() {
        $this->db->select('namaDepan,namaBelakang,aliasTingkat, siswa.id as id, tingkat.id as id_tingkat');
        $this->db->from('tb_siswa siswa');
        $this->db->join('tb_tingkat tingkat', 'tingkat.id = siswa.tingkatID');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    #query get siswa belum to

    public function get_siswa_blm_ikutan_to($id) {
        $query = "SELECT s.`id`, s.`namaDepan`,s.`namaBelakang`,c.`namaCabang` FROM tb_siswa s 
        LEFT JOIN `tb_cabang` c
        ON s.`cabangID` = c.id
        WHERE s.id NOT IN
        (
        SELECT ss.`id` FROM tb_siswa ss
        JOIN `tb_hakakses-to` ho ON
        ho.`id_siswa` = ss.`id`
        WHERE ho.`id_tryout` = $id) AND s.`status`=1
        ";
        $result = $this->db->query($query);
        return $result->result_array();
    }

    ##query get siswa belum to.
    #query get semua siswa

    function get_all_siswa() {
        $this->db->select('*,siswa.id as idsiswa');
        $this->db->from('tb_siswa siswa');
        $this->db->join('tb_pengguna pengguna', 'siswa.penggunaID = pengguna.id');
        $this->db->where('siswa.status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    function hapus_siswa($idsiswa, $idpengguna) {
        $this->db->set('status', 0);
        $this->db->where('id', $idsiswa);
        $this->db->update('tb_siswa');

        $this->db->set('status', 0);
        $this->db->where('id', $idpengguna);
        $this->db->update('tb_pengguna');
    }

    function get_siswa_byid($idsiswa, $idpengguna) {
        $this->db->select('*,siswa.id as idsiswa');
        $this->db->from('tb_siswa siswa');
        $this->db->join('tb_pengguna pengguna', 'siswa.penggunaID = pengguna.id');
        $this->db->where('pengguna.id', $idpengguna);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_reportlatihan_siswa($idpengguna) {
        $this->db->select('*');
        $this->db->from('tb_report-latihan reportla');
        $this->db->join('tb_latihan latihan', 'reportla.id_latihan = latihan.id_latihan');
        $this->db->where('reportla.id_pengguna', $idpengguna);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_reporttryout_siswa($idpengguna) {
        $this->db->select('tryout.id_tryout,tryout.nm_tryout,tryout.tgl_mulai,siswa.penggunaID as idpengguna');
        $this->db->from('tb_siswa as siswa');
        $this->db->join('tb_hakakses-to as hak', 'siswa.id = hak.id_siswa');
        $this->db->join('tb_tryout as tryout', 'hak.id_tryout = tryout.id_tryout');
        $this->db->where('siswa.penggunaID', $idpengguna);

        // $this->db->select('AVG(repa.poin) AS ratarata');
        // $this->db->from('tb_report-paket as repa');
        // $this->db->join('tb_mm-tryoutpaket as mmtry', 'repa.id_mm-tryout-paket = mmtry.id');
        // $this->db->join('tb_paket as pa', 'mmtry.id_paket = pa.id_paket');
        // $this->db->where('repa.id_pengguna', $idpengguna);
        // $this->db->where('mmtry.id_tryout', $idto);


        $query = $this->db->get();
        return $query->result_array();
    }

    function get_reportpaket_to($idpengguna,$idto) {
        $this->db->select('pa.nm_paket,repa.tgl_pengerjaan, repa.jmlh_kosong,repa.jmlh_benar,repa.jmlh_salah,repa.poin');
        $this->db->from('tb_report-paket as repa');
        $this->db->join('tb_mm-tryoutpaket as mmtry', 'repa.id_mm-tryout-paket = mmtry.id');
        $this->db->join('tb_paket as pa', 'mmtry.id_paket = pa.id_paket');
        $this->db->where('repa.id_pengguna', $idpengguna);
        $this->db->where('mmtry.id_tryout', $idto);
        $query = $this->db->get();
        return $query->result_array();
    }

    function ratarata_to($idpengguna,$idto) {
        $this->db->select('repa.poin, AVG(repa.poin) as rata');
        $this->db->from('tb_report-paket as repa');
        $this->db->join('tb_mm-tryoutpaket as mmtry', 'repa.id_mm-tryout-paket = mmtry.id');
        $this->db->join('tb_paket as pa', 'mmtry.id_paket = pa.id_paket');
        $this->db->where('repa.id_pengguna', $idpengguna);
        $this->db->where('mmtry.id_tryout', $idto);
        $query = $this->db->get();
        return $query->result_array();
    }


    function get_siswaid(){
        $penggunaID = $this->session->userdata['id'];

        $this->db->select('id');
        $this->db->from('tb_siswa');
        $this->db->where('penggunaID',$penggunaID);
        $query = $this->db->get();
        return $query->result_array()[0]['id'];
    }

    function get_token(){
        $siswaID = $this->get_siswaid();
        $this->db->select('*');
        $this->db->from('tb_token');
        $this->db->where('siswaID', $siswaID);
        $query = $this->db->get();
        if ($query->result_array()) {
            return $query->result_array()[0];
        }else{
            return false;
        }
    }

    ##
}

?>