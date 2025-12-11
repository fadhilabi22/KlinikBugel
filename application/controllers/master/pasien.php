<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pasien extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_pasien', 'M_Pasien'); 
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    // =========================
    // LIST PASIEN
    // =========================
    public function index() {

        $keyword = $this->input->get('keyword');

        if ($keyword) {
            $data['pasien'] = $this->M_Pasien->search($keyword);
        } else {
            $data['pasien'] = $this->M_Pasien->get_all();
        }

        $data['title']     = 'Data Master Pasien';
        $data['keyword']   = $keyword;
        $data['contents']  = 'master/pasien/lihat_data';

        $this->template->load('template', $data['contents'], $data);
    }

    // =========================
    // FORM INPUT
    // =========================
    public function input() {
        $data = [
            'title'     => 'Tambah Pasien Baru',
            'contents'  => 'master/pasien/form_input'
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // =========================
    // SIMPAN DATA BARU
    // + VALIDASI DUPLIKASI
    // =========================
    public function simpan()
{
    // RULE VALIDASI
    $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
    $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
    $this->form_validation->set_rules('alamat', 'Alamat', 'required');
    $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->input(); // kembali ke form input
        return;
    }

    // AMBIL DATA
    $nama = $this->input->post('nama_pasien', TRUE);
    $tgl  = $this->input->post('tgl_lahir', TRUE);
    $telp = $this->input->post('no_telp', TRUE);

    // CEK DUPLIKAT
    if ($this->M_Pasien->is_pasien_exist($nama, $tgl, $telp)) {
        $this->session->set_flashdata('error', 
            '❌ Data pasien dengan nama <b>'.$nama.'</b> sudah terdaftar!'
        );
        redirect('master/pasien/input');
        return;
    }

    // DATA SIMPAN
    $data = [
        'nama_pasien' => $nama,
        'tgl_lahir'   => $tgl,
        'alamat'      => $this->input->post('alamat', TRUE),
        'no_telp'     => $telp,
        'tgl_dibuat'  => date('Y-m-d H:i:s')
    ];

    // SIMPAN
    $this->M_Pasien->save($data);

    $this->session->set_flashdata('success', 'Data Pasien berhasil ditambahkan!');
    redirect('master/pasien');
}




    // =========================
    // FORM EDIT
    // =========================
    public function edit($id) {
        $pasien_data = $this->M_Pasien->get_by_id($id);

        if (empty($pasien_data)) {
            $this->session->set_flashdata('error', 'Data pasien tidak ditemukan.');
            redirect('master/pasien');
        }

        $data = [
            'title'     => 'Edit Data Pasien',
            'contents'  => 'master/pasien/form_edit',
            'pasien'    => $pasien_data
        ];

        $this->template->load('template', $data['contents'], $data);
    }

    // =========================
    // UPDATE DATA
    // + CEK DUPLIKASI (kecuali dirinya sendiri)
    // =========================
    public function update() {

        $id_pasien = $this->input->post('id_pasien', TRUE);

        $this->form_validation->set_rules('nama_pasien', 'Nama Pasien', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id_pasien);
            return;
        }

        // Input update
        $nama      = $this->input->post('nama_pasien', TRUE);
        $tgl_lahir = $this->input->post('tgl_lahir', TRUE);
        $no_telp   = $this->input->post('no_telp', TRUE);

        // ============================
        // 🔥 VALIDASI DUPLIKASI UPDATE
        // CEK apakah ada pasien lain dgn data sama
        // ============================
        $this->db->where('nama_pasien', $nama);
        $this->db->where('tgl_lahir', $tgl_lahir);
        $this->db->where('no_telp', $no_telp);
        $this->db->where('id_pasien !=', $id_pasien);

        if ($this->db->get('tbl_pasien')->num_rows() > 0) {
            $this->session->set_flashdata('error', '❌ Pasien dengan data tersebut sudah ada!');
            redirect('master/pasien/edit/' . $id_pasien);
            return;
        }

        // Update aman
        $data = [
            'nama_pasien' => $nama,
            'tgl_lahir'   => $tgl_lahir,
            'alamat'      => $this->input->post('alamat', TRUE),
            'no_telp'     => $no_telp
        ];

        $this->M_Pasien->update($id_pasien, $data);
        $this->session->set_flashdata('success', 'Data pasien berhasil diupdate!');
        redirect('master/pasien');
    }


    // =========================
    // DELETE
    // =========================
    public function hapus($id) {

        $this->M_Pasien->delete_all_transaksi($id);
        $this->M_Pasien->delete($id);

        $this->session->set_flashdata('success', 'Pasien & seluruh transaksi terkait berhasil dihapus!');
        redirect('master/pasien');
    }

}
