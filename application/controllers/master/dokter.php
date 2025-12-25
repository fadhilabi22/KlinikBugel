<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dokter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/M_Dokter', 'dokter');
        $this->load->library('form_validation');
    }

    
    public function index() {

        $keyword = $this->input->get('q');

        if (!empty($keyword)) {
            $data_dokter = $this->dokter->search($keyword);
        } else {
            $data_dokter = $this->dokter->get_all();
        }

        $data = [
            'title'   => 'Data Dokter',
            'dokter'  => $data_dokter,
            'keyword' => $keyword
        ];

        $this->template->load('template', 'master/dokter/lihat_data', $data);
    }

   
    public function input() {
        $data = [
            'title' => 'Tambah Dokter'
        ];

        $this->template->load('template', 'master/dokter/form_input', $data);
    }

    
    public function simpan() {

        $nama_dokter = $this->input->post('nama_dokter', TRUE);
        $no_izin     = $this->input->post('no_izin', TRUE);

       
        if ($this->dokter->cek_nama($nama_dokter) > 0) {
            $this->session->set_flashdata('error', 'Nama dokter sudah terdaftar!');
            redirect('master/dokter/input');
        }

        if ($this->dokter->cek_no_izin($no_izin) > 0) {
            $this->session->set_flashdata('error', 'Nomor izin praktik sudah terdaftar!');
            redirect('master/dokter/input');
        }

        $data = [
            'nama_dokter'  => $nama_dokter,
            'spesialisasi' => NULL,
            'no_izin'      => $no_izin,
            'tarif'        => $this->input->post('tarif', TRUE)
        ];

        $this->dokter->insert($data);
        $this->session->set_flashdata('success', 'Data dokter berhasil ditambahkan');
        redirect('master/dokter');
    }

    
    public function edit($id) {

        $dokter = $this->dokter->get_by_id($id);
        if (!$dokter) redirect('master/dokter');

        $data = [
            'title'  => 'Edit Dokter',
            'dokter' => $dokter
        ];

        $this->template->load('template', 'master/dokter/form_edit', $data);
    }

    
    public function update() {

        $id          = $this->input->post('id_dokter');
        $nama_dokter = $this->input->post('nama_dokter', TRUE);
        $no_izin     = $this->input->post('no_izin', TRUE);

        
        if ($this->dokter->cek_nama_edit($nama_dokter, $id) > 0) {
            $this->session->set_flashdata('error', 'Nama dokter sudah digunakan!');
            redirect('master/dokter/edit/'.$id);
        }

        if ($this->dokter->cek_no_izin_edit($no_izin, $id) > 0) {
            $this->session->set_flashdata('error', 'Nomor izin praktik sudah digunakan!');
            redirect('master/dokter/edit/'.$id);
        }

        $data = [
            'nama_dokter'  => $nama_dokter,
            'spesialisasi' => NULL,
            'no_izin'      => $no_izin,
            'tarif'        => $this->input->post('tarif', TRUE)
        ];

        $this->dokter->update($id, $data);
        $this->session->set_flashdata('success', 'Data dokter berhasil diperbarui');
        redirect('master/dokter');
    }

    
    public function hapus($id) {
        $this->dokter->delete($id);
        $this->session->set_flashdata('success', 'Data dokter berhasil dihapus');
        redirect('master/dokter');
    }
}
