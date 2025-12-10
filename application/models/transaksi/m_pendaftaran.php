<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pendaftaran extends CI_Model {
    
    private $table = 'tbl_kunjungan';
    private $pk = 'id_kunjungan';

    /**
     * Menyimpan data kunjungan baru ke database
     * @param array $data Data yang akan diinsert
     * @return bool
     */
    public function save_kunjungan($data) {
        // ✅ PASTIKAN $data TIDAK MENGANDUNG KEY 'id_poli' saat dipanggil dari Controller
        return $this->db->insert($this->table, $data);
    }

    /**
     * Mengambil daftar antrian untuk hari ini, dengan join ke Pasien dan Dokter.
     * ✅ PERBAIKAN: Hapus JOIN ke tbl_poli.
     * @return array
     */
    public function get_antrian_hari_ini() {
        $today = date('Y-m-d');
        
        // ✅ PERBAIKAN: Hapus t.nama_poli dari SELECT
        $this->db->select('k.*, p.nama_pasien, d.nama_dokter'); 
        $this->db->from($this->table . ' k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->join('tbl_dokter d', 'd.id_dokter = k.id_dokter');
        // ❌ PERBAIKAN: Hapus baris JOIN ke tabel Poli
        // $this->db->join('tbl_poli t', 't.id_poli = k.id_poli'); 
        
        // Filter berdasarkan tanggal hari ini
        $this->db->where('DATE(k.tanggal_kunjungan)', $today); 
        // Hanya tampilkan status yang masih aktif/menunggu proses
        $this->db->where_in('k.status_kunjungan', ['Menunggu', 'Diperiksa']); 
        $this->db->order_by('k.tanggal_kunjungan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mengupdate status kunjungan (misal: Menunggu ke Diperiksa)
     * @param int $id_kunjungan
     * @param string $status_baru
     * @return bool
     */
    public function update_status($id_kunjungan, $status_baru) {
        $this->db->where($this->pk, $id_kunjungan);
        return $this->db->update($this->table, ['status_kunjungan' => $status_baru]);
    }
    
    /**
     * Mengambil semua data Pasien 
     */
     public function get_all_pasien() {
        return $this->db->get('tbl_pasien')->result();
     }
}