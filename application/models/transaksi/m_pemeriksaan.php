<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pemeriksaan extends CI_Model {
    
    // Tabel utama
    private $tbl_rm = 'tbl_rekam_medis';
    private $pk_rm = 'id_rm'; 
    
    // Tabel detail
    private $tbl_resep = 'tbl_resep_obat';
    private $tbl_detail_tindakan = 'tbl_detail_tindakan'; 

    // ✅ FIX 1: TAMBAHKAN CONSTRUCTOR UNTUK MEMUAT MODEL LAIN
    public function __construct() {
        parent::__construct();
        // Muat model obat agar bisa diakses oleh $this->M_Obat di Model ini
        $this->load->model('master/m_obat', 'M_Obat'); 
    }
    
    /**
     * Menyimpan data Rekam Medis (Vital Sign/Diagnosis Awal)
     */
    public function save_rekam_medis($data_rm) {
        $this->db->insert($this->tbl_rm, $data_rm);
        return $this->db->insert_id();
    }
    
    /**
     * Menyimpan detail resep obat (batch insert)
     */
    public function save_resep($data_resep) {
        if (!empty($data_resep) && is_array($data_resep)) {
            return $this->db->insert_batch($this->tbl_resep, $data_resep);
        }
        return FALSE;
    }

    /**
     * Menyimpan detail tindakan (batch insert)
     */
    public function save_detail_tindakan($data_tindakan) {
        if (!empty($data_tindakan) && is_array($data_tindakan)) {
            return $this->db->insert_batch($this->tbl_detail_tindakan, $data_tindakan);
        }
        return FALSE;
    }
    
    // ✅ FIX 2: Sempurnakan logic error handling
    public function save_resep_dan_kurangi_stok($id_rm, $data_resep_array) {
        
        // Cek: M_Obat sudah pasti ada karena dimuat di __construct()
        
        // 1. Looping untuk setiap obat dalam resep
        foreach ($data_resep_array as $detail) {
            
            // 2. Simpan Detail Resep
            $this->db->insert($this->tbl_resep, $detail);

            // 3. ✅ BAGIAN KRUSIAL: Panggil fungsi pengurangan stok
            $kurangi_stok_sukses = $this->M_Obat->kurangi_stok($detail['id_obat'], $detail['jumlah']);
            
            if ($kurangi_stok_sukses === FALSE) {
                // Jika update stok gagal (Error database)
                // Kita kembalikan FALSE agar Controller memicu rollback
                return FALSE; 
            } 
        }
        
        return TRUE; // Jika looping berhasil
    }

    /**
     * Mengambil data kunjungan berdasarkan ID untuk form pemeriksaan
     * Join ke Pasien, Dokter.
     */
    public function get_kunjungan_by_id($id_kunjungan) {
        $this->db->select('k.*, p.nama_pasien, p.no_telp, p.alamat, d.nama_dokter');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->join('tbl_dokter d', 'd.id_dokter = k.id_dokter');
        $this->db->where('k.id_kunjungan', $id_kunjungan);
        return $this->db->get()->row();
    }
    
    /**
     * Mengambil data Rekam Medis berdasarkan ID
     */
    public function get_by_id($id_rm) {
        $this->db->where($this->pk_rm, $id_rm);
        return $this->db->get($this->tbl_rm)->row();
    }
    
    /**
     * Mengambil daftar pasien yang sudah selesai Vital Sign dan siap diperiksa dokter
     */
    public function get_pasien_siap_diperiksa($id_dokter = null) {
        $this->db->select('rm.id_rm, k.id_kunjungan, k.tanggal_kunjungan as tgl_vitalsign, rm.keluhan, p.nama_pasien, k.status_kunjungan');
        $this->db->from('tbl_rekam_medis rm');
        $this->db->join('tbl_kunjungan k', 'k.id_kunjungan = rm.id_kunjungan');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->where('k.status_kunjungan', 'Vital Sign OK');
        
        if ($id_dokter) {
            $this->db->where('k.id_dokter', $id_dokter); 
        }
        $this->db->order_by('k.tanggal_kunjungan', 'ASC');
        
        return $this->db->get()->result();
    }

    public function update_rekam_medis($id_rm, $data) {
        $this->db->where($this->pk_rm, $id_rm);
        return $this->db->update($this->tbl_rm, $data);
    }
}