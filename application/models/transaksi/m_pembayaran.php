<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pembayaran extends CI_Model {
    
    /**
     * Mengambil semua detail tagihan (Kunjungan, RM, Resep, Tindakan) 
     * berdasarkan ID Kunjungan. Digunakan untuk FORM TAGIHAN.
     */
    public function get_detail_tagihan_by_kunjungan($id_kunjungan) {
        // 1. Ambil data dasar (Kunjungan, RM, Pasien) DAN ID PEMBAYARAN (jika ada)
        $this->db->select('k.*, rm.id_rm, rm.diagnosa, p.nama_pasien, p.alamat, py.id_pembayaran'); 
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_rekam_medis rm', 'rm.id_kunjungan = k.id_kunjungan');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        // ✅ FIX 3: LEFT JOIN ke tbl_pembayaran untuk mendapatkan ID Pembayaran (FK untuk Tindakan)
        $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan', 'left');
        $this->db->where('k.id_kunjungan', $id_kunjungan);
        $kunjungan = $this->db->get()->row();

        if (!$kunjungan || empty($kunjungan->id_rm)) {
            return FALSE;
        }
        
        $id_rm = $kunjungan->id_rm; 
        $id_pembayaran = $kunjungan->id_pembayaran; // ID Pembayaran yang terbentuk (jika ada)

        // 2. Ambil detail Resep (Sudah benar)
        $kunjungan->resep = $this->db->select('ro.*, o.nama_obat, o.harga_jual')
                                    ->from('tbl_resep_obat ro')
                                    ->join('tbl_obat o', 'o.id_obat = ro.id_obat')
                                    ->where('ro.id_rm', $id_rm)
                                    ->get()->result();

        // 3. Ambil detail Tindakan
        // 🛑 FIX 4: Filter Tindakan menggunakan id_detail_pembayaran (ASUMSI FK ke id_pembayaran)
        // Jika Pembayaran belum dilakukan, id_pembayaran akan NULL, dan query akan mengembalikan 0 baris (BENAR)
        // 3. Ambil detail Tindakan
        $kunjungan->tindakan = $this->db->select('dt.jumlah, t.nama_tindakan, t.biaya_tindakan') 
                                       ->from('tbl_detail_tindakan dt')
                                       ->join('tbl_tindakan t', 't.id_tindakan = dt.id_tindakan')
                                       // ✅ FIX KRUSIAL: ASUMSI KOLOM DI DB HANYA id_pembayaran
                                       ->where('dt.id_pembayaran', $id_pembayaran) 
                                       ->get()->result();
        
        return $kunjungan;
    }
    
    /**
     * Menghitung total tagihan dari tindakan dan resep. (Tidak Berubah)
     */
    public function hitung_total_tagihan($tagihan) {
        $total = 0;
        
        foreach ($tagihan->tindakan as $t) {
            $total += ($t->biaya_tindakan * $t->jumlah); 
        }
        
        foreach ($tagihan->resep as $r) {
            $total += ($r->jumlah * $r->harga_jual); 
        }

        return $total;
    }

    /**
     * Menyimpan data pembayaran ke tbl_pembayaran. (Tidak Berubah)
     */
    public function save_pembayaran($data_pembayaran) {
    // 1. Jalankan INSERT
    $this->db->insert('tbl_pembayaran', $data_pembayaran);
    
    // 2. ✅ FIX: Kembalikan ID yang baru saja ter-insert
    return $this->db->insert_id(); 
}
    
    /**
     * Mengambil daftar pasien yang statusnya Menunggu Pembayaran. (Tidak Berubah)
     */
    public function get_pasien_menunggu_pembayaran() {
        $this->db->select('k.id_kunjungan, p.nama_pasien, k.status_kunjungan');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->where('k.status_kunjungan', 'Menunggu Pembayaran');
        $this->db->order_by('k.tanggal_kunjungan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    /**
     * Mengambil data lengkap untuk keperluan cetak struk.
     * ✅ FIX 5: Mengambil data pembayaran (py) untuk dicetak.
     */
    public function get_data_struk($id_kunjungan) {
    
    // 1. Ambil semua data dasar + data pembayaran (py)
    $this->db->select('k.*, rm.id_rm, rm.diagnosa, p.nama_pasien, p.alamat, 
                       py.id_pembayaran, py.tgl_bayar, py.total_akhir'); 
    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_rekam_medis rm', 'rm.id_kunjungan = k.id_kunjungan');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan'); 
    $this->db->where('k.id_kunjungan', $id_kunjungan);
    $struk = $this->db->get()->row();

    if (!$struk || empty($struk->id_rm)) {
        return FALSE;
    }

    $id_rm = $struk->id_rm;
    $id_pembayaran = $struk->id_pembayaran; 
    
    // 2. Ambil detail Resep (sesuai id_rm)
    $struk->resep = $this->db->select('ro.*, o.nama_obat, o.harga_jual')
                            ->from('tbl_resep_obat ro')
                            ->join('tbl_obat o', 'o.id_obat = ro.id_obat')
                            ->where('ro.id_rm', $id_rm) 
                            // 🛑 PERKUAT FILTER: Jika data Resep duplikat, ini pasti karena
                            // RM yang sedang dibayar TIDAK TERPISAH dari RM lama
                            // TIDAK ADA KOLOM ID KUNJUNGAN DI TBL RESEP (cite: image_158d37.png),
                            // Maka id_rm HARUS UNIK PER KUNJUNGAN!

                            // Saya hapus filter tambahan karena Anda tidak punya kolom lain selain id_rm
                            // dan id_rm sudah diambil dari kunjungan saat ini.
                            // Jika Resep duplikat, masalahnya di input data, bukan di sini.
                            ->get()->result();

    // 3. Ambil detail Tindakan (sesuai id_pembayaran)
    $struk->tindakan = $this->db->select('dt.jumlah, t.nama_tindakan, t.biaya_tindakan') 
                               ->from('tbl_detail_tindakan dt')
                               ->join('tbl_tindakan t', 't.id_tindakan = dt.id_tindakan')
                               ->where('dt.id_pembayaran', $id_pembayaran) 
                               ->get()->result();

    return $struk;
    }
public function get_kunjungan_selesai() {
    $this->db->select('k.id_kunjungan, p.nama_pasien, py.tgl_bayar, py.total_akhir');
    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    // Hanya yang sudah ada di tabel pembayaran
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan'); 
    
    $this->db->where('k.status_kunjungan', 'Selesai');
    $this->db->order_by('py.tgl_bayar', 'DESC');
    
    return $this->db->get()->result();
}
public function get_laporan_pendapatan($tgl_awal, $tgl_akhir) {
    
    // Konversi tanggal untuk mencakup hari penuh
    $start_datetime = $tgl_awal . ' 00:00:00';
    $end_datetime = $tgl_akhir . ' 23:59:59';
    
    $this->db->select('py.*, p.nama_pasien, k.id_kunjungan');
    $this->db->from('tbl_pembayaran py');
    $this->db->join('tbl_kunjungan k', 'k.id_kunjungan = py.id_kunjungan');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    
    // Filter berdasarkan rentang waktu pembayaran
    $this->db->where('py.tgl_bayar >=', $start_datetime);
    $this->db->where('py.tgl_bayar <=', $end_datetime);
    
    $this->db->order_by('py.tgl_bayar', 'ASC');
    
    return $this->db->get()->result();
}
}