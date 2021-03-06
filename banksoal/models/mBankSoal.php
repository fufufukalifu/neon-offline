<?php

/**
 * 
 */
class Mbanksoal extends CI_Model {
    # Start Function untuk form soal#	

    public function insert_soal($dataSoal) {
        $this->db->insert('tb_banksoal', $dataSoal);
    }

    public function get_soalID($UUID) {
        $this->db->where('UUID', $UUID);
        // $this->db->where('publish', 1);
        // $this->db->where('status', 1);
        
        $this->db->select('id_soal')->from('tb_banksoal');
        $query = $this->db->get();
        return $query->result_array();
    }

    //insert pilihan jawaban berupa text
    public function insert_jawaban($dataJawaban) {
        $this->db->insert_batch('tb_piljawaban', $dataJawaban);
    }


    //insert pilihan jawaban berupa gambar
    public function insert_gambar($datagambar) {
        $this->db->insert_batch('tb_piljawaban', $datagambar);

    }

    # END Function untuk form soal#

    public function get_pelajaran($tingkatID) {
        $this->db->where('tingkatID', $tingkatID);
        $this->db->select('*')->from('tb_tingkat-pelajaran');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_bab($tingkatPelajaranID) {
        $this->db->where('tingkatPelajaranID', $tingkatPelajaranID);
        $this->db->select('*')->from('tb_bab');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_subbab($babID) {
        $this->db->where('babID', $babID);
        $this->db->select('*')->from('tb_subbab');
        $query = $this->db->get();
        return $query->result_array();
    }
    // get data soal persobbab
    public function get_soal($subbID) {
        $this->db->select('id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,tp.keterangan,soal.id_subbab');
        $this->db->from('tb_tingkat-pelajaran tp');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->where('id_subbab', $subbID);
        $this->db->where('soal.status','1');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get pilihan berdasarkan subbab MP
    public function get_pilihan($subbID) {
        $this->db->select('*,pil.id_soal as pilID, soal.id_soal as soalID, pil.jawaban as jawabanBenar');
        $this->db->from('tb_banksoal soal');
        $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
        $this->db->where('id_subbab', $subbID);
        $query = $this->db->get();
        return $query->result_array();
    }
    // get soal per baba
    public function get_soal_bab($babID) {
        $this->db->select('id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,tp.keterangan,soal.id_subbab,judulSubBab');
        $this->db->from('tb_tingkat-pelajaran tp');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->where('bab.id', $babID);
        $this->db->where('soal.status','1');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    //get pilihan berdasarkan bab
    public function get_pilihan_bab($babID) {
        $this->db->select('*,pil.id_soal as pilID, soal.id_soal as soalID, pil.jawaban as jawabanBenar');
        $this->db->from('tb_banksoal soal');
        $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
        $this->db->join('tb_subbab sub', 'sub.id = soal.id_subbab');
        $this->db->join('tb_bab bab','sub.babID = bab.id');
        $this->db->where('bab.id', $babID);
        $query = $this->db->get();
        return $query->result_array();
    }
    // get soal per matapelajaran
    public function get_soal_mp($idMp) {
        $this->db->select('id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,tp.keterangan,soal.id_subbab,judulBab');
        $this->db->from('tb_tingkat-pelajaran tp');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->where('tp.id', $idMp);
        $this->db->where('soal.status','1');
        $query = $this->db->get();
        return $query->result_array();

    }
      //get pilihan berdasarkan bab
    public function get_pilihan_mp($tingkatID) {
        $this->db->select('*,pil.id_soal as pilID, soal.id_soal as soalID, pil.jawaban as jawabanBenar');
        $this->db->from('tb_banksoal soal');
        $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
        $this->db->join('tb_subbab sub', 'sub.id = soal.id_subbab');
        $this->db->join('tb_bab bab','sub.babID = bab.id');
        $this->db->join('tb_tingkat-pelajaran tp','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_tingkat tkt','tp.tingkatID = tkt.id');
        $this->db->where('tkt.id', $tingkatID);
        $query = $this->db->get();
        return $query->result_array();
    }
      // get soal per tingkat
    public function get_soal_tkt($tingkatID) {
        $this->db->select('id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,tp.keterangan,soal.id_subbab');
        $this->db->from('tb_tingkat-pelajaran tp');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->join('tb_tingkat tkt','tp.tingkatID = tkt.id');
        $this->db->where('tkt.id', $tingkatID);
        $this->db->where('soal.status','1');
        $query = $this->db->get();
        return $query->result_array();

    }
      //get pilihan berdasarkan tingkat
    public function get_pilihan_tkt($idMp) {
        $this->db->select('*,pil.id_soal as pilID, soal.id_soal as soalID, pil.jawaban as jawabanBenar');
        $this->db->from('tb_banksoal soal');
        $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
        $this->db->join('tb_subbab sub', 'sub.id = soal.id_subbab');
        $this->db->join('tb_bab bab','sub.babID = bab.id');
        $this->db->join('tb_tingkat-pelajaran tp','bab.tingkatPelajaranID=tp.id');
        $this->db->where('tp.id', $idMp);
        $query = $this->db->get();
        return $query->result_array();
    }
    # Start Function untuk form update soal#

    public function ch_soal($data) {
        $this->db->set($data['dataSoal']);
        $this->db->where('UUID', $data['UUID']);
        $this->db->update('tb_banksoal');
    }

    public function get_onesoal($UUID) {
        $this->db->where('UUID', $UUID);
        $this->db->select('*')->from('tb_banksoal');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_piljawaban($id_soal) {
        $this->db->where('id_soal', $id_soal);
        $this->db->select('*')->from('tb_piljawaban');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get old gambar soal
    public function get_oldgambar_soal($UUID)
    {
        $this->db->where('UUID', $UUID);
        $this->db->select('id_soal,gambar_soal')->from('tb_banksoal');
        $query = $this->db->get();
        return $query->result_array();
    }

    //get old gambar pembahasn
    public function get_oldimg_pembahasan($UUID)
    {
        $this->db->where('UUID', $UUID);
        $this->db->select('gambar_pembahasan')->from('tb_banksoal');
        $query = $this->db->get();
        return $query->result_array()[0]['gambar_pembahasan'];
    }

    //get old gambar pembahasn
    public function get_oldvideo_pembahasan($UUID)
    {
        $this->db->where('UUID', $UUID);
        $this->db->select('video_pembahasan')->from('tb_banksoal');
        $query = $this->db->get();
        return $query->result_array()[0]['video_pembahasan'];
    }

    //get old gambar pilihan jawaban
    public function get_oldgambar($soalID) {
        $this->db->where('id_soal', $soalID);
        $this->db->select('id_pilihan,gambar')->from('tb_piljawaban');
        $query = $this->db->get();
        return $query->result_array();
    }

    //function untuk update pilihan jawaban text
    public function ch_jawaban($data) {
        $this->db->where('id_soal',$data['id_soal']);
        $this->db->update_batch('tb_piljawaban', $data['dataJawaban'], 'pilihan');
    }

    public function ch_gambar($datagambar) {
        $this->db->update_batch('tb_piljawaban', $datagambar, 'id_pilihan');
        // var_dump($datagambar);
    }

    # END Function untuk form update soal#
    # Start Function untuk form delete bank soal#

    //dalam pengahapusan data bank soal tidak benar2 di hapus tetapi status di rubah dari 1 -> 0

    public function del_banksoal($data) {
        $this->db->where('id_soal', $data);
        $this->db->set('status', '0');
        $this->db->update('tb_banksoal');
    }

    # END Function untuk form delete bank soal#

    //
    public function get_allsoal()
    {
        $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab');
        $this->db->from('tb_tingkat tkt');
        $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->where('soal.status','1');
        $this->db->order_by('soal.id_soal', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    // data paginataion all soal
    function data_soal($number,$offset){
        $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab,soal.create_by');
        $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
        $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
        $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
        $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
        $this->db->where('soal.status','1');
        $this->db->order_by('soal.id_soal', 'desc');
        return $query = $this->db->get('tb_tingkat tkt',$number,$offset)->result_array();       
    }

    function jumlah_data(){
        $this->db->where('status','1');
        return $this->db->get('tb_banksoal')->num_rows();
    }

    //jumlah data soal dengan subbab x
    function jumlah_soal_sub($subbab){
        $this->db->where('status','1');
        $this->db->where('id_subbab',$subbab);
        return $this->db->get('tb_banksoal')->num_rows();
    }

    // jumlah data soal dengan bab 
    public function jumlah_soal_bab($bab)
    {
      $this->db->where('soal.status','1');
      $this->db->where('bab.id',$bab);
      $this->db->join('tb_subbab sub','sub.id=soal.id_subbab');
      $this->db->join('tb_bab bab','bab.id=sub.babID');
      return $this->db->get('tb_banksoal soal')->num_rows();
  }

    // jumlah data soal dengan mpID =x 
  public function jumlah_soal_mp($mpID)
  {
      $this->db->where('soal.status','1');
      $this->db->where('tp.id',$mpID);
      $this->db->join('tb_subbab sub','sub.id=soal.id_subbab');
      $this->db->join('tb_bab bab','bab.id=sub.babID');
      $this->db->join('tb_tingkat-pelajaran tp','tp.id=bab.tingkatPelajaranID');
      return $this->db->get('tb_banksoal soal')->num_rows();
  }

        // jumlah data soal dengan bab 
  public function jumlah_soal_tingkat($tingkatID)
  {
    $this->db->where('soal.status','1');
    $this->db->where('tkt.id',$tingkatID);
    $this->db->join('tb_subbab sub','sub.id=soal.id_subbab');
    $this->db->join('tb_bab bab','bab.id=sub.babID');
    $this->db->join('tb_tingkat-pelajaran tp','tp.id=bab.tingkatPelajaranID');
    $this->db->join('tb_tingkat tkt','tkt.id=tp.tingkatID');
    return $this->db->get('tb_banksoal soal')->num_rows();
}

function data_soal_sub($number,$offset,$subbab){
    $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab,soal.create_by');
        // $this->db->from('tb_tingkat tkt');
    $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
    $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
    $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
    $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
    $this->db->where('id_subbab',$subbab);
    $this->db->where('soal.status','1');
    $this->db->order_by('soal.id_soal', 'desc');
    return $query = $this->db->get('tb_tingkat tkt',$number,$offset)->result_array();       
}

function data_soal_mp($number,$offset,$mpID){
    $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab,soal.create_by');
    $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
    $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
    $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
    $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
    $this->db->where('tp.id',$mpID);
    $this->db->where('soal.status','1');
    $this->db->order_by('soal.id_soal', 'desc');
    return $query = $this->db->get('tb_tingkat tkt',$number,$offset)->result_array();       
}


function data_soal_tingkat($number,$offset,$tingkatID){
    $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab,soal.create_by');
    $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
    $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
    $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
    $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
    $this->db->where('tkt.id',$tingkatID);
    $this->db->where('soal.status','1');
    $this->db->order_by('soal.id_soal', 'desc');
    return $query = $this->db->get('tb_tingkat tkt',$number,$offset)->result_array();       
}

function data_soal_bab($number,$offset,$bab='')
{
 $this->db->select('tkt.aliasTingkat,id_soal,sumber,kesulitan,judul_soal,jawaban,UUID,publish,random,soal,gambar_soal,pembahasan,gambar_pembahasan,video_pembahasan,tp.keterangan,bab.judulBab,subbab.judulSubBab,soal.id_subbab,soal.create_by');
 $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
 $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
 $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
 $this->db->join('tb_banksoal soal', 'subbab.id = soal.id_subbab');
 $this->db->where('bab.id ',$bab);
 $this->db->where('soal.status','1');
 $this->db->order_by('soal.id_soal', 'desc');
 return $query = $this->db->get('tb_tingkat tkt',$number,$offset)->result_array();  
}

    // 

public function get_allpilihan()
{
    $this->db->select('*,pil.id_soal as pilID, soal.id_soal as soalID, pil.jawaban as jawabanBenar');
    $this->db->from('tb_banksoal soal');
    $this->db->join('tb_piljawaban pil', ' pil.id_soal= soal.id_soal');
    $query = $this->db->get();
    return $query->result_array();
}

    #ambil soal yang belum terdaftar dalam paket soal.
public function get_soal_terdaftar($data){
 $paket = $data['id_paket'];
 $subBabId = $data['subBabId'];   

 $myquery ="SELECT * FROM `tb_banksoal` bank
 WHERE bank.publish = 1
 AND bank.id_subbab = $subBabId
 AND bank.jawaban <>''
 AND bank.status = 1
 AND bank.id_soal NOT IN
 (
 SELECT pb.`id_soal`
 FROM `tb_banksoal` b
 JOIN `tb_mm-paketbank` pb 
 ON pb.`id_soal`= b.`id_soal`
 JOIN `tb_paket` p ON
 p.`id_paket` = pb.`id_paket`
 AND p.`id_paket` = $paket
 )"
 ;

 $result = $this->db->query($myquery);

 return $result->result_array();
}

    // hitung jumlah pilihan berdasarkan id
public function get_count_pilihan($id_soal)
{
    $this->db->where('id_soal',$id_soal);
    $this->db->from('tb_piljawaban');
    $count= $this->db->count_all_results();
        // var_dump($num_rows) ;
    return $count;
}

    // delete one piljawaban by id_soal
public function del_oneJawaban($id_soal)
{   
    $this->db->where('id_soal', $id_soal);
    $this->db->where('pilihan','E');
    $this->db->delete('tb_piljawaban');
        // var_dump($data['dataJawaban']);
}
    // add one piljawaban by id_soal
public function add_oneJawaban($pil_E)
{
 $this->db->insert('tb_piljawaban',$pil_E);
        // var_dump($data['dataJawaban']);
}

    // get info data soal berdasarkan bab
public function get_judulBab($bab)
{
    $this->db->select('judulBab,tingkatPelajaranID');
    $this->db->from('tb_bab');
    $this->db->where('id',$bab);
    $query = $this->db->get();
    return $query->result()[0];
}
    //get nama mp untuk judul halaman
public function get_namaMp($tingkatPelajaranID)
{
  $this->db->select('keterangan');
  $this->db->from('tb_tingkat-pelajaran');
  $this->db->where('id',$tingkatPelajaranID);
  $query = $this->db->get();
  return $query->result()[0]->keterangan;
}
    // get data sub
public function dat_sub($subBab)
{
    $this->db->select('judulSubBab,babID');
    $this->db->from('tb_subbab');
    $this->db->where('id',$subBab);
    $query = $this->db->get();
    return $query->result()[0];
}

public function get_namaTingkat($tingkatPelajaranID)
{
    $this->db->select('aliasTingkat');
    $this->db->from('tb_tingkat');
    $this->db->where('id',$tingkatPelajaranID);
    $query = $this->db->get();
    return $query->result()[0]->aliasTingkat;
}
    // mengetahui info tingkat soal
public function get_info_soal($subBabID)
{
    $this->db->select('tkt.id as id_tingkat ,aliasTingkat,tp.id as id_mp,tp.keterangan as mp,bab.id as id_bab, judulBab, subbab.id as id_subbab ,judulSubBab,');
    $this->db->from('tb_tingkat tkt' );
    $this->db->join('tb_tingkat-pelajaran tp','tp.tingkatID=tkt.id');
    $this->db->join('tb_bab bab','bab.tingkatPelajaranID=tp.id');
    $this->db->join('tb_subbab subbab','subbab.babID = bab.id');
    $this->db->where('subbab.id',$subBabID);
    $query = $this->db->get();
    return $query->result_array()[0];
}

    // get piljawaban by id soal and pilihan
public function get_jawaban($jawaban,$id_soal)
{
    $this->db->select('jawaban,gambar as imgJawaban');
    $this->db->from('tb_piljawaban');
    $this->db->where('id_soal',$id_soal);
    $this->db->where('pilihan',$jawaban);
    $query = $this->db->get();
        // cek jika hasil query null
    if($query->num_rows() == 1) {
        return $query->result_array()[0];
    }else{
       return $result='';
   }

}







    // ------------------------- KEPERLUAN SINKRONSISASI ---------------------------//
public function get_all_soal($data){
    $query = "SELECT p.id_soal,judul_soal, soal, jawaban, 
    kesulitan, sumber,audio,
    b.`create_by`, b.random, b.publish, b.UUID, b.status, gambar_soal, 
    pembahasan, gambar_pembahasan, video_pembahasan, status_pembahasan, link        
    FROM `tb_banksoal` b
    JOIN `tb_mm-paketbank` p ON b.`id_soal` = p.`id_soal`
    JOIN tb_paket pk ON pk.`id_paket` = p.`id_paket`
    JOIN `tb_mm-tryoutpaket` mmp ON mmp.`id_paket` = pk.`id_paket`
    JOIN `tb_tryout` t ON t.`id_tryout` = mmp.`id_tryout`
    WHERE t.`id_tryout` = ".$data;
    $result = $this->db->query($query);
    return $result->result(); 

}

public function get_soal_all(){
    $query = "SELECT id_soal,judul_soal, soal, jawaban, 
    kesulitan, sumber,audio,
    b.`create_by`, b.random, b.publish, b.UUID, b.status, gambar_soal, 
    pembahasan, gambar_pembahasan, video_pembahasan, status_pembahasan, link        
    FROM `tb_banksoal` b";
    $result = $this->db->query($query);
    return $result->result(); 

}

public function get_mm_paket_to($data){
        $query = "SELECT mm.id,mm.`id_paket`,mm.id_soal
    FROM `tb_mm-paketbank` mm
    JOIN `tb_banksoal` b ON mm.`id_soal` = b.`id_soal`
    JOIN tb_paket p ON p.`id_paket` = mm.`id_paket`
    JOIN `tb_mm-tryoutpaket` mmp ON mmp.`id_paket` = p.`id_paket`
    JOIN `tb_tryout` t ON t.`id_tryout` = mmp.`id_tryout`
    WHERE t.`id_tryout` = $data";
    $result = $this->db->query($query);
    return $result->result(); 
}

public function get_pilihan_jawaban($data){
    $query = "SELECT pj.`id_pilihan`,pj.`pilihan`,pj.`jawaban`,pj.`id_soal`,pj.`gambar`
    FROM `tb_mm-paketbank` mm
    JOIN `tb_banksoal` b ON mm.`id_soal` = b.`id_soal`
    JOIN tb_paket p ON p.`id_paket` = mm.`id_paket`
    JOIN `tb_mm-tryoutpaket` mmp ON mmp.`id_paket` = p.`id_paket`
    JOIN `tb_tryout` t ON t.`id_tryout` = mmp.`id_tryout`
    JOIN `tb_piljawaban` pj ON pj.`id_soal` = b.`id_soal`
    WHERE t.`id_tryout` = $data";
    $result = $this->db->query($query);
    return $result->result(); 
}
}

?>