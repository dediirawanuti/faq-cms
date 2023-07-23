<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('kategori_model');
        $this->load->model('faq_model');
        $this->load->database();
    }
    public function index()
    {
        $data['title'] = 'Faq CMS';
        $data['kategori'] = $this->kategori_model->get_kategori();
        $data['faq'] = $this->faq_model->get_faq();

        $this->load->view('frontend/layout/_header', $data);
        $this->load->view('frontend/index');
        $this->load->view('frontend/layout/_footer');
    }

    public function get_by_kategori()
    {
        $kategoriId = $this->input->post('kategoriId');
        $keywords = $this->input->post('keywords');
        $dataFaq = $this->faq_model->getByKategori($kategoriId, $keywords);
        $response = array('data' => $dataFaq);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
