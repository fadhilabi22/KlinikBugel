<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_user extends CI_Model {

    private $table = 'tbl_pengguna';
    private $pk    = 'id_pengguna';

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

    public function update($id, $data) {
        $this->db->where($this->pk, $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where($this->pk, $id);
        return $this->db->delete($this->table);
    }

    // ✅ cek username duplikat
    public function cek_username($username) {
        return $this->db
            ->get_where($this->table, ['username' => $username])
            ->num_rows();
    }
}
