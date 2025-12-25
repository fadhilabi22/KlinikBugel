<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_auth extends CI_Model {
    
    
    public function cek_login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password)); 
        return $this->db->get('tbl_pengguna');
    }

    
    public function is_username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('tbl_pengguna');
        return $query->num_rows() > 0;
    }
    
    
    public function register_user($data) {
        
        return $this->db->insert('tbl_pengguna', $data);
    }

   
    public function update_password($username, $new_hashed_password) {
        $this->db->where('username', $username);
        $this->db->update('tbl_pengguna', ['password' => $new_hashed_password]);
        return $this->db->affected_rows();
    }
}