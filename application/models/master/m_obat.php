<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Obat extends CI_Model {
    
    private $table = 'tbl_obat';
    private $pk = 'id_obat';

    
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

    
    public function get_total_obat() {
        return $this->db->count_all_results($this->table);
    }
    
    public function search_obat($keyword) {
        $this->db->like('nama_obat', $keyword);
        $this->db->or_like('satuan', $keyword);     
        $this->db->or_like('harga_jual', $keyword); 
        return $this->db->get($this->table)->result();
    }
    public function kurangi_stok($id_obat, $jumlah) {
        
        $this->db->set('stok', 'stok - ' . (int)$jumlah, FALSE); 
        $this->db->where($this->pk, $id_obat);
        return $this->db->update($this->table);
    }
}