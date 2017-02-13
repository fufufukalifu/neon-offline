<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 */
class Mtryout extends MX_Controller {

    public function __construct() {

    }

    public function insert_report_sementara($data) {
        $this->db->insert('tb_report-paket', $data);
    }


    #get paket yang belum dikerjakan.
    public function get_paket_undo($datas) {
        $id = $datas['id_tryout'];
        $id_siswa = $datas['id_siswa'];
//        backup query
        $query = "SELECT *, mm.id as mmid FROM tb_paket p
        JOIN `tb_mm-tryoutpaket` mm ON mm.`id_paket` = p.`id_paket` 
        JOIN `tb_hakakses-to` ha ON ha.`id_tryout` = mm.`id_tryout`
        JOIN `tb_tryout` t ON t.`id_tryout` = ha.`id_tryout`
        WHERE ha.`id_siswa`=$id_siswa AND mm.`id_tryout`=$id
        AND p.`id_paket` NOT IN 
        (SELECT p.id_paket
            FROM `tb_hakakses-to` ha JOIN tb_siswa s 
            ON s.`id` = ha.`id_siswa` 
            JOIN tb_tryout t ON t.`id_tryout` = ha.`id_tryout` 
            JOIN `tb_mm-tryoutpaket` mmt ON mmt.`id_tryout` = t.`id_tryout` 
            JOIN `tb_paket` p ON p.`id_paket` = mmt.`id_paket` 
            LEFT JOIN `tb_report-paket` rp ON rp.`id_mm-tryout-paket` = mmt.`id` 
            WHERE id_siswa =$id_siswa 
            AND t.`id_tryout`= $id AND rp.siswaID = $id_siswa)

";

$result = $this->db->query($query);
return $result->result_array();
}
    //##

    #get data paket yang sudah dikerjakan
function get_paket_reported($datas){
    $id = $datas['id_tryout'];
    $id_pengguna = $datas['id_pengguna'];
    $id_siswa = $datas['id_siswa'];

    $query = "
    SELECT *,p.id_paket,`nm_paket`,mmt.`id`,rp.`id_report` FROM `tb_hakakses-to` ha
    JOIN tb_siswa s ON s.`id` = ha.`id_siswa`
    JOIN tb_tryout t ON t.`id_tryout` = ha.`id_tryout`
    JOIN `tb_mm-tryoutpaket` mmt ON mmt.`id_tryout` = t.`id_tryout`
    JOIN `tb_paket` p ON p.`id_paket` = mmt.`id_paket` 
    LEFT JOIN `tb_report-paket` rp ON rp.`id_mm-tryout-paket` = mmt.`id`

    WHERE id_siswa =$id_siswa AND 
    t.`id_tryout`= $id AND rp.siswaID = $id_siswa
    ";
    $result = $this->db->query($query);
    return $result->result_array();        
}
    ##

public function get_paket_by_id_to($id_to) {
    $this->db->select('*');
    $this->db->from('tb_tryout to');
    $this->db->join('tb_mm-tryoutpaket topaket', 'to.id_tryout = topaket.id_tryout');
    $this->db->join('tb_paket paket', 'topaket.id_paket = paket.id_paket');
    $query = $this->db->get();
    return $query->result_array();
}

public function get_paket_actioned_by_id_to($id_to) {
    $this->db->select('*');
    $this->db->from('tb_tryout to');
    $this->db->join('tb_mm-tryoutpaket topaket', 'to.id_tryout = topaket.id_tryout');
    $this->db->join('tb_paket paet', 'topaket.id_paket = paket.id_paket');
    $this->db->join('tb_report-paket repot_paket', 'repot_paket.id_mm-tryout-paket=topaket.id');
    $this->db->where('repot_paket.id_pengguna', $this->session->userdata('id'));
    $this->db->where('to.id_tryout', $id_to);
    $query = $this->db->get();
    return $query->result_array();
}

public function get_id_siswa() {
    $this->db->select('siswa.id');
    $this->db->from('tb_siswa siswa');
    $this->db->join('tb_pengguna pengguna', 'siswa.penggunaID = pengguna.id');

    $this->db->where('pengguna.id', $this->session->userdata('id'));

    $query = $this->db->get();
    return $query->result()[0]->id;
}

    //# fungsi get data tryout yang hakaksesnya true
public function get_tryout_akses($data) {
    $id_siswa = $data['id_siswa'];
    $this->db->select('*');
    $this->db->from('tb_tryout to');
    $this->db->join('tb_hakakses-to hakAkses', 'to.id_tryout = hakAkses.id_tryout');
        //hakakses
    $this->db->where('hakAkses.id_siswa', $data['id_siswa']);
        //published
    $this->db->where('to.publish', 1);
        //rentang waktu
        // $this->db->where("BETWEEN to.tgl_mulai AND to.stgl_berhenti");

    $query = $this->db->get();
    return $query->result_array();
}

