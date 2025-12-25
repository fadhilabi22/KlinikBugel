<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pasien extends CI_Model {
    
    private $table = 'tbl_pasien';
    private $pk = 'id_pasien';

    // FUNGSI CRUD DASAR
    public function get_all() {
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where($this->pk, $id);
        return $this->db->get($this->table)->row();
    }
    
    public function save($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        $this->db->where($this->pk, $id);
        return $this->db->update($this->table, $data);
    }

    
    public function delete($id) {
        $this->db->where($this->pk, $id);
        return $this->db->delete($this->table);
    }
    
    
    public function delete_all_transaksi($id_pasien) {
        
        
        
        $this->db->where('id_kunjungan IN (SELECT id_kunjungan FROM tbl_kunjungan WHERE id_pasien = ' . $id_pasien . ')', NULL, FALSE);
        $this->db->delete('tbl_rekam_medis');

       
        $this->db->where('id_pasien', $id_pasien);
        $this->db->delete('tbl_kunjungan');
        
        
        
        return TRUE;
    }

    
    public function get_total_pasien() {
        return $this->db->count_all_results($this->table);
    }

    public function search($keyword) {
        $this->db->like('nama_pasien', $keyword);
        $this->db->or_like('no_telp', $keyword);
        $this->db->or_like('alamat', $keyword);
        return $this->db->get($this->table)->result();
    }
   public function is_pasien_exist($nama, $tgl_lahir, $no_telp)
{
    $this->db->where('nama_pasien', $nama);
    $this->db->where('tgl_lahir', $tgl_lahir);
    $this->db->where('no_telp', $no_telp);

    return $this->db->get('tbl_pasien')->num_rows() > 0;
}


}