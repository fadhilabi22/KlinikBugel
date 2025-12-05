<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_dokter extends CI_Model {
    
    private $table = 'tbl_dokter';
    private $pk = 'id_dokter';

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

    // FUNGSI UNTUK DASHBOARD
    public function get_total_dokter() {
        return $this->db->count_all_results($this->table);
    }

   public function search($keyword)
{
    $keyword = strtolower($keyword);

    $this->db->where("LOWER(nama_dokter) LIKE '%$keyword%' 
                    OR LOWER(spesialisasi) LIKE '%$keyword%' 
                    OR LOWER(no_izin) LIKE '%$keyword%'");

    return $this->db->get($this->table)->result();
}


}