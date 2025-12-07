<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/M_Dokter', 'dokter');
        $this->load->model('master/M_Poli', 'poli');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // ========================================
    // LIST DATA + SEARCH
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
            'poli'  => $this->poli->get_all()
        ];

        $this->template->load('template', 'master/dokter/form_input', $data);
    }

    // ========================================
    // SIMPAN DATA
    // ========================================
    public function simpan() {

        $id_poli = $this->input->post('id_poli');
        $poli = $this->poli->get_by_id($id_poli);

        if (!$poli) {
            $this->session->set_flashdata('error', 'Poli tidak ditemukan!');
            redirect('master/dokter/input');
        }

        $data = [
            'nama_dokter'  => $this->input->post('nama_dokter'),
            'spesialisasi' => $poli->nama_poli,
            'no_izin'      => $this->input->post('no_izin'),
            'tarif'        => $poli->biaya_pendaftaran,
            'id_poli'      => $id_poli
        ];

        $this->dokter->insert($data);
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
            'poli'   => $this->poli->get_all()
        ];

        $this->template->load('template', 'master/dokter/form_edit', $data);
    }

    // ========================================
    // UPDATE DATA
    // ========================================
    public function update() {

        $id = $this->input->post('id_dokter');
        $id_poli = $this->input->post('id_poli');

        $poli = $this->poli->get_by_id($id_poli);

        if (!$poli) {
            $this->session->set_flashdata('error', 'Poli tidak valid.');
            redirect('master/dokter/edit/'.$id);
        }

        $data_update = [
            'nama_dokter'  => $this->input->post('nama_dokter'),
            'spesialisasi' => $poli->nama_poli,
            'no_izin'      => $this->input->post('no_izin'),
            'tarif'        => $poli->biaya_pendaftaran,
            'id_poli'      => $id_poli
        ];

        $this->dokter->update($id, $data_update);

        $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui!');
        redirect('master/dokter');
    }

    // ========================================
    // DELETE DATA
    // ========================================
    public function hapus($id) {
        $this->dokter->delete($id);
        $this->session->set_flashdata('success', 'Data dokter berhasil dihapus!');
        redirect('master/dokter');
    }
}
