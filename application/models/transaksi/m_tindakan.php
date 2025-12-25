<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_tindakan extends CI_Model {
    
    // Asumsi nama tabel adalah tbl_tindakan
    private $tbl_tindakan = 'tbl_tindakan'; 
    private $pk_tindakan = 'id_tindakan'; // Primary Key

    /**
     * Mengambil semua daftar tindakan beserta biaya
     * Dipanggil oleh Controller Pemeriksaan untuk modal
     * @return array
     */
    public function get_all_tindakan() {
       
        return $this->db->get($this->tbl_tindakan)->result(); 
    }

    
}