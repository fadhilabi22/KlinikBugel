<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        
        // Memuat Model Pemeriksaan dan Model lain
        $this->load->model('transaksi/m_pemeriksaan', 'M_Pemeriksaan');
        $this->load->model('transaksi/m_pendaftaran', 'M_Pendaftaran'); // Untuk update status
        $this->load->model('master/m_obat', 'M_Obat'); 
        $this->load->model('transaksi/m_tindakan', 'M_Tindakan');
        
        $this->load->library('form_validation');
        $this->load->helper('url');
        // chek_session(); // Cek login dan role dokter
    }

    // [GET] FUNGSI 1: Tampilkan Antrian Pasien Siap Diperiksa (DOKTER VIEW)
    public function index() {
        // Asumsi: Ambil antrian untuk semua dokter atau filter berdasarkan sesi user (jika sudah ada)
        $data = [
            'title'             => 'Daftar Pasien Siap Diperiksa',
            'contents'          => 'transaksi/pemeriksaan/daftar_pasien_dokter', // View antrian dokter
            'antrian_dokter'    => $this->M_Pemeriksaan->get_pasien_siap_diperiksa() // Ambil list pasien siap periksa
        ];
        $this->template->load('template', $data['contents'], $data);
    }


    // [GET] FUNGSI 2: Menampilkan Form Vital Sign (Oleh Perawat)
    public function input_vitalsign($id_kunjungan) {
        $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($id_kunjungan);

        if (!$kunjungan || $kunjungan->status_kunjungan != 'Diperiksa') { 
             $this->session->set_flashdata('error', 'Kunjungan tidak valid atau status bukan untuk Tanda Vital.');
             redirect('transaksi/pendaftaran');
        }

        $data = [
            'title'        => 'Input Tanda-Tanda Vital',
            'contents'     => 'transaksi/pendaftaran/form_vital_sign', 
            'kunjungan'    => $kunjungan, 
            'id_kunjungan' => $id_kunjungan
        ];
        $this->template->load('template', $data['contents'], $data);
    }
    
    // [POST] FUNGSI 3: Menyimpan Vital Sign (Oleh Perawat)
    public function simpan_vital_sign() {
    $id_kunjungan = $this->input->post('id_kunjungan', TRUE);
    
    // ✅ FIX 1: Load data kunjungan untuk mendapatkan id_dokter
    $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($id_kunjungan); 

    if (!$kunjungan) {
         $this->session->set_flashdata('error', 'Kunjungan tidak ditemukan. Transaksi dibatalkan.');
         redirect('transaksi/pendaftaran');
         return; // Hentikan eksekusi
    }
    
    // Aturan validasi
    $this->form_validation->set_rules('tensi', 'Tekanan Darah', 'required');
    $this->form_validation->set_rules('suhu', 'Suhu Tubuh', 'required|numeric');
    $this->form_validation->set_rules('keluhan', 'Keluhan Utama', 'required');
    $this->form_validation->set_rules('bb', 'Berat Badan', 'required|numeric');
    
    if ($this->form_validation->run() == FALSE) {
        // Jika validasi gagal, kembali ke form dengan data kunjungan
        $this->input_vitalsign($id_kunjungan);
    } else {
        
        $data_rm = [
            'id_kunjungan' => $id_kunjungan,
            
            // ✅ FIX 2: Masukkan id_dokter dari data kunjungan yang di-load
            'id_dokter' => $kunjungan->id_dokter, 
            
            // ✅ KELUHAN UTAMA: Sesuai dengan kolom 'keluhan'
            'keluhan' => $this->input->post('keluhan', TRUE),
            
            // ✅ FIX 3: GABUNGKAN VITAL SIGN KE 'catatan_medis'
            'catatan_medis' => 
                'Tensi: ' . $this->input->post('tensi', TRUE) . ' mmHg | ' .
                'Suhu: ' . $this->input->post('suhu', TRUE) . ' °C | ' .
                'BB: ' . $this->input->post('bb', TRUE) . ' kg',
            
            // ✅ FIX 4: Nama kolom tanggal yang benar
            'tgl_pemeriksaan' => date('Y-m-d H:i:s'), 
            
            // Kolom 'diagnosa' dikosongkan/disiapkan
            'diagnosa' => NULL, 
            
            // Jika Anda menambahkan kolom status_rm di DB, masukkan di sini. Karena sebelumnya tidak ada, kita hapus agar tidak error 1054.
        ];

        // ✅ FIX 5: Lakukan INSERT ke DB (save_rekam_medis)
        $id_rekam_medis = $this->M_Pemeriksaan->save_rekam_medis($data_rm); 
        
        if ($id_rekam_medis) {
            // Update status kunjungan menjadi 'Vital Sign OK'
            $this->M_Pendaftaran->update_status($id_kunjungan, 'Vital Sign OK');
            
            $this->session->set_flashdata('success', 'Tanda Vital dicatat. Pasien siap diperiksa dokter!');
            
            // Arahkan ke daftar antrian dokter
            redirect('transaksi/pemeriksaan'); 

        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan Tanda Vital. Cek Foreign Key atau kolom Wajib Isi (NOT NULL).');
            redirect('transaksi/pendaftaran');
        }
    }
}
    
    // [GET] FUNGSI 4: Menampilkan Form Diagnosis (Oleh Dokter)
    // DI Controller Pemeriksaan.php::input_diagnosis($id_rekam_medis)

