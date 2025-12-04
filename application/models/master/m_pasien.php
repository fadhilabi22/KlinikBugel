<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_pasien extends CI_Model {
    
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
    
    // FUNGSI UNTUK INSERT DATA PASIEN BARU
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
    public function get_total_pasien() {
        return $this->db->count_all_results($this->table);
    }
}