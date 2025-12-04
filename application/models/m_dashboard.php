<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Dashboard extends CI_Model {

    // Fungsi untuk menghitung total Pasien terdaftar (dari tbl_pasien)
    public function get_total_pasien() {
        return $this->db->count_all_results('tbl_pasien');
    }

    // Fungsi untuk menghitung total Dokter (asumsi tbl_dokter)
    public function get_total_dokter() {
        return $this->db->count_all_results('tbl_dokter');
    }

    // Fungsi untuk menghitung total jenis Obat (asumsi tbl_obat)
    public function get_total_obat() {
        return $this->db->count_all_results('tbl_obat');
    }
    
    // Fungsi untuk menghitung total Pendaftaran Hari Ini
    // Ini memerlukan filter tanggal. Asumsi tabel transaksi adalah tbl_pendaftaran/tbl_kunjungan
    public function get_total_pendaftaran_hari_ini() {
        $today = date('Y-m-d');
        
        // Asumsi tabel kunjungan bernama 'tbl_kunjungan' atau 'tbl_pendaftaran'
        // Jika belum ada, Anda bisa menggunakan tbl_pembayaran atau tbl_rekam_medis.
        $this->db->where('DATE(tgl_kunjungan)', $today); 
        return $this->db->count_all_results('tbl_kunjungan'); 
    }
    
    // Fungsi untuk menghitung total User/Operator sistem (dari tbl_pengguna)
    public function get_total_user() {
        return $this->db->count_all_results('tbl_pengguna');
    }
    
    // Tambahkan fungsi lain sesuai kebutuhan data di dashboard
    
}