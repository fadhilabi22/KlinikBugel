<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index()
    {
        

        // ✅ GUNAKAN DATA DUMMY SEMENTARA:
        $data['title'] = "Dashboard Klinik";
        $data['total_pasien']      = 0; // Isi dengan 0 atau string "TBA"
        $data['total_dokter']      = 0;
        $data['total_obat']        = 0;
        $data['total_pendaftaran'] = 0;

        $data['contents'] = 'dashboard/index';
        
        // Panggil template dengan data
        $this->template->load('template', $data['contents'], $data); 
    }
}