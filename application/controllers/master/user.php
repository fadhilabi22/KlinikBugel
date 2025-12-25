<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/M_user', 'M_User');
        $this->load->library('form_validation');
    }

    
    public function index() {
        $data = [
            'title'    => 'Manajemen User',
            'pengguna' => $this->M_User->get_all()
        ];

        $this->template->load('template', 'master/user/lihat_data', $data);
    }

   
    public function input() {
        $data = [
            'title' => 'Tambah User'
        ];

        $this->template->load('template', 'master/user/form_input', $data);
    }

    
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

            $this->M_User->save($data);
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            redirect('master/user');
        }
    }

    
    public function edit($id) {
        $data = [
            'title' => 'Edit User',
            'user'  => $this->M_User->get_by_id($id)
        ];

        $this->template->load('template', 'master/user/form_edit', $data);
    }

   
    public function update() {
        $id = $this->input->post('id_pengguna');

        $data = [
            'username'     => $this->input->post('username', TRUE),
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE)
        ];

        if ($this->input->post('password')) {
            $data['password'] = sha1($this->input->post('password'));
        }

        $this->M_User->update($id, $data);
        $this->session->set_flashdata('success', 'User berhasil diupdate');
        redirect('master/user');
    }

    
    public function hapus($id) {
        $this->M_User->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus');
        redirect('master/user');
    }
}
