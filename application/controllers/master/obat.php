<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class obat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_obat', 'M_Obat'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // READ
    public function index() {

        // Ambil keyword dari GET
        $keyword = $this->input->get('keyword');

        if (!empty($keyword)) {
            $obat = $this->M_Obat->search_obat($keyword);
        } else {
            $obat = $this->M_Obat->get_all();
        }

        $data = [
            'title'     => 'Data Obat & Manajemen Stok',
            'contents'  => 'master/obat/lihat_data',
            'obat'      => $obat,
            'keyword'   => $keyword
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    // FORM INPUT
    public function input() {
        $data = [
            'title'     => 'Tambah Data Obat Baru',
            'contents'  => 'master/obat/form_input'
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // SIMPAN
    public function simpan() {

        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|is_unique[tbl_obat.nama_obat]');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok Awal', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->input();
        } else {

            $data = [
                'nama_obat'  => $this->input->post('nama_obat', TRUE),
                'satuan'     => $this->input->post('satuan', TRUE),
                'harga_jual' => $this->input->post('harga_jual', TRUE),
                'stok'       => $this->input->post('stok', TRUE),
            ];

            $this->M_Obat->save($data);
            $this->session->set_flashdata('success', 'Data Obat berhasil ditambahkan!');
            redirect('master/obat');
        }
    }

    // EDIT FORM
    public function edit($id) {
        $obat_data = $this->M_Obat->get_by_id($id);

        if (empty($obat_data)) {
            $this->session->set_flashdata('error', 'Data obat tidak ditemukan.');
            redirect('master/obat');
        }

        $data = [
            'title'     => 'Edit Data Obat',
            'contents'  => 'master/obat/form_edit',
            'obat'      => $obat_data
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // PROSES UPDATE
    public function update() {

        $id_obat = $this->input->post('id_obat', TRUE);

        // Rules update (nama_obat harus unik kecuali miliknya sendiri)
        $this->form_validation->set_rules(
            'nama_obat', 
            'Nama Obat', 
            'required|callback_check_unique_nama_obat'
        );
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id_obat);
        } else {

            $data = [
                'nama_obat'  => $this->input->post('nama_obat', TRUE),
                'satuan'     => $this->input->post('satuan', TRUE),
                'harga_jual' => $this->input->post('harga_jual', TRUE),
                'stok'       => $this->input->post('stok', TRUE),
            ];

            $this->M_Obat->update($id_obat, $data);
            $this->session->set_flashdata('success', 'Data Obat berhasil diupdate!');
            redirect('master/obat');
        }
    }

    // CALLBACK CHECK UNIQUE UNTUK UPDATE
    public function check_unique_nama_obat($nama_obat) {
        $id_obat = $this->input->post('id_obat', TRUE);

        $this->db->where('nama_obat', $nama_obat);
        $this->db->where('id_obat !=', $id_obat);
        $query = $this->db->get('tbl_obat');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nama_obat', 'Nama obat ini sudah ada.');
            return FALSE;
        }
        return TRUE;
    }

    // DELETE
    public function hapus($id) {
        $this->M_Obat->delete($id);
        $this->session->set_flashdata('success', 'Data Obat berhasil dihapus!');
        redirect('master/obat');
    }
}
