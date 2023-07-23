<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->helper('url');
    }

    public function index()
    {
        // Periksa apakah pengguna sudah login
        if ($this->session->userdata('logged_in')) {
            // Pengguna telah login, lakukan tindakan yang sesuai
            $user_id = $this->session->userdata('user_id');
            // ...
        } else {
            // Pengguna belum login, lakukan tindakan lain
            redirect('auth/login'); // Redirect ke halaman login jika belum login
        }

        $data['title'] = 'Dashboard';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/dashboard');
        $this->load->view('admin/layout/_footer');
    }
}
