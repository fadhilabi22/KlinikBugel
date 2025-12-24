<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_laporan_rekam_medis extends CI_Model {

    /* ===============================
       AMBIL DATA PASIEN (UNTUK FILTER)
    =============================== */
    public function get_pasien()
    {
        return $this->db
            ->order_by('nama_pasien', 'ASC')
            ->get('tbl_pasien')
            ->result();
    }

    /* ===============================
       AMBIL DATA REKAM MEDIS
    =============================== */
    public function get_laporan($tgl_awal, $tgl_akhir, $id_pasien = null)
    {
        $this->db->select('
            rm.id_rm,
            rm.keluhan,
            rm.diagnosa,
            rm.catatan_medis,
            rm.tgl_pemeriksaan AS tanggal,
            p.nama_pasien,
            d.nama_dokter
        ');

        $this->db->from('tbl_rekam_medis rm');
        $this->db->join('tbl_kunjungan k', 'k.id_kunjungan = rm.id_kunjungan');
        $this->db->join('tbl_pasien p', 'p.id_pasien = k.id_pasien');
        $this->db->join('tbl_dokter d', 'd.id_dokter = rm.id_dokter');

        $this->db->where('DATE(rm.tgl_pemeriksaan) >=', $tgl_awal);
        $this->db->where('DATE(rm.tgl_pemeriksaan) <=', $tgl_akhir);

        if (!empty($id_pasien)) {
            $this->db->where('p.id_pasien', $id_pasien);
        }

        $this->db->order_by('rm.tgl_pemeriksaan', 'DESC');

        return $this->db->get()->result();
    }
}