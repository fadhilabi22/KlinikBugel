<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pembayaran extends CI_Model {
    
    /**
     * Mengambil semua detail tagihan (Kunjungan, RM, Resep, Tindakan) 
     * berdasarkan ID Kunjungan.
     */
    public function get_detail_tagihan_by_kunjungan($id_kunjungan) {
        // 1. Ambil data dasar (Kunjungan, RM, Pasien)
        $this->db->select('k.*, rm.id_rm, rm.diagnosa, p.nama_pasien, p.alamat');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_rekam_medis rm', 'rm.id_kunjungan = k.id_kunjungan');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->where('k.id_kunjungan', $id_kunjungan);
        $kunjungan = $this->db->get()->row();

        if (!$kunjungan) {
            return FALSE;
        }

        $id_rm = $kunjungan->id_rm;
        
        // 2. Ambil detail Resep (Tidak berubah)
        $kunjungan->resep = $this->db->select('ro.*, o.nama_obat, o.harga_jual')
                                    ->from('tbl_resep_obat ro')
                                    ->join('tbl_obat o', 'o.id_obat = ro.id_obat')
                                    ->where('ro.id_rm', $id_rm) 
                                    ->get()->result();

        // 3. Ambil detail Tindakan (Tidak berubah, karena sudah diperbaiki di langkah sebelumnya)
        $kunjungan->tindakan = $this->db->select('dt.jumlah, t.nama_tindakan, t.biaya_tindakan') 
                                       ->from('tbl_detail_tindakan dt')
                                       ->join('tbl_tindakan t', 't.id_tindakan = dt.id_tindakan')
                                       ->where('dt.id_rm', $id_rm)
                                       ->get()->result();
        
        return $kunjungan;
    }
    
    /**
     * Menghitung total tagihan dari tindakan dan resep.
     */
    public function hitung_total_tagihan($tagihan) {
        $total = 0;
        
        // Total Biaya Tindakan (Tidak berubah)
        foreach ($tagihan->tindakan as $t) {
            $total += ($t->biaya_tindakan * $t->jumlah); 
        }
        
        // Total Biaya Obat (Tidak berubah)
        foreach ($tagihan->resep as $r) {
            $total += ($r->jumlah * $r->harga_jual); 
        }

        return $total;
    }

    /**
     * Menyimpan data pembayaran ke tbl_pembayaran.
     */
    public function save_pembayaran($data_pembayaran) {
        return $this->db->insert('tbl_pembayaran', $data_pembayaran);
    }
    
    /**
     * Mengambil daftar pasien yang statusnya Menunggu Pembayaran.
     */
    public function get_pasien_menunggu_pembayaran() {
        // ✅ PERBAIKAN: Hapus t.nama_poli dari SELECT
        $this->db->select('k.id_kunjungan, p.nama_pasien, k.status_kunjungan');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->where('k.status_kunjungan', 'Menunggu Pembayaran');
        $this->db->order_by('k.tanggal_kunjungan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mengambil data lengkap untuk keperluan cetak struk.
     */
    public function get_data_struk($id_kunjungan) {
        return $this->get_detail_tagihan_by_kunjungan($id_kunjungan); 
    }
}