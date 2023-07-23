<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'Login Panel';

        $this->load->view('frontend/layout/_header', $data);
        $this->load->view('auth/login');
        $this->load->view('frontend/layout/_footer');
    }

    public function form_registrasi()
    {
        $data['title'] = 'Registrasi';

        $this->load->view('frontend/layout/_header', $data);
        $this->load->view('auth/registrasi');
        $this->load->view('frontend/layout/_footer');
    }

    public function register()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->library('form_validation');
            $this->load->model('user_model');

            $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE) {
                $msg = array(
                    'error' => array(
                        'username' => form_error('username'),
                        'email' => form_error('email'),
                        'password' => form_error('password')
                    )
                );
            } else {
                $data = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
                );

                $user_id = $this->user_model->create_user($data);

                if ($user_id) {
                    $msg = array(
                        'status' => 200,
                        'message' => 'Registrasi berhasil! Silakan masuk menggunakan akun baru Anda.',
                    );
                } else {
                    $msg = array(
                        'status' => 500,
                        'message' => 'Gagal menyimpan pengguna. Silakan coba lagi.'
                    );
                }
            }

            echo json_encode($msg);
        }
    }

    public function login()
    {
        if ($this->input->is_ajax_request()) {
            $email_username = $this->input->post('email_username');
            $password = $this->input->post('password');

            $data = $this->user_model->get_user_by_username_or_email($email_username);

            if ($data) {
                $pass = $data->password;
                $verify_pass = password_verify($password, $pass);

                if ($verify_pass) {
                    $session_data = array(
                        'id'       => $data->id,
                        'email'    => $data->email,
                        'nama'     => $data->nama,
                        'foto'     => $data->foto,
                        'hak_akses' => $data->hak_akses,
                        'logged_in' => TRUE
                    );
                    $this->session->set_userdata($session_data);

                    $response = array(
                        'status' => 200,
                        'message' => 'Berhasil login!',
                        'redirect' => ($data->hak_akses == 'admin') ? site_url('admin') : site_url()
                    );
                } else {
                    $response = array(
                        'status' => 401,
                        'message' => 'Password Anda salah!'
                    );
                }
            } else {
                $response = array(
                    'status' => 401,
                    'message' => 'Email atau username tidak ditemukan!'
                );
            }

            echo json_encode($response);
        }
    }


    public function logout()
    {
        // Hapus semua data pengguna dari session
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role');

        // Redirect ke halaman login
        redirect('auth/login');
    }
}
