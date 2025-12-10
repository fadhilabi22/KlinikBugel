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

        $this->load->library('cfpdf');
        
        $this->load->library('form_validation');
        $this->load->helper('url');
        // chek_session(); 
    }

    // [GET] FUNGSI 1: Tampilkan Daftar Tagihan Pasien
    public function index() {
        $data = [
            'title'             => 'Daftar Pasien Menunggu Pembayaran',
            'contents'          => 'transaksi/pembayaran/daftar_tagihan', 
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

        // Ini diperlukan untuk mengatasi PHP Warning jika rm.id_rm tidak ada di SELECT
        $id_rm = isset($tagihan->id_rm) ? $tagihan->id_rm : null;
        
        // Jika id_rm tidak ada, kita tidak bisa hitung total (walaupun harusnya ada di Model)
        if (empty($id_rm)) {
             $this->session->set_flashdata('error', 'Data Rekam Medis tidak terlampir. Tidak dapat menghitung tagihan.');
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
        
        $total_tagihan = $this->input->post('total_tagihan');
        $id_kunjungan = $this->input->post('id_kunjungan');
        $jumlah_bayar = $this->input->post('jumlah_bayar');
        
        // 1. Validasi Input Kasir
        $this->form_validation->set_rules('jumlah_bayar', 'Jumlah Bayar', 'required|numeric|greater_than_equal_to[' . $total_tagihan . ']',
            array('greater_than_equal_to' => 'Uang bayar tidak boleh kurang dari total tagihan.')
        );
        
        if ($this->form_validation->run() == FALSE) {
            $this->form_tagihan($id_kunjungan); 
            return;
        }
        
        $id_pengguna_kasir = $this->session->userdata('id_pengguna'); 
        $kembalian = $jumlah_bayar - $total_tagihan;

        // 2. Simpan ke tbl_pembayaran
        $data_pembayaran = [
            'id_kunjungan'      => $id_kunjungan,
            'id_pengguna'       => $id_pengguna_kasir, 
            'tgl_bayar'         => date('Y-m-d H:i:s'), 
            'total_akhir'       => $total_tagihan, 
            'status_bayar'      => 'Lunas', 
            'bukti_bayar'       => NULL, 
            // 🛑 CATATAN: Karena tbl_pembayaran TIDAK punya kolom jumlah_bayar/kembalian,
            // kita HANYA menyimpannya di flashdata untuk struk.
        ];

        $this->M_Pembayaran->save_pembayaran($data_pembayaran);
        $this->M_Pendaftaran->update_status($id_kunjungan, 'Selesai');
        
        // ✅ FIX: Simpan data bayar dan kembalian ke flashdata sebelum redirect
        $this->session->set_flashdata('jumlah_bayar', $jumlah_bayar);
        $this->session->set_flashdata('kembalian', $kembalian);
        
        $this->session->set_flashdata('success', 'Pembayaran berhasil! Total: Rp '.number_format($total_tagihan).', Dibayar: Rp '.number_format($jumlah_bayar).', Kembalian: Rp '.number_format($kembalian));
        
        // Redirect ke fungsi cetak struk
        redirect('transaksi/pembayaran/cetak_struk/' . $id_kunjungan);
    }
    
    // [GET] FUNGSI 4: Menampilkan Struk Pembayaran
    public function cetak_struk($id_kunjungan) {
    
    // Memanggil Model untuk mendapatkan detail tagihan + data pembayaran
    $struk = $this->M_Pembayaran->get_data_struk($id_kunjungan); 
    
    if (!$struk) {
        $this->session->set_flashdata('error', 'Data struk tidak ditemukan atau pembayaran belum lunas.');
        redirect('transaksi/pembayaran');
    }

    $data = [
        // 'title'          => 'Cetak Struk Pembayaran', // Tidak perlu di view murni
        'struk'          => $struk
        // Flashdata (jumlah_bayar, kembalian) otomatis tersedia
    ];
    
    // 🛑 FIX UTAMA: GUNAKAN load->view() BUKAN template->load()
    // Agar hanya konten struk yang dimuat, tanpa header/sidebar.
    $this->load->view('transaksi/pembayaran/struk_cetak', $data);
}
public function daftar_struk_selesai() {
    
    // Perlu fungsi baru di Model untuk mendapatkan kunjungan berstatus 'Selesai'
    $data_selesai = $this->M_Pembayaran->get_kunjungan_selesai(); 

    $data = [
        'title'             => 'Cetak Ulang Struk',
        'contents'          => 'transaksi/pembayaran/daftar_struk_selesai', 
        'list_selesai'      => $data_selesai
    ];
    $this->template->load('template', $data['contents'], $data);
}
public function laporan_pendapatan() {
    $data['title'] = 'Laporan Pendapatan Harian/Bulanan';
    $data['contents'] = 'transaksi/pembayaran/form_laporan_pendapatan'; // View untuk form & hasil
    $data['laporan'] = []; // Inisiasi array kosong
    $data['tgl_awal'] = date('Y-m-01'); // Default awal bulan
    $data['tgl_akhir'] = date('Y-m-d'); // Default hari ini

    if ($this->input->post()) {
        // Jika ada data POST, proses laporan
        $tgl_awal = $this->input->post('tgl_awal', TRUE);
        $tgl_akhir = $this->input->post('tgl_akhir', TRUE);

        // Validasi tanggal
        if (empty($tgl_awal) || empty($tgl_akhir)) {
            $this->session->set_flashdata('error', 'Tanggal awal dan tanggal akhir wajib diisi.');
        } else {
            // Panggil Model untuk mendapatkan data laporan
            $data['laporan'] = $this->M_Pembayaran->get_laporan_pendapatan($tgl_awal, $tgl_akhir);
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
        }
    }
    
    $this->template->load('template', $data['contents'], $data);
}
// DI Controller Pembayaran.php::export_excel()

public function export_excel() {
    
    // 1. Ambil input tanggal dari GET
    $tgl_awal = $this->input->get('tgl_awal', TRUE);
    $tgl_akhir = $this->input->get('tgl_akhir', TRUE);
    
    // 2. Ambil data laporan
    $laporan = $this->M_Pembayaran->get_laporan_pendapatan($tgl_awal, $tgl_akhir);
    
    if (empty($laporan)) {
        $this->session->set_flashdata('error', 'Tidak ada data laporan pada rentang tanggal tersebut untuk diexport.');
        redirect('transaksi/pembayaran/laporan_pendapatan');
        return;
    }

    // ===================================================
    // ✅ FIX KRUSIAL: MENGGUNAKAN OUTPUT BUFFERING
    // ===================================================
    
    // Mulai Output Buffering
    ob_start(); 
    
    // 3. Load View ke buffer, bukan ke browser
    $data = [
        'laporan' => $laporan,
        'tgl_awal' => $tgl_awal,
        'tgl_akhir' => $tgl_akhir
    ];
    $this->load->view('transaksi/pembayaran/laporan_excel', $data);

    // Ambil konten dari buffer
    $content = ob_get_clean();

    // 4. Set Header untuk Export HTML sebagai file Excel (.xls)
    header("Content-type: application/vnd.ms-excel");
    header("content-disposition:attachment;filename=Laporan_Pendapatan_".$tgl_awal."_sd_".$tgl_akhir.".xls"); 
    
    // 5. Cetak konten
    echo $content;
    exit;
}
public function export_pdf() {
    // 1. Ambil input tanggal dari GET
    $tgl_awal = $this->input->get('tgl_awal', TRUE);
    $tgl_akhir = $this->input->get('tgl_akhir', TRUE);
    
    // 2. Ambil data laporan
    $laporan = $this->M_Pembayaran->get_laporan_pendapatan($tgl_awal, $tgl_akhir);
    
    if (empty($laporan)) {
        $this->session->set_flashdata('error', 'Tidak ada data laporan pada rentang tanggal tersebut untuk diexport.');
        redirect('transaksi/pembayaran/laporan_pendapatan');
        return;
    }

    // 3. Proses data ke format PDF menggunakan FPDF
    
    // Ganti 'pdf' dengan nama library FPDF Anda, jika sudah di-load
    // Asumsi class FPDF bisa diakses
    $pdf = new FPDF('P', 'mm', 'A4'); 
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 7, 'LAPORAN PENDAPATAN KLINIK BUGEL', 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Periode: ' . date('d/m/Y', strtotime($tgl_awal)) . ' s/d ' . date('d/m/Y', strtotime($tgl_akhir)), 0, 1, 'C');
    $pdf->Ln(5);

    // Header Tabel
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
    $pdf->Cell(30, 6, 'ID KUNJ.', 1, 0, 'C');
    $pdf->Cell(50, 6, 'NAMA PASIEN', 1, 0, 'C');
    $pdf->Cell(40, 6, 'TGL BAYAR', 1, 0, 'C');
    $pdf->Cell(40, 6, 'TOTAL TAGIHAN (Rp)', 1, 1, 'C'); 
    
    // Isi Tabel
    $pdf->SetFont('Arial', '', 9);
    $no = 1;
    $grand_total = 0;
    
    foreach ($laporan as $item) {
        $grand_total += $item->total_akhir;
        
        $pdf->Cell(10, 6, $no++, 1, 0, 'C');
        $pdf->Cell(30, 6, $item->id_kunjungan, 1, 0);
        $pdf->Cell(50, 6, $item->nama_pasien, 1, 0);
        $pdf->Cell(40, 6, date('d-m-Y H:i', strtotime($item->tgl_bayar)), 1, 0);
        $pdf->Cell(40, 6, number_format($item->total_akhir, 0, ',', '.'), 1, 1, 'R');
    }
    
    // Footer Total
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(130, 6, 'GRAND TOTAL PENDAPATAN BERSIH', 1, 0, 'R');
    $pdf->Cell(40, 6, number_format($grand_total, 0, ',', '.'), 1, 1, 'R');
    
    // Output PDF
    $pdf->Output('I', 'Laporan_Pendapatan_' . date('Ymd') . '.pdf'); 
    
    exit;
}
}