<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_rekam_medis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_laporan_rekam_medis', 'rekam');
    }

    public function index()
    {
        $data['title'] = 'Laporan Rekam Medis';
        $data['pasien'] = $this->rekam->get_pasien();
        $data['rekam_medis'] = [];

        $data['tgl_awal']  = date('Y-m-01');
        $data['tgl_akhir'] = date('Y-m-d');
        $data['id_pasien'] = '';

        if ($this->input->post()) {

            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $id_pasien = $this->input->post('id_pasien');

            $data['rekam_medis'] = $this->rekam
                ->get_laporan($tgl_awal, $tgl_akhir, $id_pasien);

            $data['tgl_awal']  = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $data['id_pasien'] = $id_pasien;
        }

        $data['contents'] = $this->load->view(
            'transaksi/rekam_medis/index',
            $data,
            TRUE
        );

        $this->load->view('template', $data);
    }
}
