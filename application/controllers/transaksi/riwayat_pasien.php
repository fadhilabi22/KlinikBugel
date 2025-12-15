<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_pasien extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // kalau pakai login middleware, taro disini
        // $this->auth->cek_login();
    }

    public function index()
    {
        $data['title'] = 'Riwayat Pasien';

        // DATA DUMMY
        $data['riwayat'] = [
            [
                'id_kunjungan' => 'KJ-001',
                'nama_pasien'  => 'Aqil Ramadhan',
                'tanggal'      => '2025-12-08',
                'keluhan'      => 'Demam tinggi',
                'diagnosa'     => 'Tifus',
                'total_bayar'  => 1900000
            ],
            [
                'id_kunjungan' => 'KJ-002',
                'nama_pasien'  => 'Budi Santoso',
                'tanggal'      => '2025-12-10',
                'keluhan'      => 'Batuk & pilek',
                'diagnosa'     => 'ISPA',
                'total_bayar'  => 300000
            ],
            [
                'id_kunjungan' => 'KJ-003',
                'nama_pasien'  => 'Siti Aminah',
                'tanggal'      => '2025-12-11',
                'keluhan'      => 'Sakit perut',
                'diagnosa'     => 'Maag',
                'total_bayar'  => 450000
            ]
        ];

        // PAKAI TEMPLATE
        $this->template->load(
            'template',
            'transaksi/riwayat_pasien/index',
            $data
        );
    }
}