    //# fungsi get data tryout yang hakaksesnya true

public function get_tryout_by_id($data) {
    $this->db->select('*');
    $this->db->from('tb_tryout to');
    $this->db->where('to.id_tryout', $data);
    $query = $this->db->get();
    return $query->result_array();
}

public function get_paket($id_to) {
    $this->db->select('id_paket');
    $this->db->from('tb_tryout to');
    $this->db->join('tb_mm-tryoutpaket topaket', 'to.id_tryout = topaket.id_tryout');
    $this->db->join('tb_paket paket', 'topaket.id_paket = paket.id_paket');
    $this->db->intersect();
    $this->db->select('id_paket');
    $this->db->from('tb_tryout to');
    $this->db->join('tb_mm-tryoutpaket topaket', 'to.id_tryout = topaket.id_tryout');
    $this->db->join('tb_paket paket', 'topaket.id_paket = paket.id_paket');
    $this->db->join('tb_report-paket repot_paket', 'repot_paket.id_mm-tryout-paket=topaket.id');
}

public function dataPaket($id) {
    $this->db->select('id_paket');
    $this->db->from('tb_mm-tryoutpaket');
    $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->result();
}

public function get_soal($id_paket) {
    $this->db->order_by('rand()');
    $this->db->select('id_paket as idpak, soal as soal, soal.id_soal as soalid, soal.judul_soal as judul, soal.gambar_soal as gambar');
    $this->db->from('tb_mm-paketbank as paban');
    $this->db->join('tb_banksoal as soal', 'paban.id_soal = soal.id_soal');
    $this->db->where('paban.id_paket', $id_paket);
    $query = $this->db->get();
    $soal = $query->result_array();

    $this->db->order_by('rand()');
    $this->db->select('*,id_paket as idpak, soal as soal, pil.id_soal as pilid,soal.id_soal as soalid, pil.pilihan as pilpil, pil.jawaban as piljaw, pil.gambar as pilgam');
    $this->db->from('tb_mm-paketbank as paban');
    $this->db->join('tb_banksoal as soal', 'paban.id_soal = soal.id_soal');
    $this->db->join('tb_piljawaban as pil', 'soal.id_soal = pil.id_soal');
    $this->db->where('paban.id_paket', $id_paket);
    $query = $this->db->get();
    $pil = $query->result_array();

    return array(
        'soal' => $soal,
        'pil' => $pil,
        );
}

public function get_pembahasan($id_paket) {
    $this->db->select('id_paket as idpak, soal as soal, soal.id_soal as soalid, soal.judul_soal as judul, soal.gambar_soal as gambar, soal.jawaban as jaw, soal.pembahasan, soal.gambar_pembahasan, soal.video_pembahasan, soal.status_pembahasan, soal.link');
    $this->db->from('tb_mm-paketbank as paban');
    $this->db->join('tb_banksoal as soal', 'paban.id_soal = soal.id_soal');
    $this->db->where('paban.id_paket', $id_paket);
    $query = $this->db->get();
    $soal = $query->result_array();

    $this->db->select('*,id_paket as idpak, soal as soal, pil.id_soal as pilid,soal.id_soal as soalid, pil.pilihan as pilpil, pil.jawaban as piljaw, pil.gambar as pilgam');
    $this->db->from('tb_mm-paketbank as paban');
    $this->db->join('tb_banksoal as soal', 'paban.id_soal = soal.id_soal');
    $this->db->join('tb_piljawaban as pil', 'soal.id_soal = pil.id_soal');
    $this->db->where('paban.id_paket', $id_paket);
    $query = $this->db->get();
    $pil = $query->result_array();

    return array(
        'soal' => $soal,
        'pil' => $pil,
        );
}


    //get pilihan berdasarkan subbab MP
public function get_pilihan($subbID) {
    $this->db->select('*,pil.id_soal as pilid, soal.id_soal as soalid, pil.jawaban as piljawaban');
    $this->db->from('tb_banksoal soal');
    $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
    $this->db->where('id_subbab', $subbID);
    $query = $this->db->get();
    return $query->result_array();
}

public function jawabansoal($id) {
    $this->db->select('soal.id_soal as soalid, soal.jawaban as jawaban');
    $this->db->from('tb_mm-paketbank as paban');
    $this->db->join('tb_banksoal as soal', 'soal.id_soal = paban.id_soal');
    $this->db->where('paban.id_paket', $id);
    $query = $this->db->get();
    return $query->result_array();
}

public function durasipaket($id_paket) {
    $this->db->select('durasi');
    $this->db->from('tb_paket');
    $this->db->where('id_paket', $id_paket);
    $query = $this->db->get();
    return $query->result_array();
}

public function inputreport($data) {
    $this->db->insert('tb_report-paket', $data);
}

public function datatopaket($id) {
    $this->db->select('try.nm_tryout as namato, p.nm_paket as namapa');
    $this->db->from('tb_mm-tryoutpaket as tp');
    $this->db->join('tb_tryout as try','tp.id_tryout = try.id_tryout');
    $this->db->join('tb_paket as p','tp.id_paket = p.id_paket');
    $this->db->where('tp.id', $id);
    $query = $this->db->get();
    return $query->result_array();
}
}

?>
