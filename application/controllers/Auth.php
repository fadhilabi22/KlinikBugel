<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Memuat library dan model yang dibutuhkan
        $this->load->library(['form_validation', 'session']);
        $this->load->model('m_auth', 'M_Auth');
        $this->load->helper('url');
    }

    // Fungsi Default: Menampilkan Form Login
    public function index()
    {
        // Cek jika sudah login
        if ($this->session->userdata('logged_in') == TRUE) {
            redirect('dashboard');
        }
        // ✅ KUNCI: Memuat file: application/views/auth/login.php
        $this->load->view('auth/login');
    }

    // FUNGSI UTAMA: Proses Login
    public function login_proses()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_message('required', '%s harus diisi.');

        if ($this->form_validation->run() == FALSE) {
            $this->index(); 
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $cek_user = $this->M_Auth->cek_login($username, $password);

            if ($cek_user->num_rows() > 0) {
                // Berhasil Login
                $user_data = $cek_user->row();
                $session_data = array(
                    'id_pengguna'  => $user_data->id_pengguna,
                    'username'     => $user_data->username,
                    'nama_lengkap' => $user_data->nama_lengkap, 
                    'logged_in'    => TRUE
                );
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            } else {
                // Gagal Login
                $this->session->set_flashdata('error', 'Username atau Password salah!');
                redirect('auth');
            }
        }
    }

    // FUNGSI BARU: Menampilkan Form Registrasi
    public function regis() 
    {
        // ✅ Memuat file: application/views/auth/regis.php
        $this->load->view('auth/regis'); 
    }

    // FUNGSI BARU: Proses Registrasi
    public function regis_proses()
    {
        // 1. Definisikan aturan validasi
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[tbl_pengguna.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        
        $this->form_validation->set_message('is_unique', 'Username ini sudah terdaftar.');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form regis()
            $this->regis(); 
        } else {
            $data = [
                'nama_lengkap' => $this->input->post('nama', true),
                'username'     => $this->input->post('username', true),
                'password'     => md5($this->input->post('password', true)),
            ];

            $this->db->insert('tbl_pengguna', $data); 
            
            // CEK ERROR UNTUK CI3 VERSI LAMA
            $error_no = $this->db->_error_number();
            $error = $this->db->_error_message();

            if ($error_no != 0) {
                echo "DB ERROR ($error_no): $error";
                exit;
            } else {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth');
            }
        }
    }
    
    // FUNGSI BARU: Menampilkan Form Reset Password
    public function reset() 
    {
        // ✅ Memuat file: application/views/auth/reset.php
        $this->load->view('auth/reset');
    }

    // FUNGSI BARU: Proses Update Password
    public function update_password()
    {
        // 1. Definisikan aturan validasi
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password_old', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_new', 'Password Baru', 'required|trim|min_length[5]'); 

        $this->form_validation->set_message('required', '%s harus diisi.');
        $this->form_validation->set_message('min_length', '%s minimal 5 karakter.');

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembalikan ke form reset()
            $this->reset(); 
        } else {
            $username = $this->input->post('username', TRUE);
            $password_old = $this->input->post('password_old', TRUE);
            $password_new = $this->input->post('password_new', TRUE);
            
            $cek_lama = $this->M_Auth->cek_login($username, $password_old);

            if ($cek_lama->num_rows() > 0) {
                $data_update = ['password' => md5($password_new)];
                
                $this->db->where('username', $username);
                $this->db->update('tbl_pengguna', $data_update);
                
                $this->session->sess_destroy();
                $this->session->set_flashdata('success', 'Password berhasil diubah! Silakan login kembali.');
                
                redirect('auth'); 
            } else {
                $this->session->set_flashdata('error', 'Username atau Password Lama salah!');
                redirect('auth/reset'); 
            }
        }
    }

    // Fungsi Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth'); 
    }
}