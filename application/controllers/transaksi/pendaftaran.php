<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        date_default_timezone_set('Asia/Jakarta');
        // Memuat semua Model yang dibutuhkan
        $this->load->model('transaksi/m_pendaftaran', 'M_Pendaftaran');
        
        // Asumsi Model Master sudah dibuat di folder master/
        $this->load->model('master/m_pasien', 'M_Pasien');
        $this->load->model('master/m_dokter', 'M_Dokter');
        // ❌ PERBAIKAN: Hapus Model Poli (karena tabel sudah dihapus)
        // $this->load->model('master/m_poli', 'M_Poli'); 
        
        $this->load->library('form_validation');
        $this->load->helper('url');
        // chek_session(); 
    }

    // [GET] Tampilkan Daftar Antrian Hari Ini
    public function index() {
        $data = [
            'title'     => 'Antrian Pasien Hari Ini',
            'contents'  => 'transaksi/pendaftaran/lihat_antrian', 
            // Model M_Pendaftaran sudah kita perbaiki agar tidak join ke Poli
            'antrian'   => $this->M_Pendaftaran->get_antrian_hari_ini()
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // [GET] Tampilkan Form Pendaftaran
    public function input() {
        // Mengambil data master untuk dropdown di form
        $data = [
            'title'       => 'Form Pendaftaran Kunjungan Baru',
            'contents'    => 'transaksi/pendaftaran/form_pendaftaran',
            'list_pasien' => $this->M_Pasien->get_all(), 
            'list_dokter' => $this->M_Dokter->get_all(), 
            // ❌ PERBAIKAN: Hapus list_poli
            // 'list_poli'   => $this->M_Poli->get_all() 
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // [POST] Proses Simpan Kunjungan ke tbl_kunjungan
    public function simpan() {
        // Aturan validasi
        $this->form_validation->set_rules('id_pasien', 'Pasien', 'required|numeric');
        // ❌ PERBAIKAN: Hapus validasi Poli
        // $this->form_validation->set_rules('id_poli', 'Poli Tujuan', 'required|numeric'); 
        $this->form_validation->set_rules('id_dokter', 'Dokter Tujuan', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->input();
        } else {
            $data = [
                'id_pasien' => $this->input->post('id_pasien', TRUE),
                // ❌ PERBAIKAN: Hapus id_poli dari array data insert
                // 'id_poli'   => $this->input->post('id_poli', TRUE), 
                'id_dokter' => $this->input->post('id_dokter', TRUE),
                'tanggal_kunjungan' => date('Y-m-d H:i:s'), 
                'status_kunjungan' => 'Menunggu'
            ];

            if ($this->M_Pendaftaran->save_kunjungan($data)) {
                 $this->session->set_flashdata('success', 'Pendaftaran berhasil. Pasien masuk antrian!');
            } else {
                 $this->session->set_flashdata('error', 'Gagal menyimpan data kunjungan. Pastikan ID Dokter/Pasien sudah terdaftar di Master Data.');
            }
            
            redirect('transaksi/pendaftaran');
        }
    }
    
    // [GET] Mengupdate Status Antrian (Tidak ada perubahan, karena tidak melibatkan Poli)
    public function update_status($id_kunjungan, $status) {
        if (!in_array($status, ['Menunggu', 'Diperiksa', 'Selesai', 'Batal'])) {
            $this->session->set_flashdata('error', 'Status yang diminta tidak valid.');
            redirect('transaksi/pendaftaran');
        }
        
        if ($this->M_Pendaftaran->update_status($id_kunjungan, $status)) {
             $this->session->set_flashdata('success', 'Status kunjungan berhasil diperbarui menjadi ' . $status . '.');
        } else {
             $this->session->set_flashdata('error', 'Gagal memperbarui status kunjungan.');
        }
        
        redirect('transaksi/pendaftaran');
    }
}