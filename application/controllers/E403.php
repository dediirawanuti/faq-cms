<?php
defined('BASEPATH') or exit('No direct script access allowed');

class E403 extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Page 404 Not Found';
        $this->load->helper('url');

        $this->load->view("frontend/layout/_header", $data);
        $this->load->view("frontend/e403");
        $this->load->view("frontend/layout/_footer");
    }
}
