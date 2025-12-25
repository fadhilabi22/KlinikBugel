<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_dashboard extends CI_Model {

    
    public function get_total_pasien() {
        return $this->db->count_all_results('tbl_pasien');
    }

    
    public function get_total_dokter() {
        return $this->db->count_all_results('tbl_dokter');
    }

    
    public function get_total_obat() {
        return $this->db->count_all_results('tbl_obat');
    }
    
    
    public function get_total_pendaftaran_hari_ini() {
        $today = date('Y-m-d');
        
       
        $this->db->where('DATE(tanggal_kunjungan)', $today); 
        return $this->db->count_all_results('tbl_kunjungan'); 
    }
    
   
    public function get_total_user() {
        return $this->db->count_all_results('tbl_pengguna');
    }
    
   
    
}
