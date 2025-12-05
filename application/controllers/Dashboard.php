<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    // 1. Tambahkan Constructor untuk memuat Model
    public function __construct()
    {
        parent::__construct();
        
        // Cek Session/Login (jika sudah ada fungsi chek_session)
        // chek_session(); 
        
        // Muat Model yang sudah Anda buat
        // Penting: Gunakan nama file/class model yang sesuai
        $this->load->model('m_dashboard'); 
    }

    public function index()
    {
        $data['title'] = "Dashboard Klinik";
        
        // 2. Ganti nilai dummy dengan pemanggilan fungsi dari Model
        $data['total_pasien']      = $this->m_dashboard->get_total_pasien(); 
        $data['total_dokter']      = $this->m_dashboard->get_total_dokter();
        $data['total_obat']        = $this->m_dashboard->get_total_obat();
        $data['total_pendaftaran'] = $this->m_dashboard->get_total_pendaftaran_hari_ini(); // Pendaftaran Hari Ini

        // Catatan: Jika Anda ingin menambahkan Total User ke Dashboard
        // $data['total_user'] = $this->m_dashboard->get_total_user(); 

        $data['contents'] = 'dashboard/index';
        
        // Panggil template dengan data
        $this->template->load('template', $data['contents'], $data); 
    }
}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */