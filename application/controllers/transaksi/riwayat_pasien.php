<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_pasien extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_riwayat_pasien', 'riwayat');
    }

    public function index()
{
    $data['title'] = 'Riwayat Pasien';
    $data['riwayat'] = $this->riwayat->get_all(); // ✔ sesuai model

    $data['contents'] = $this->load->view(
        'transaksi/riwayat_pasien/index',
        $data,
        TRUE
    );

    $this->load->view('template', $data);
}

}