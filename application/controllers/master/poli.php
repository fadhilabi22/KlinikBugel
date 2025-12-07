<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Poli extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/M_Poli', 'poli');
    }

    public function index() {
        $data = [
            'title'     => 'Data Poli',
            'contents'  => 'master/poli/lihat_data',
            'poli'      => $this->poli->get_all()
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    public function tambah() {
        $data = [
            'title'     => 'Tambah Data Poli',
            'contents'  => 'master/poli/form_input'
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    public function simpan() {
        $data = [
            'nama_poli'          => $this->input->post('nama_poli'),
            'biaya_pendaftaran'  => $this->input->post('biaya_pendaftaran')
        ];

        $this->poli->insert($data);
        redirect('master/poli');
    }

    public function edit($id) {
        $data = [
            'title'     => 'Edit Data Poli',
            'contents'  => 'master/poli/form_edit',
            'poli'      => $this->poli->get_by_id($id)
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    public function update() {
        $id = $this->input->post('id_poli');

        $data = [
            'nama_poli'          => $this->input->post('nama_poli'),
            'biaya_pendaftaran'  => $this->input->post('biaya_pendaftaran')
        ];

        $this->poli->update($id, $data);
        redirect('master/poli');
    }

    public function hapus($id) {
        $this->poli->delete($id);
        redirect('master/poli');
    }
}
