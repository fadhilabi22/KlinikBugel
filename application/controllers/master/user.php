<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_user', 'M_User');
        $this->load->library('form_validation');
    }

    // READ
    public function index() {
        $data = [
            'title'     => 'Manajemen User',
            'contents'  => 'master/user/lihat_data',
            'pengguna'  => $this->M_Pengguna->get_all()
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // FORM INPUT
    public function input() {
        $data = [
            'title'    => 'Tambah User',
            'contents' => 'master/user/form_input'
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // SIMPAN
    public function simpan() {

        $this->form_validation->set_rules(
            'username', 'Username',
            'required|is_unique[tbl_pengguna.username]'
        );
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->input();
        } else {

            $data = [
                'username'     => $this->input->post('username', TRUE),
                'password'     => sha1($this->input->post('password')),
                'nama_lengkap' => $this->input->post('nama_lengkap', TRUE)
            ];

            $this->M_Pengguna->save($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            redirect('master/user');
        }
    }

    // FORM EDIT
    public function edit($id) {
        $data = [
            'title'    => 'Edit User',
            'contents' => 'master/user/form_edit',
            'user'     => $this->M_Pengguna->get_by_id($id)
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // UPDATE
    public function update() {
        $id = $this->input->post('id_pengguna');

        $data = [
            'username'     => $this->input->post('username', TRUE),
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE)
        ];

        if ($this->input->post('password')) {
            $data['password'] = sha1($this->input->post('password'));
        }

        $this->M_Pengguna->update($id, $data);
        $this->session->set_flashdata('success', 'User berhasil diupdate');
        redirect('master/user');
    }

    // DELETE
    public function hapus($id) {
        $this->M_Pengguna->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus');
        redirect('master/user');
    }
}
