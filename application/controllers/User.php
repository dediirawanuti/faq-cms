<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = 'Data Users';
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/user/index');
        $this->load->view('admin/layout/_footer');
    }

    public function datatables()
    {
        // Load the necessary model
        $this->load->model('User_model');

        // Get the data from the model
        $users = $this->User_model->get_users();

        // Modify the data to set custom IDs
        $modifiedUsers = array_map(function ($user, $index) {
            $user['id'] = $index + 1;
            return $user;
        }, $users, array_keys($users));


        // Prepare the response data in the format expected by DataTables
        $data = array(
            'recordsTotal' => count($users),
            'recordsFiltered' => count($users),
            'data' => $users,
        );

        // Send the JSON response back to DataTables
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function add()
    {
        $data = array(
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'hak_akses' => $this->input->post('hak_akses'),
            'foto_profil' => $this->upload_photo()
        );

        $result = $this->user_model->add_user($data);
        echo json_encode($result);
    }

    public function form_edit($id)
    {
        // Load the necessary model
        $this->load->model('User_model');

        // Get the user data based on the ID
        $user = $this->User_model->get_users($id);

        // Pass the user data to the view
        $data['user'] = $user;

        // Load the view for the form edit page
        $this->load->view('admin/layout/_header', $data);
        $this->load->view('admin/layout/_sidebar');
        $this->load->view('admin/user/form_edit');
        $this->load->view('admin/layout/_footer');
    }

    public function update()
    {
        $data = array(
            'id' => $this->input->post('id'),
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'hak_akses' => $this->input->post('hak_akses'),
            'foto_profil' => $this->upload_photo()
        );

        $result = $this->user_model->update_user($data);
        echo json_encode($result);
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $result = $this->user_model->delete_user($id);
        echo json_encode($result);
    }

    private function upload_photo()
    {
        $config['upload_path'] = './assets/img/profile';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto_profil')) {
            $data = $this->upload->data();
            return $data['file_name'];
        } else {
            return '';
        }
    }
}
