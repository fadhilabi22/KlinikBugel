<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pasien extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model pasien dan library form
        $this->load->model('master/m_pasien', 'M_Pasien'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // R - READ (Menampilkan Tabel Pasien)
    public function index() {

    // Ambil kata kunci pencarian dari GET
    $keyword = $this->input->get('keyword');

    if ($keyword) {
        // Jika ada keyword → jalankan pencarian
        $data['pasien'] = $this->M_Pasien->search($keyword);
    } else {
        // Jika tidak ada keyword → tampilkan semua data
        $data['pasien'] = $this->M_Pasien->get_all();
    }

    $data['title']     = 'Data Master Pasien';
    $data['keyword']   = $keyword;
    $data['contents']  = 'master/pasien/lihat_data';

    $this->template->load('template', $data['contents'], $data);
}


    // C - CREATE (Menampilkan Form Input)
    public function input() {
        $data = [
            'title'     => 'Tambah Pasien Baru',
            'contents'  => 'master/pasien/form_input'
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // C - CREATE (Proses Simpan Data)
    public function simpan() {
        // 1. Definisikan aturan validasi
        $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->input(); // Kembali ke form jika gagal
        } else {
            // 2. Kumpulkan data sesuai kolom DB (tbl_pasien)
            $data = [
                'nama_pasien' => $this->input->post('nama_pasien', TRUE),
                'tgl_lahir'   => $this->input->post('tgl_lahir', TRUE),
                'alamat'      => $this->input->post('alamat', TRUE),
                'no_telp'     => $this->input->post('no_telp', TRUE),
                'tgl_dibuat'  => date('Y-m-d H:i:s') // Isi otomatis tanggal dibuat
            ];

            $this->M_Pasien->save($data);
            $this->session->set_flashdata('success', 'Data Pasien berhasil ditambahkan!');
            redirect('master/pasien');
        }
    }
    
    // U - UPDATE (Form Edit)
    public function edit($id) {
        $pasien_data = $this->M_Pasien->get_by_id($id);

        if (empty($pasien_data)) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('master/pasien');
        }

        $data = [
            'title'     => 'Edit Data Pasien',
            'contents'  => 'master/pasien/form_edit', // Memuat view form edit
            'pasien'    => $pasien_data // Mengirim data pasien ke view
        ];
        $this->template->load('template', $data['contents'], $data);
    }
    // U - UPDATE (Proses Update)
    public function update() {
        // 1. Ambil ID pasien yang akan diupdate (dari hidden input di form)
        $id_pasien = $this->input->post('id_pasien', TRUE);

        // 2. Definisikan aturan validasi
        $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|numeric');
        
        $this->form_validation->set_message('required', '%s harus diisi.');
        $this->form_validation->set_message('numeric', '%s harus berupa angka.');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form edit dengan ID pasien
            $this->edit($id_pasien);
        } else {
            // 3. Kumpulkan data yang akan diupdate
            $data = [
                'nama_pasien' => $this->input->post('nama_pasien', TRUE),
                'tgl_lahir'   => $this->input->post('tgl_lahir', TRUE),
                'alamat'      => $this->input->post('alamat', TRUE),
                'no_telp'     => $this->input->post('no_telp', TRUE)
            ];

            // 4. Panggil Model untuk update data
            $this->M_Pasien->update($id_pasien, $data);
            $this->session->set_flashdata('success', 'Data Pasien berhasil diupdate!');
            redirect('master/pasien');
        }
    }
    
 


// D - DELETE (Proses Hapus)
public function hapus($id) {
    
    
    // Fungsi ini akan menjalankan DELETE berantai dari tbl_rekam_medis -> tbl_kunjungan
    $this->M_Pasien->delete_all_transaksi($id); 
    
    // 2. Hapus data pasien (Sekarang aman, tidak akan ada Error 1451)
    $this->M_Pasien->delete($id); 
    
    $this->session->set_flashdata('success', 'Data Pasien dan seluruh riwayat transaksi terkait berhasil dihapus!');
    redirect('master/pasien');
}
}