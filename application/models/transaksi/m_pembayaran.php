<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Pembayaran extends CI_Model {
    
    
    public function get_detail_tagihan_by_kunjungan($id_kunjungan) {
        
        $this->db->select('k.*, rm.id_rm, rm.diagnosa, p.nama_pasien, p.alamat, py.id_pembayaran'); 
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_rekam_medis rm', 'rm.id_kunjungan = k.id_kunjungan');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
       
        $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan', 'left');
        $this->db->where('k.id_kunjungan', $id_kunjungan);
        $kunjungan = $this->db->get()->row();

        if (!$kunjungan || empty($kunjungan->id_rm)) {
            return FALSE;
        }
        
        $id_rm = $kunjungan->id_rm; 
        $id_pembayaran = $kunjungan->id_pembayaran; 

        
        $kunjungan->resep = $this->db->select('ro.*, o.nama_obat, o.harga_jual')
                                    ->from('tbl_resep_obat ro')
                                    ->join('tbl_obat o', 'o.id_obat = ro.id_obat')
                                    ->where('ro.id_rm', $id_rm)
                                    ->get()->result();

        
        $kunjungan->tindakan = $this->db->select('dt.jumlah, t.nama_tindakan, t.biaya_tindakan') 
                                       ->from('tbl_detail_tindakan dt')
                                       ->join('tbl_tindakan t', 't.id_tindakan = dt.id_tindakan')
                                       ->where('dt.id_pembayaran', $id_pembayaran) 
                                       ->get()->result();
        
        return $kunjungan;
    }
    
    
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

   
    public function save_pembayaran($data_pembayaran) {
    
    $this->db->insert('tbl_pembayaran', $data_pembayaran);
    
   
    return $this->db->insert_id(); 
}
    
   
    public function get_pasien_menunggu_pembayaran() {
        $this->db->select('k.id_kunjungan, p.nama_pasien, k.status_kunjungan');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->where('k.status_kunjungan', 'Menunggu Pembayaran');
        $this->db->order_by('k.tanggal_kunjungan', 'ASC');
        
        return $this->db->get()->result();
    }
    
    
public function get_data_struk($id_kunjungan)
{
    
    $this->db->select('
    k.id_kunjungan,
    p.nama_pasien,
    rm.id_rm,
    py.id_pembayaran,
    py.tgl_bayar,
    py.total_akhir,
    py.jumlah_bayar,   
    py.kembalian,      
    py.bukti_bayar
');

    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_rekam_medis rm', 'rm.id_kunjungan = k.id_kunjungan');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan');
    $this->db->where('k.id_kunjungan', $id_kunjungan);

    $struk = $this->db->get()->row();

    if (!$struk) {
        return FALSE;
    }

    $id_rm = $struk->id_rm;
    $id_pembayaran = $struk->id_pembayaran;

    
    $struk->resep = $this->db
        ->select('ro.jumlah, o.nama_obat, o.harga_jual')
        ->from('tbl_resep_obat ro')
        ->join('tbl_obat o', 'o.id_obat = ro.id_obat')
        ->where('ro.id_rm', $id_rm)
        ->get()
        ->result();

    
    $struk->tindakan = $this->db
        ->select('dt.jumlah, t.nama_tindakan, t.biaya_tindakan')
        ->from('tbl_detail_tindakan dt')
        ->join('tbl_tindakan t', 't.id_tindakan = dt.id_tindakan')
        ->where('dt.id_pembayaran', $id_pembayaran)
        ->get()
        ->result();

    return $struk;
}

public function get_kunjungan_selesai() {
    $this->db->select('k.id_kunjungan, p.nama_pasien, py.tgl_bayar, py.total_akhir');
    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan'); 
    
    $this->db->where('k.status_kunjungan', 'Selesai');
    $this->db->order_by('py.tgl_bayar', 'DESC');
    
    return $this->db->get()->result();
}
public function get_laporan_pendapatan($tgl_awal, $tgl_akhir, $keyword = null)
{
    $this->db->select('
        k.id_kunjungan,
        p.nama_pasien,
        k.tanggal_kunjungan,
        py.tgl_bayar,
        py.total_akhir
    ');
    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan');

    
    $this->db->where('DATE(k.tanggal_kunjungan) >=', $tgl_awal);
    $this->db->where('DATE(k.tanggal_kunjungan) <=', $tgl_akhir);

    
    $this->db->where('py.status_bayar', 'Lunas');

    
    if (!empty($keyword)) {
        $keyword = $this->db->escape_like_str($keyword);

        $this->db->where(
            "(p.nama_pasien LIKE '%{$keyword}%' 
              OR k.id_kunjungan LIKE '%{$keyword}%')",
            NULL,
            FALSE
        );
    }

    $this->db->order_by('k.tanggal_kunjungan', 'ASC');

    return $this->db->get()->result();
}



public function search_kunjungan_selesai($keyword)
{
    $this->db->select('
        k.id_kunjungan,
        p.nama_pasien,
        py.tgl_bayar,
        py.total_akhir
    ');
    $this->db->from('tbl_kunjungan k');
    $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
    $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan');
    $this->db->where('k.status_kunjungan', 'Selesai');

    if (!empty($keyword)) {
        $keyword = $this->db->escape_like_str($keyword);

        $this->db->where(
            "(p.nama_pasien LIKE '%{$keyword}%' 
              OR k.id_kunjungan LIKE '%{$keyword}%')",
            NULL,
            FALSE
        );
    }

    $this->db->order_by('py.tgl_bayar', 'DESC');

    return $this->db->get()->result();
}

}