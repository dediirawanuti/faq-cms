<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->model('kategori_model');
        $this->load->helper('url');
    }

    public function index()
    {
        // Cek apakah pengguna memiliki peran admin
        if ($this->session->userdata('hak_akses') != 'admin') {
            // Pengguna tidak memiliki peran admin, arahkan ke halaman lain atau tampilkan pesan kesalahan
            redirect('home/index');
        }

        $data['title'] = 'Manajemen Kategori';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/kategori/tampil_kategori');
        $this->load->view('admin/layout/_footer');
    }

    public function datatables()
    {
        // Load the necessary model
        $this->load->model('kategori_model');

        // Get the data from the model
        $category = $this->kategori_model->get_users();

        // Modify the data to set custom IDs
        $modifiedCategory = array_map(function ($category, $index) {
            $category['id'] = $index + 1;
            return $category;
        }, $category, array_keys($category));


        // Prepare the response data in the format expected by DataTables
        $data = array(
            'recordsTotal' => count($category),
            'recordsFiltered' => count($category),
            'data' => $category,
        );

        // Send the JSON response back to DataTables
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function create()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|regex_match[/^[^\'&]+$/]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|regex_match[/^[^\'&]+$/]');

        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'message' => validation_errors());
            echo json_encode($response);
        } else {
            $data = array(
                'nama' => $this->input->post('nama'),
                'deskripsi' => $this->input->post('deskripsi'),
                'created_at' => date('Y-m-d H:i:s')
            );

            $insert = $this->kategori_model->insert_kategori($data);

            if ($insert) {
                $response = array('status' => true, 'message' => 'Kategori berhasil ditambahkan');
            } else {
                $response = array('status' => false, 'message' => 'Terjadi kesalahan saat menambahkan kategori');
            }

            echo json_encode($response);
        }
    }

    public function update()
    {
        $this->form_validation->set_rules('id', 'ID', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required|regex_match[/^[^\'&]+$/]');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|regex_match[/^[^\'&]+$/]');

        if ($this->form_validation->run() == FALSE) {
            $response = array('status' => false, 'message' => validation_errors());
            echo json_encode($response);
        } else {
            $id = $this->input->post('id');
            $data = array(
                'nama' => $this->input->post('nama'),
                'deskripsi' => $this->input->post('deskripsi'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $update = $this->kategori_model->update_kategori($id, $data);

            if ($update) {
                $response = array('status' => true, 'message' => 'Kategori berhasil diperbarui');
            } else {
                $response = array('status' => false, 'message' => 'Terjadi kesalahan saat memperbarui kategori');
            }

            echo json_encode($response);
        }
    }

    public function delete($id)
    {
        $delete = $this->kategori_model->delete_kategori($id);

        if ($delete) {
            $response = array('status' => true, 'message' => 'Kategori berhasil dihapus');
        } else {
            $response = array('status' => false, 'message' => 'Terjadi kesalahan saat menghapus kategori');
        }

        echo json_encode($response);
    }
}
