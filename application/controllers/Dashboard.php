<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        
        // chek_session(); 
        
        
        $this->load->model('m_dashboard'); 
    }

    public function index()
    {
        $data['title'] = "Dashboard Klinik";
        
      
        $data['total_pasien']      = $this->m_dashboard->get_total_pasien(); 
        $data['total_dokter']      = $this->m_dashboard->get_total_dokter();
        $data['total_obat']        = $this->m_dashboard->get_total_obat();
        $data['total_pendaftaran'] = $this->m_dashboard->get_total_pendaftaran_hari_ini(); // Pendaftaran Hari Ini

    

        $data['contents'] = 'dashboard/index';
        
        
        $this->template->load('template', $data['contents'], $data); 
    }
}

