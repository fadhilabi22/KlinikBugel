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

    // D - DELETE PASIEN (Dipanggil setelah transaksi dihapus)
    public function delete($id) {
        $this->db->where($this->pk, $id);
        return $this->db->delete($this->table);
    }
    
    // ✅ FUNGSI BARU: MENGHAPUS TRANSAKSI BERANTAI UNTUK MENGHINDARI ERROR 1451
    public function delete_all_transaksi($id_pasien) {
        // PERHATIAN: Hapus dari tabel anak ke induk.
        // Asumsi: tbl_resep_obat dan tbl_detail_tindakan terkait dengan tbl_rekam_medis.
        
        // 1. Hapus Rekam Medis (RM)
        // Kita gunakan subquery untuk menemukan semua RM yang terkait dengan kunjungan pasien ini.
        $this->db->where('id_kunjungan IN (SELECT id_kunjungan FROM tbl_kunjungan WHERE id_pasien = ' . $id_pasien . ')', NULL, FALSE);
        $this->db->delete('tbl_rekam_medis');

        // 2. Hapus Kunjungan (Anak dari Pasien)
        $this->db->where('id_pasien', $id_pasien);
        $this->db->delete('tbl_kunjungan');
        
        // 3. Tambahkan delete untuk tbl_pembayaran jika ada relasi langsung ke Pasien atau Kunjungan yang tidak ter-cascade.
        
        return TRUE;
    }

    // FUNGSI UNTUK DASHBOARD
    public function get_total_pasien() {
        return $this->db->count_all_results($this->table);
    }

    public function search($keyword) {
        $this->db->like('nama_pasien', $keyword);
        $this->db->or_like('no_telp', $keyword);
        $this->db->or_like('alamat', $keyword);
        return $this->db->get($this->table)->result();
    }
}