<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    // untuk get semua data di tabel faq
    public function get_faq()
    {
        $query = $this->db->get('faq');
        return $query->result_array();
    }

    // untuk mendapatkan Kategori_Id di tabel faq 
    public function getByKategori($kategoriId, $keywords)
    {
        $this->db->where('kategori_id', $kategoriId);
        if (!empty($keywords)) {
            $this->db->like('quesion', $keywords);
        }
        $query = $this->db->get('faq');
        return $query->result_array();
    }

    public function insert($data)
    {
        $this->db->insert('faq', $data);
        return $this->db->insert_id();
    }
}
