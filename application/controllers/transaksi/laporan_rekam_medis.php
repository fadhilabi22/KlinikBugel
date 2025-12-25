<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_rekam_medis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_laporan_rekam_medis', 'rekam');
        $this->load->library('fpdf'); // pastikan FPDF sudah ada
    }

    public function index()
    {
        $data['title'] = 'Laporan Rekam Medis';
        $data['pasien'] = $this->rekam->get_pasien();
        $data['rekam_medis'] = [];

        $data['tgl_awal']  = date('Y-m-01');
        $data['tgl_akhir'] = date('Y-m-d');
        $data['id_pasien'] = '';

        if ($this->input->post()) {

            $tgl_awal  = $this->input->post('tgl_awal');
            $tgl_akhir = $this->input->post('tgl_akhir');
            $id_pasien = $this->input->post('id_pasien');

            $data['rekam_medis'] = $this->rekam
                ->get_laporan($tgl_awal, $tgl_akhir, $id_pasien);

            $data['tgl_awal']  = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $data['id_pasien'] = $id_pasien;
        }

        $data['contents'] = $this->load->view(
            'transaksi/rekam_medis/index',
            $data,
            TRUE
        );

        $this->load->view('template', $data);
    }

  
public function export_excel()
{
    $tgl_awal  = $this->input->get('tgl_awal', TRUE);
    $tgl_akhir = $this->input->get('tgl_akhir', TRUE);
    $id_pasien = $this->input->get('id_pasien', TRUE);

    $laporan = $this->rekam->get_laporan($tgl_awal, $tgl_akhir, $id_pasien);

    if (empty($laporan)) {
        $this->session->set_flashdata(
            'error',
            'Data laporan tidak ditemukan'
        );
        redirect('laporan_rekam_medis');
        return;
    }

    
    ob_start();

    $data = [
        'laporan'   => $laporan,
        'tgl_awal'  => $tgl_awal,
        'tgl_akhir' => $tgl_akhir
    ];

    $this->load->view('transaksi/rekam_medis/laporan_excel', $data);

    $content = ob_get_clean();

    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Rekam_Medis_{$tgl_awal}_sd_{$tgl_akhir}.xls");

    echo $content;
    exit;
}



public function export_pdf()
{
    $tgl_awal  = $this->input->get('tgl_awal', TRUE);
    $tgl_akhir = $this->input->get('tgl_akhir', TRUE);
    $id_pasien = $this->input->get('id_pasien', TRUE);

    $laporan = $this->rekam->get_laporan($tgl_awal, $tgl_akhir, $id_pasien);

    if (empty($laporan)) {
        $this->session->set_flashdata(
            'error',
            'Data laporan tidak ditemukan'
        );
        redirect('laporan_rekam_medis');
        return;
    }

    
    $pdf = new FPDF('L', 'mm', 'A4'); 
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'LAPORAN REKAM MEDIS PASIEN', 0, 1, 'C');

    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6,
        'Periode: '.date('d/m/Y', strtotime($tgl_awal)).
        ' s/d '.date('d/m/Y', strtotime($tgl_akhir)),
        0, 1, 'C'
    );
    $pdf->Ln(5);

    
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(10, 7, 'No', 1);
    $pdf->Cell(45, 7, 'Nama Pasien', 1);
    $pdf->Cell(45, 7, 'Dokter', 1);
    $pdf->Cell(69, 7, 'Keluhan', 1);
    $pdf->Cell(50, 7, 'Diagnosa', 1);
    $pdf->Cell(69, 7, 'Catatan Medis', 1);
    $pdf->Ln();

    
    $pdf->SetFont('Arial', '', 9);
    $no = 1;
    foreach ($laporan as $r) {
        $pdf->Cell(10, 7, $no++, 1);
        $pdf->Cell(45, 7, $r->nama_pasien, 1);
        $pdf->Cell(45, 7, $r->nama_dokter, 1);
        $pdf->Cell(69, 7, $r->keluhan, 1);
        $pdf->Cell(50, 7, $r->diagnosa, 1);
        $pdf->Cell(69, 7, $r->catatan_medis, 1);
        $pdf->Ln();
    }

    $pdf->Output(
        'I',
        'Laporan_Rekam_Medis_' . date('Ymd') . '.pdf'
    );
    exit;
}

}
