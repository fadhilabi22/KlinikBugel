<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Obat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_obat', 'M_Obat'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->library('upload'); 
    }

    
    public function index() {

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

    
    public function input() {
        $data = [
            'title'     => 'Tambah Data Obat Baru',
            'contents'  => 'master/obat/form_input'
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    
    public function simpan() {

        $this->form_validation->set_rules('nama_obat', 'Nama Obat', 'required|is_unique[tbl_obat.nama_obat]');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');
        $this->form_validation->set_rules('harga_jual', 'Harga Jual', 'required|numeric');
        $this->form_validation->set_rules('stok', 'Stok Awal', 'required|integer');

        if ($this->form_validation->run() == FALSE) {
            $this->input();
            return;
        }

        $data_obat = [
            'nama_obat'  => $this->input->post('nama_obat', TRUE),
            'satuan'     => $this->input->post('satuan', TRUE),
            'harga_jual' => $this->input->post('harga_jual', TRUE),
            'stok'       => $this->input->post('stok', TRUE),
            'foto_obat'  => NULL 
        ];
        
        // Upload Foto 
        if (!empty($_FILES['foto_obat']['name'])) {

            $config['upload_path']   = './assets/img/obat/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
            $config['max_size']      = 2048;
            $config['file_name']     = url_title($data_obat['nama_obat'], 'dash', TRUE) . '_' . time();

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_obat')) {
                $upload_data = $this->upload->data();
                $data_obat['foto_obat'] = $upload_data['file_name'];
            } else {
                $this->session->set_flashdata('error', 'Gagal upload gambar: ' . $this->upload->display_errors());
                redirect('master/obat/input');
                return;
            }
        }

        $this->M_Obat->save($data_obat);
        $this->session->set_flashdata('success', 'Data Obat berhasil ditambahkan!');
        redirect('master/obat');
    }

    
    public function edit($id) {
        $obat_data = $this->M_Obat->get_by_id($id);

        if (!$obat_data) {
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

   
    public function update() {

        $id_obat = $this->input->post('id_obat', TRUE);
        $obat_lama = $this->M_Obat->get_by_id($id_obat);

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
            return;
        }

        $data_update = [
            'nama_obat'  => $this->input->post('nama_obat', TRUE),
            'satuan'     => $this->input->post('satuan', TRUE),
            'harga_jual' => $this->input->post('harga_jual', TRUE),
            'stok'       => $this->input->post('stok', TRUE),
        ];

        // Upload foto jika ada file baru
        $config['upload_path']   = './assets/img/obat/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
        $config['max_size']      = 2048;
        $config['file_name']     = url_title($data_update['nama_obat'], 'dash', TRUE) . '_' . time();

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        if (!empty($_FILES['foto_obat']['name'])) {

            $this->upload->initialize($config);

            if ($this->upload->do_upload('foto_obat')) {

                $upload_data = $this->upload->data();
                $data_update['foto_obat'] = $upload_data['file_name'];

                // Hapus foto lama
                if (!empty($obat_lama->foto_obat)) {
                    $old = $config['upload_path'] . $obat_lama->foto_obat;
                    if (file_exists($old)) unlink($old);
                }

            } else {
                $this->session->set_flashdata('error_upload', 'Gagal upload foto: ' . $this->upload->display_errors());
                redirect('master/obat/edit/' . $id_obat);
                return;
            }
        }

        $this->M_Obat->update($id_obat, $data_update);
        $this->session->set_flashdata('success', 'Data Obat berhasil diupdate!');
        redirect('master/obat');
    }

    
    public function check_unique_nama_obat($nama_obat) {
        $id_obat = $this->input->post('id_obat', TRUE);

        $this->db->where('nama_obat', $nama_obat);
        $this->db->where('id_obat !=', $id_obat);
        $cek = $this->db->get('tbl_obat');

        if ($cek->num_rows() > 0) {
            $this->form_validation->set_message('check_unique_nama_obat', 'Nama obat sudah ada.');
            return FALSE;
        }
        return TRUE;
    }

   
    public function hapus($id) {
        
        $obat = $this->M_Obat->get_by_id($id);

        if ($obat && $obat->foto_obat) {
            $file = './assets/img/obat/' . $obat->foto_obat;
            if (file_exists($file)) unlink($file);
        }

        $this->M_Obat->delete($id);

        $this->session->set_flashdata('success', 'Data Obat berhasil dihapus!');
        redirect('master/obat');
    }
}
?>
