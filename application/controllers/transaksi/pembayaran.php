<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        
        // Memuat Model-model yang diperlukan
        $this->load->model('transaksi/m_pendaftaran', 'M_Pendaftaran'); 
        $this->load->model('transaksi/m_pemeriksaan', 'M_Pemeriksaan'); 
        $this->load->model('transaksi/m_pembayaran', 'M_Pembayaran');
        // Asumsi Model Master Tindakan dan Obat juga di-load (walaupun tidak di construct asli)
        // $this->load->model('master/m_tindakan', 'M_Tindakan'); 
        // $this->load->model('master/m_obat', 'M_Obat');
        
        $this->load->library('form_validation');
        $this->load->helper('url');
        // chek_session(); 
    }

    // [GET] FUNGSI 1: Tampilkan Daftar Tagihan Pasien
    public function index() {
    $data = [
        'title'             => 'Daftar Pasien Menunggu Pembayaran',
        'contents'          => 'transaksi/pembayaran/daftar_tagihan', 
        
        // ✅ FIX: Panggil fungsi dari Model M_Pembayaran
        'list_tagihan'      => $this->M_Pembayaran->get_pasien_menunggu_pembayaran() 
    ];
    $this->template->load('template', $data['contents'], $data);
}
    
    // [GET] FUNGSI 2: Menampilkan Form Pembayaran berdasarkan ID Kunjungan
    public function form_tagihan($id_kunjungan) {
        $tagihan = $this->M_Pembayaran->get_detail_tagihan_by_kunjungan($id_kunjungan);

        if (!$tagihan) {
            $this->session->set_flashdata('error', 'Tagihan tidak ditemukan atau sudah dibayar.');
            redirect('transaksi/pembayaran');
        }

        $data = [
            'title'             => 'Form Pembayaran Pasien',
            'contents'          => 'transaksi/pembayaran/form_pembayaran',
            'tagihan'           => $tagihan,
            'total_biaya'       => $this->M_Pembayaran->hitung_total_tagihan($tagihan) 
        ];
        $this->template->load('template', $data['contents'], $data);
    }

    // [POST] FUNGSI 3: Menyimpan Transaksi Pembayaran
    public function simpan_pembayaran() {
        
        // 1. Validasi Input Kasir
        $total_tagihan = $this->input->post('total_tagihan');
        $this->form_validation->set_rules('jumlah_bayar', 'Jumlah Bayar', 'required|numeric|greater_than_equal_to[' . $total_tagihan . ']',
            array('greater_than_equal_to' => 'Uang bayar tidak boleh kurang dari total tagihan.')
        );
        
        if ($this->form_validation->run() == FALSE) {
            $id_kunjungan = $this->input->post('id_kunjungan');
            $this->form_tagihan($id_kunjungan); 
            return;
        }
        
        $id_kunjungan = $this->input->post('id_kunjungan');
        $jumlah_bayar = $this->input->post('jumlah_bayar');
        
        // ✅ Ambil ID Pengguna (Kasir) dari sesi
        // Sesuaikan dengan key sesi yang Anda gunakan (misal: id_user atau id_pengguna)
        $id_pengguna_kasir = $this->session->userdata('id_pengguna'); 
        $kembalian = $jumlah_bayar - $total_tagihan;

        // 2. Simpan ke tbl_pembayaran (Kolom DB disesuaikan)
        $data_pembayaran = [
            'id_kunjungan'      => $id_kunjungan,
            'id_pengguna'       => $id_pengguna_kasir, // Kolom 'id_pengguna'
            'tgl_bayar'         => date('Y-m-d H:i:s'), // Kolom 'tgl_bayar'
            'total_akhir'       => $total_tagihan, // Kolom 'total_akhir'
            'status_bayar'      => 'Lunas', // Kolom 'status_bayar'
            'bukti_bayar'       => NULL, // Kolom 'bukti_bayar' (jika tidak ada file)
            
            // 🛑 CATATAN: Karena tbl_pembayaran Anda TIDAK memiliki kolom 'jumlah_bayar' dan 'kembalian', 
            // kita hapus dari array agar tidak error 1054. 
            // Jika Anda ingin menyimpan nilai ini, Anda harus menambahkannya ke DB.
        ];

        // Lakukan penyimpanan dan update status
        $this->M_Pembayaran->save_pembayaran($data_pembayaran);
        $this->M_Pendaftaran->update_status($id_kunjungan, 'Selesai');
        
        $this->session->set_flashdata('success', 'Pembayaran berhasil! Total: Rp '.number_format($total_tagihan).', Dibayar: Rp '.number_format($jumlah_bayar).', Kembalian: Rp '.number_format($kembalian));
        redirect('transaksi/pembayaran/cetak_struk/' . $id_kunjungan);
    }
    
    // [GET] FUNGSI 4: Menampilkan Struk Pembayaran
    public function cetak_struk($id_kunjungan) {
        $data = [
            'title'             => 'Cetak Struk Pembayaran',
            'contents'          => 'transaksi/pembayaran/struk_cetak',
            'struk'             => $this->M_Pembayaran->get_data_struk($id_kunjungan)
        ];
        $this->template->load('template', $data['contents'], $data);
    }
}