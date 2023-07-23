<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_model extends CI_Model
{

    public function get_kategori()
    {
        $query = $this->db->get('category');

        // Return the result as an array
        return $query->result_array();
    }

    public function insert_kategori($data)
    {
        return $this->db->insert('category', $data);
    }

    public function delete_kategori($id)
    {
        return $this->db->delete('category', array('id' => $id));
    }

    public function update_kategori($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('category', $data);
    }
}
