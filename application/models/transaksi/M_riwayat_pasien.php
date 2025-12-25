<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_riwayat_pasien extends CI_Model {

    public function get_all()
    {
        $this->db->select('
            k.id_kunjungan,
            p.nama_pasien,
            py.tgl_bayar,
            py.total_akhir,
            py.status_bayar
        ');
        $this->db->from('tbl_kunjungan k');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->join('tbl_pembayaran py', 'py.id_kunjungan = k.id_kunjungan', 'left');

       
        $this->db->where('py.status_bayar', 'Lunas');

        $this->db->order_by('py.tgl_bayar', 'DESC');

        return $this->db->get()->result();
    }
}
