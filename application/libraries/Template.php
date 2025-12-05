<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {

    protected $CI;
    protected $data = [];

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Set variable yang ingin dikirim ke template
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * Load template utama + view konten
     */
    public function load($template = '', $view = '', $view_data = [], $return = FALSE)
    {
        // Merge data yg dikirim controller + data template
        $data = array_merge($this->data, $view_data);

        // Render konten halaman ke dalam $contents
        $data['contents'] = $this->CI->load->view($view, $data, TRUE);

        // Pastikan flashdata selalu ikut
        $data['success'] = $this->CI->session->flashdata('success');
        $data['error']   = $this->CI->session->flashdata('error');

        // Load template utama
        return $this->CI->load->view($template, $data, $return);
    }
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
