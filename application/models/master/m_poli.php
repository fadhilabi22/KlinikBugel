<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Poli extends CI_Model {

    // Nama tabel
    private $table = 'tbl_poli';

    // Get all poli
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Get poli by ID
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id_poli' => $id])->row();
    }

    // Insert data
    public function insert($data) {

        // pastikan hanya field yang valid
        $insertData = [
            'nama_poli'          => $data['nama_poli'],
            'biaya_pendaftaran'  => $data['biaya_pendaftaran']
        ];

        return $this->db->insert($this->table, $insertData);
    }

    // Update data
    public function update($id, $data) {

        $updateData = [
            'nama_poli'          => $data['nama_poli'],
            'biaya_pendaftaran'  => $data['biaya_pendaftaran']
        ];

        return $this->db->where('id_poli', $id)->update($this->table, $updateData);
    }

    // Delete
    public function delete($id) {
        return $this->db->where('id_poli', $id)->delete($this->table);
    }
}
