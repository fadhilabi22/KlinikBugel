<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/M_Dokter', 'dokter');
        // ❌ PERBAIKAN: Hapus Model Poli karena tabel sudah dihapus
        // $this->load->model('master/M_Poli', 'poli'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // ========================================
    // LIST DATA + SEARCH (Tidak Berubah)
    // ========================================
    public function index() {
        $keyword = $this->input->get('q');

        $data_dokter = !empty($keyword) 
                            ? $this->dokter->search($keyword)
                            : $this->dokter->get_all();

        $data = [
            'title'   => 'Data Master Dokter',
            'dokter'  => $data_dokter,
            'keyword' => $keyword
        ];

        $this->template->load('template', 'master/dokter/lihat_data', $data);
    }

    // ========================================
    // FORM INPUT (TAMBAH)
    // ========================================
    public function input() {
        $data = [
            'title' => 'Tambah Dokter Baru',
            // ❌ PERBAIKAN: Hapus pengiriman data Poli
            // 'poli'  => $this->poli->get_all() 
        ];

        $this->template->load('template', 'master/dokter/form_input', $data);
    }

    // ========================================
    // SIMPAN DATA
    // ========================================
    public function simpan() {
        // ❌ PERBAIKAN: Hapus validasi dan pengambilan data Poli
        /*
        $id_poli = $this->input->post('id_poli');
        $poli = $this->poli->get_by_id($id_poli);

        if (!$poli) {
            $this->session->set_flashdata('error', 'Poli tidak ditemukan!');
            redirect('master/dokter/input');
        }
        */

        // 💡 Logika Baru: Ambil Tarif dan Spesialisasi dari form
        $data = [
            'nama_dokter'   => $this->input->post('nama_dokter'),
            // ✅ Ubah spesialisasi menjadi input manual atau kosongi jika tidak ada kolomnya di DB
            'spesialisasi'  => NULL, // Dikosongi atau diisi dari input form jika ada
            'no_izin'       => $this->input->post('no_izin'),
            // ✅ Ambil tarif dari input form
            'tarif'         => $this->input->post('tarif'), 
            // ❌ Hapus: 'id_poli' => $id_poli
        ];

        $this->dokter->insert($data);
        $this->session->set_flashdata('success', 'Data dokter berhasil disimpan!');
        redirect('master/dokter');
    }

    // ========================================
    // FORM EDIT
    // ========================================
    public function edit($id) {

        $data_dokter = $this->dokter->get_by_id($id);

        if (!$data_dokter) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan.');
            redirect('master/dokter');
        }

        $data = [
            'title'  => 'Edit Dokter',
            'dokter' => $data_dokter,
            // ❌ PERBAIKAN: Hapus pengiriman data Poli
            // 'poli'   => $this->poli->get_all() 
        ];

        $this->template->load('template', 'master/dokter/form_edit', $data);
    }

    // ========================================
    // UPDATE DATA
    // ========================================
    public function update() {

        $id = $this->input->post('id_dokter');
        
        // ❌ PERBAIKAN: Hapus logika validasi dan pengambilan data Poli
        /*
        $id_poli = $this->input->post('id_poli');
        $poli = $this->poli->get_by_id($id_poli);

        if (!$poli) {
            $this->session->set_flashdata('error', 'Poli tidak valid.');
            redirect('master/dokter/edit/'.$id);
        }
        */

        // 💡 Logika Baru: Ambil Tarif dan Spesialisasi dari form
        $data_update = [
            'nama_dokter'   => $this->input->post('nama_dokter'),
            'spesialisasi'  => NULL, // Dikosongi
            'no_izin'       => $this->input->post('no_izin'),
            // ✅ Ambil tarif dari input form
            'tarif'         => $this->input->post('tarif'), 
            // ❌ Hapus: 'id_poli' => $id_poli
        ];

        $this->dokter->update($id, $data_update);

        $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui!');
        redirect('master/dokter');
    }

    // ========================================
    // DELETE DATA (Tidak Berubah)
    // ========================================
    public function hapus($id) {
        $this->dokter->delete($id);
        $this->session->set_flashdata('success', 'Data dokter berhasil dihapus!');
        redirect('master/dokter');
    }
}