public function input_diagnosis($id_rekam_medis) {
    // 1. Ambil data Rekam Medis berdasarkan ID (id_rm)
    $rekam_medis = $this->M_Pemeriksaan->get_by_id($id_rekam_medis);
    
    if (!$rekam_medis) {
        $this->session->set_flashdata('error', 'Data Rekam Medis tidak ditemukan atau sudah selesai.');
        redirect('transaksi/pemeriksaan');
        return;
    }

    // 2. Ambil data Kunjungan terkait
    $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($rekam_medis->id_kunjungan);
    
    if (!$kunjungan) {
        $this->session->set_flashdata('error', 'Data Kunjungan terkait Rekam Medis tidak ditemukan.');
        redirect('transaksi/pemeriksaan');
        return;
    }
    
    // 3. Kirim data ke View form_rekam_medis.php
    $data = [
        'title'         => 'Pemeriksaan & Diagnosis Final',
        'contents'      => 'transaksi/pemeriksaan/form_rekam_medis',
        'rekam_medis'   => $rekam_medis, 
        'kunjungan'     => $kunjungan, 
        'list_obat'     => $this->M_Obat->get_all(), 
        
        // ✅ FIX: Memuat dan mengirim list tindakan
        'list_tindakan' => $this->M_Tindakan->get_all_tindakan(),
    ];
    
    $this->template->load('template', $data['contents'], $data);
}
    
    // [POST] FUNGSI 5: Menyimpan Diagnosis, Tindakan, dan Resep FINAL (Oleh Dokter)
    public function simpan_diagnosis_final() {
    
    // 1. Ambil Data Kunci (ID Rekam Medis & ID Kunjungan)
    $id_rekam_medis = $this->input->post('id_rekam_medis', TRUE);
    $id_kunjungan = $this->input->post('id_kunjungan', TRUE); // WAJIB DIKIRIM DARI FORM

    // --- 2. Ambil Data Diagnosis & Anamnesis ---
    $data_rm_update = [
        'diagnosa'          => $this->input->post('diagnosa', TRUE),
        'catatan_medis'     => $this->input->post('anamnesis', TRUE),
        'tgl_pemeriksaan'   => date('Y-m-d H:i:s'), // Waktu pemeriksaan selesai
        // 'status_rm'         => 'Selesai' 
    ];

    // --- 3. Proses Data Resep (Array) ---
    $id_obat_arr        = $this->input->post('id_obat');
    $jumlah_arr         = $this->input->post('jumlah');
    $aturan_pakai_arr   = $this->input->post('aturan_pakai');

    // DI Controller transaksi/pemeriksaan/Pemeriksaan.php::simpan_diagnosis_final()

// --- 3. Proses Data Resep (Array) ---
// ... (pengambilan data array) ...

$data_resep = [];
if (!empty($id_obat_arr)) {
    foreach ($id_obat_arr as $key => $id_obat) {
        $data_resep[] = [
            // ❌ KODE LAMA: 'id_rekam_medis' => $id_rekam_medis, 
            // ✅ FIX: Ganti ke 'id_rm' agar sesuai dengan kolom DB
            'id_rm' => $id_rekam_medis, 
            'id_obat' => $id_obat, 
            'jumlah' => $jumlah_arr[$key], 
            'aturan_pakai' => $aturan_pakai_arr[$key], 
        ];
    }
}

// --- 4. Proses Data Tindakan (Array) ---
// ... (pengambilan data array) ...

$data_tindakan = [];
if (!empty($id_tindakan_arr)) {
    foreach ($id_tindakan_arr as $key => $id_tindakan) {
        $data_tindakan[] = [
            'id_rm' => $id_rekam_medis, 
            'id_tindakan' => $id_tindakan, 
            'biaya' => $biaya_tindakan_arr[$key], 
        ];
    }
}

    // --- 5. Simpan ke Database (Perlu Transaction untuk keamanan) ---
    
    // a. Update Rekam Medis utama
    $this->M_Pemeriksaan->update_rekam_medis($id_rekam_medis, $data_rm_update);
    
    // b. Insert batch Resep dan Tindakan
    if (!empty($data_resep)) {
        $this->M_Pemeriksaan->save_resep($data_resep);
    }
    if (!empty($data_tindakan)) {
        $this->M_Pemeriksaan->save_detail_tindakan($data_tindakan);
    }
    
    // c. Update status kunjungan
    if ($id_kunjungan) {
        $this->M_Pendaftaran->update_status($id_kunjungan, 'Menunggu Pembayaran');
    }
    
    // --- 6. Feedback dan Redirect ---
    $this->session->set_flashdata('success', 'Pemeriksaan selesai. Pasien diarahkan ke Kasir.');
    redirect('transaksi/pemeriksaan'); // Arahkan kembali ke antrian pemeriksaan (bukan pendaftaran)
}
}