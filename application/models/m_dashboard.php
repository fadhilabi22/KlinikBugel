<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_dashboard extends CI_Model {

    // Fungsi untuk menghitung total Pasien terdaftar (dari tbl_pasien)
    public function get_total_pasien() {
        return $this->db->count_all_results('tbl_pasien');
    }

    // Fungsi untuk menghitung total Dokter (dari tbl_dokter)
    public function get_total_dokter() {
        return $this->db->count_all_results('tbl_dokter');
    }

    // Fungsi untuk menghitung total jenis Obat (dari tbl_obat)
    public function get_total_obat() {
        return $this->db->count_all_results('tbl_obat');
    }
    
    // Fungsi untuk menghitung total Pendaftaran Hari Ini
    // Menggunakan tbl_kunjungan (sesuai skema DB Anda)
    // ✅ KODE BARU (Sesuai Struktur DB)
    public function get_total_pendaftaran_hari_ini() {
        $today = date('Y-m-d');
        
        // Menggunakan nama kolom yang benar: 'tanggal_kunjungan'
        $this->db->where('DATE(tanggal_kunjungan)', $today); 
        return $this->db->count_all_results('tbl_kunjungan'); 
    }
    
    // Fungsi untuk menghitung total User/Operator sistem (dari tbl_pengguna)
    public function get_total_user() {
        return $this->db->count_all_results('tbl_pengguna');
    }
    
    // Tambahkan fungsi lain sesuai kebutuhan data di dashboard
    
}
