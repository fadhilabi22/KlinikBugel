<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_dokter', 'M_Dokter'); // Load model dokter
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // R - READ (Menampilkan Tabel Dokter)
    public function index() {
        // Cek Session Wajib
        // chek_session(); // Pastikan fungsi ini ada di helper Anda
        
        $data = [
            'title'     => 'Data Master Dokter',
            'contents'  => 'master/dokter/lihat_data', // Memuat view tabel
            'dokter'    => $this->M_Dokter->get_all() // Ambil semua data
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // C - CREATE (Menampilkan Form Input)
    public function input() {
        $data = [
            'title'     => 'Tambah Dokter Baru',
            'contents'  => 'master/dokter/form_input' // Memuat view form
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // C - CREATE (Proses Simpan Data)
    public function simpan() {
        // 1. Definisikan aturan validasi sesuai kolom NOT NULL dan UNIQUE (jika ada)
        $this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'required');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required');
        $this->form_validation->set_rules('no_izin', 'Nomor Izin (No Izin)', 'required|is_unique[tbl_dokter.no_izin]'); // Asumsi No Izin UNIQUE
        $this->form_validation->set_rules('tarif', 'Tarif', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->input(); // Kembali ke form jika gagal
        } else {
            // 2. Kumpulkan data sesuai kolom DB
            $data = [
                'nama_dokter' => $this->input->post('nama_dokter', TRUE),
                'spesialisasi' => $this->input->post('spesialisasi', TRUE),
                'no_izin' => $this->input->post('no_izin', TRUE),
                'tarif' => $this->input->post('tarif', TRUE),
            ];

            $this->M_Dokter->save($data);
            $this->session->set_flashdata('success', 'Data Dokter berhasil ditambahkan!');
            redirect('master/dokter');
        }
    }
    
    // U - UPDATE (Form Edit)
    public function edit($id) {
        $data_dokter = $this->M_Dokter->get_by_id($id);
        
        if($data_dokter) {
            $data = [
                'title'     => 'Edit Data Dokter',
                'contents'  => 'master/dokter/form_edit',
                'dokter'    => $data_dokter
            ];
            $this->template->load('template', $data['contents'], $data);
        } else {
            $this->session->set_flashdata('error', 'Data Dokter tidak ditemukan.');
            redirect('master/dokter');
        }
    }

    // U - UPDATE (Proses Update)
    public function update() {
        // ... (Logic validasi dan update serupa dengan simpan, tapi dengan pengecualian unique key pada data yang sedang diedit) ...
    }
    
    // D - DELETE (Proses Hapus)
    public function hapus($id) {
        $this->M_Dokter->delete($id);
        $this->session->set_flashdata('success', 'Data Dokter berhasil dihapus!');
        redirect('master/dokter');
    }
}