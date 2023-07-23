<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('faq_model');
        $this->load->model('kategori_model');
    }

    public function index()
    {
        // Cek apakah pengguna memiliki peran admin
        if ($this->session->userdata('hak_akses') != 'admin') {
            // Pengguna tidak memiliki peran admin, arahkan ke halaman lain atau tampilkan pesan kesalahan
            redirect('home/index');
        }

        $data['title'] = 'Manajemen Faq';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/faq/index');
        $this->load->view('admin/layout/_footer');
    }

    public function datatables()
    {
        // Get the data from the model
        $faqs = $this->faq_model->get_faq();

        // Modify the data to set custom IDs
        $modifiedFaq = array_map(function ($faq, $index) {
            $faq['id'] = $index + 1;
            return $faq;
        }, $faqs, array_keys($faqs));


        // Prepare the response data in the format expected by DataTables
        $data = array(
            'recordsTotal' => count($faqs),
            'recordsFiltered' => count($faqs),
            'data' => $faqs,
        );

        // Send the JSON response back to DataTables
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function form_add()
    {
        $data['kategori'] = $this->kategori_model->get_kategori();

        $data['title'] = 'Tambah Faq';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/faq/form_add');
        $this->load->view('admin/layout/_footer');
    }

    public function store()
    {
        $quesion = $this->input->post('quesion');
        $answer = $this->input->post('answer');
        $kategori_id = $this->input->post('kategori_id');
        $authors = $this->input->post('authors');
        $status = $this->input->post('status');
        $keyword = $this->input->post('keyword');
        $search_key = $this->input->post('search_key');

        $data = array(
            'quesion' => $quesion,
            'answer' => $answer,
            'kategori_id' => $kategori_id,
            'authors' => $authors,
            'status' => $status,
            'keyword' => $keyword,
            'search_key' => $search_key,
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->faq_model->insert($data);

        $response = array('success' => true);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function form_edit()
    {
        $data['kategori'] = $this->kategori_model->get_kategori();

        $data['title'] = 'Edit Faq';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/faq/form_edit');
        $this->load->view('admin/layout/_footer');
    }

    public function edit()
    {
    }

    public function delete()
    {
    }
}
