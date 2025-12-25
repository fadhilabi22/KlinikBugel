<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemeriksaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        
        // Memuat Model-model yang diperlukan
        $this->load->model('transaksi/m_pemeriksaan', 'M_Pemeriksaan');
        $this->load->model('transaksi/m_pendaftaran', 'M_Pendaftaran'); 
        $this->load->model('master/m_obat', 'M_Obat'); 
        $this->load->model('transaksi/m_tindakan', 'M_Tindakan');
        
        $this->load->library('form_validation');
        $this->load->helper('url');
        // chek_session(); 
    }

    
    public function index() {
        $data = [
            'title'             => 'Daftar Pasien Siap Diperiksa',
            'contents'          => 'transaksi/pemeriksaan/daftar_pasien_dokter', 
            'antrian_dokter'    => $this->M_Pemeriksaan->get_pasien_siap_diperiksa() 
        ];
        $this->template->load('template', $data['contents'], $data);
    }


    
    public function input_vitalsign($id_kunjungan) {
        $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($id_kunjungan);

        if (!$kunjungan || $kunjungan->status_kunjungan != 'Diperiksa') { 
             $this->session->set_flashdata('error', 'Kunjungan tidak valid atau status bukan untuk Tanda Vital.');
             redirect('transaksi/pendaftaran');
        }

        $data = [
            'title'         => 'Input Tanda-Tanda Vital',
            'contents'      => 'transaksi/pendaftaran/form_vital_sign', 
            'kunjungan'     => $kunjungan, 
            'id_kunjungan'  => $id_kunjungan
        ];
        $this->template->load('template', $data['contents'], $data);
    }
    
    
    public function simpan_vital_sign() {
        $id_kunjungan = $this->input->post('id_kunjungan', TRUE);
        
        $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($id_kunjungan); 

        if (!$kunjungan) {
             $this->session->set_flashdata('error', 'Kunjungan tidak ditemukan. Transaksi dibatalkan.');
             redirect('transaksi/pendaftaran');
             return; 
        }
        
       
        $this->form_validation->set_rules('tensi', 'Tekanan Darah', 'required');
        $this->form_validation->set_rules('suhu', 'Suhu Tubuh', 'required|numeric');
        $this->form_validation->set_rules('keluhan', 'Keluhan Utama', 'required');
        $this->form_validation->set_rules('bb', 'Berat Badan', 'required|numeric');
        
        if ($this->form_validation->run() == FALSE) {
            $this->input_vitalsign($id_kunjungan);
        } else {
            
            $data_rm = [
                'id_kunjungan' => $id_kunjungan,
                'id_dokter' => $kunjungan->id_dokter, 
                'keluhan' => $this->input->post('keluhan', TRUE),
                'catatan_medis' => 
                    'Tensi: ' . $this->input->post('tensi', TRUE) . ' mmHg | ' .
                    'Suhu: ' . $this->input->post('suhu', TRUE) . ' °C | ' .
                    'BB: ' . $this->input->post('bb', TRUE) . ' kg',
                'tgl_pemeriksaan' => date('Y-m-d H:i:s'), 
                'diagnosa' => NULL, 
            ];

            $id_rekam_medis = $this->M_Pemeriksaan->save_rekam_medis($data_rm); 
            
            if ($id_rekam_medis) {
                $this->M_Pendaftaran->update_status($id_kunjungan, 'Vital Sign OK');
                $this->session->set_flashdata('success', 'Tanda Vital dicatat. Pasien siap diperiksa dokter!');
                redirect('transaksi/pemeriksaan'); 
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan Tanda Vital. Cek Foreign Key atau kolom Wajib Isi (NOT NULL).');
                redirect('transaksi/pendaftaran');
            }
        }
    }
    
    
    public function input_diagnosis($id_rekam_medis) {
        $rekam_medis = $this->M_Pemeriksaan->get_by_id($id_rekam_medis);
        
        if (!$rekam_medis) {
            $this->session->set_flashdata('error', 'Data Rekam Medis tidak ditemukan atau sudah selesai.');
            redirect('transaksi/pemeriksaan');
            return;
        }

        $kunjungan = $this->M_Pemeriksaan->get_kunjungan_by_id($rekam_medis->id_kunjungan);
        
        if (!$kunjungan) {
            $this->session->set_flashdata('error', 'Data Kunjungan terkait Rekam Medis tidak ditemukan.');
            redirect('transaksi/pemeriksaan');
            return;
        }
        
        $data = [
            'title'             => 'Pemeriksaan & Diagnosis Final',
            'contents'          => 'transaksi/pemeriksaan/form_rekam_medis',
            'rekam_medis'       => $rekam_medis, 
            'kunjungan'         => $kunjungan, 
            'list_obat'         => $this->M_Obat->get_all(), 
            'list_tindakan'     => $this->M_Tindakan->get_all_tindakan(),
        ];
        
        $this->template->load('template', $data['contents'], $data);
    }
    
    
    public function simpan_diagnosis_final() {
    
        
        $id_rekam_medis = $this->input->post('id_rekam_medis', TRUE);
        $id_kunjungan = $this->input->post('id_kunjungan', TRUE); 

       
        $data_rm_update = [
            'diagnosa'          => $this->input->post('diagnosa', TRUE),
            'catatan_medis'     => $this->input->post('anamnesis', TRUE), 
            'tgl_pemeriksaan'   => date('Y-m-d H:i:s'), 
        ];

        
        $id_obat_arr        = $this->input->post('id_obat');
        $jumlah_arr         = $this->input->post('jumlah');
        $aturan_pakai_arr   = $this->input->post('aturan_pakai');
        
        $data_resep_obat = [];
        
        
        if (!empty($jumlah_arr) && is_array($jumlah_arr)) {
            foreach ($jumlah_arr as $key => $jumlah) {
                
                
                if (!isset($id_obat_arr[$key]) || !isset($aturan_pakai_arr[$key])) {
                    continue; 
                }
                
                $jumlah_resep = (int)$jumlah;

                $data_resep_obat[] = [
                    'id_rm'          => $id_rekam_medis, 
                    'id_obat'        => $id_obat_arr[$key], 
                    'jumlah'         => $jumlah_resep, 
                    'aturan_pakai'   => $aturan_pakai_arr[$key], 
                ];
            } 
        } 

        
        $id_tindakan_arr = $this->input->post('id_tindakan');
       
        $data_tindakan = [];
        if (!empty($id_tindakan_arr)) {
            foreach ($id_tindakan_arr as $key => $id_tindakan) {
                $data_tindakan[] = [
                    'id_rm'         => $id_rekam_medis, 
                    'id_tindakan'   => $id_tindakan, 
                    'jumlah'        => 1 
                ];
            }
        }

        
        
        $this->db->trans_start(); 
        
        
        $this->M_Pemeriksaan->update_rekam_medis($id_rekam_medis, $data_rm_update);
        
        
        if (!empty($data_tindakan)) {
            
            
            
            $this->session->set_flashdata('data_tindakan', $data_tindakan);
        }
        
        
        if (!empty($data_resep_obat)) {
            $stok_berhasil = $this->M_Pemeriksaan->save_resep_dan_kurangi_stok($id_rekam_medis, $data_resep_obat);
            
            if ($stok_berhasil === FALSE) {
                $this->db->trans_rollback(); 
                $this->session->set_flashdata('error', 'Gagal menyimpan resep atau stok obat. Transaksi dibatalkan.');
                redirect('transaksi/pemeriksaan');
                return;
            }
        }
        
        
        if ($id_kunjungan) {
            $this->M_Pendaftaran->update_status($id_kunjungan, 'Menunggu Pembayaran');
        }
        
        $this->db->trans_complete(); 

        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Kesalahan Database saat memfinalisasi pemeriksaan. Cek log error.');
        } else {
            
            $this->session->set_flashdata('success', 'Pemeriksaan selesai. Resep dicatat dan stok obat disesuaikan. Pasien diarahkan ke Kasir.');
        }

        redirect('transaksi/pemeriksaan');
    }
}