<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    public function get_user_by_username_or_email($email_username)
    {
        $this->db->where('username', $email_username);
        $this->db->or_where('email', $email_username);
        return $this->db->get('users')->row();
    }

    public function getUser()
    {
        $this->db->order_by('nama', 'ASC');
        return $this->db->from('users')
            ->get()
            ->result();
    }

    public function update_user_lasted_login($id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array('lasted_login' => date('Y-m-d H:i:s')));
    }

    public function insert($data)
    {
        $this->db->insert('users', $data);
    }

    public function create_user($data)
    {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function check_username_exists($username)
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    public function check_email_exists($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    public function get_users()
    {
        // Query to retrieve the users from the database
        $query = $this->db->get('users');

        // Return the result as an array
        return $query->result_array();
    }

    public function add_user($data)
    {
        $this->db->insert('users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function update_user($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
        return ($this->db->affected_rows() != 1) ? false : true;
    }
}
