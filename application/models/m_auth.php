<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_auth extends CI_Model {
    
    // Fungsi untuk memverifikasi login (Sudah Benar)
    public function cek_login($username, $password) {
        // Menggunakan nama tabel: tbl_pengguna
        $this->db->where('username', $username);
        // Penting: Membandingkan dengan MD5
        $this->db->where('password', md5($password)); 
        return $this->db->get('tbl_pengguna');
    }

    // FUNGSI BARU: Untuk mengecek apakah username sudah ada saat registrasi
    public function is_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_pengguna');
        return $query->num_rows() > 0;
    }
    
    // FUNGSI BARU: Untuk menyimpan data registrasi user baru
    public function register_user($data) {
        
        return $this->db->insert('tbl_pengguna', $data);
    }

    // FUNGSI BARU: Untuk update password di tbl_pengguna
    public function update_password($username, $new_hashed_password) {
        $this->db->where('username', $username);
        // Password yang dikirim ke sini HARUS sudah dalam bentuk MD5
        $this->db->update('tbl_pengguna', ['password' => $new_hashed_password]);
        return $this->db->affected_rows();
    }
}