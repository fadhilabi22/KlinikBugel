<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dokter extends CI_Model {

    private $table = 'tbl_dokter';
    private $pk    = 'id_dokter';

    

    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, [
            $this->pk => $id
        ])->row();
    }

    public function save($data) {
        return $this->db->insert($this->table, $data);
    }

    
    public function insert($data) {
        return $this->save($data);
    }

    public function update($id, $data) {
        return $this->db->where($this->pk, $id)
                        ->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where($this->pk, $id)
                        ->delete($this->table);
    }

    // ================= SEARCH =================

    public function search($keyword) {
        $this->db->like('nama_dokter', $keyword);
        $this->db->or_like('spesialisasi', $keyword);
        $this->db->or_like('no_izin', $keyword);
        return $this->db->get($this->table)->result();
    }

    public function get_total_dokter() {
        return $this->db->count_all($this->table);
    }

   
    public function cek_nama($nama) {
        return $this->db->where('nama_dokter', $nama)
                        ->get($this->table)
                        ->num_rows();
    }

    public function cek_no_izin($no_izin) {
        return $this->db->where('no_izin', $no_izin)
                        ->get($this->table)
                        ->num_rows();
    }

   
    public function cek_nama_edit($nama, $id) {
        return $this->db->where('nama_dokter', $nama)
                        ->where($this->pk.' !=', $id)
                        ->get($this->table)
                        ->num_rows();
    }

    public function cek_no_izin_edit($no_izin, $id) {
        return $this->db->where('no_izin', $no_izin)
                        ->where($this->pk.' !=', $id)
                        ->get($this->table)
                        ->num_rows();
    }
}
