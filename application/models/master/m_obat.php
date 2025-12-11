<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Obat extends CI_Model {
    
    private $table = 'tbl_obat';
    private $pk = 'id_obat';

    // FUNGSI CRUD DASAR
    public function get_all() {
        return $this->db->get($this->table)->result();
    }
    
    public function get_by_id($id) {
        $this->db->where($this->pk, $id);
        return $this->db->get($this->table)->row();
    }
    
    // FUNGSI UNTUK INSERT DATA OBAT BARU
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
    public function get_total_obat() {
        return $this->db->count_all_results($this->table);
    }
    
    public function search_obat($keyword) {
        $this->db->like('nama_obat', $keyword);
        $this->db->or_like('satuan', $keyword);     // opsional
        $this->db->or_like('harga_jual', $keyword); // opsional
        return $this->db->get($this->table)->result();
    }
    public function kurangi_stok($id_obat, $jumlah) {
        // Menggunakan operator SET dengan flag FALSE agar MySQL menjalankan 'stok = stok - jumlah'
        $this->db->set('stok', 'stok - ' . (int)$jumlah, FALSE); 
        $this->db->where($this->pk, $id_obat);
        return $this->db->update($this->table);
    }
}