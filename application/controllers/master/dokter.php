<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_dokter', 'M_Dokter');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // =======================
    // LIST DATA + SEARCH
    // =======================
    public function index() {
    $keyword = $this->input->get('q');

    $data_dokter = !empty($keyword) 
                    ? $this->M_Dokter->search($keyword)
                    : $this->M_Dokter->get_all();

    $data = [
        'title'     => 'Data Master Dokter',
        'dokter'    => $data_dokter,
        'keyword'   => $keyword
    ];

    // PANGGIL VIEW LANGSUNG
    $this->template->load('template', 'master/dokter/lihat_data', $data);
}


    // =======================
    // FORM CREATE
    // =======================
    public function input() {
        $data = [
            'title'     => 'Tambah Dokter Baru',
            'contents'  => 'master/dokter/form_input'
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    // =======================
    // PROSES SIMPAN
    // =======================
    public function simpan() {
        $this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'required');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required');
        $this->form_validation->set_rules('no_izin', 'Nomor Izin', 'required|is_unique[tbl_dokter.no_izin]');
        $this->form_validation->set_rules('tarif', 'Tarif Konsultasi', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            return $this->input();
        }

        $data = [
            'nama_dokter'  => $this->input->post('nama_dokter', TRUE),
            'spesialisasi' => $this->input->post('spesialisasi', TRUE),
            'no_izin'      => $this->input->post('no_izin', TRUE),
            'tarif'        => $this->input->post('tarif', TRUE)
        ];

        $this->M_Dokter->save($data);
        $this->session->set_flashdata('success', 'Dokter baru berhasil ditambahkan!');
        redirect('master/dokter');
    }

    // =======================
    // FORM EDIT
    // =======================
    public function edit($id) {
        $data_dokter = $this->M_Dokter->get_by_id($id);

        if (!$data_dokter) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan.');
            return redirect('master/dokter');
        }

        $data = [
            'title'     => 'Edit Dokter',
            'contents'  => 'master/dokter/form_edit',
            'dokter'    => $data_dokter
        ];

        $this->template->load('template', $data['contents'], $data);
    }


    // =======================
    // PROSES UPDATE
    // =======================
    public function update() {
        $id = $this->input->post('id_dokter');

        $dokter_lama = $this->M_Dokter->get_by_id($id);
        if (!$dokter_lama) {
            $this->session->set_flashdata('error', 'Data dokter tidak ditemukan.');
            return redirect('master/dokter');
        }

        // Cek apakah nomor izin berubah
        $no_izin_baru = $this->input->post('no_izin');
        $is_unique = ($no_izin_baru != $dokter_lama->no_izin) 
                        ? '|is_unique[tbl_dokter.no_izin]' 
                        : '';

        // Validasi update
        $this->form_validation->set_rules('nama_dokter', 'Nama Dokter', 'required');
        $this->form_validation->set_rules('spesialisasi', 'Spesialisasi', 'required');
        $this->form_validation->set_rules('no_izin', 'Nomor Izin', 'required' . $is_unique);
        $this->form_validation->set_rules('tarif', 'Tarif Konsultasi', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }

        $data_update = [
            'nama_dokter'  => $this->input->post('nama_dokter'),
            'spesialisasi' => $this->input->post('spesialisasi'),
            'no_izin'      => $this->input->post('no_izin'),
            'tarif'        => $this->input->post('tarif')
        ];

        $this->M_Dokter->update($id, $data_update);

        $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui!');
        redirect('master/dokter');
    }

    // =======================
    // DELETE
    // =======================
    public function hapus($id) {
        $this->M_Dokter->delete($id);
        $this->session->set_flashdata('success', 'Data dokter berhasil dihapus!');
        redirect('master/dokter');
    }
    public function test_flash()
{
    $this->session->set_flashdata('success','Flashdata TEST muncul!');
    redirect('master/dokter');
}
}
