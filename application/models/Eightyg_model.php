<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg_model extends CI_Model {
    
    public function insert_entry($data) {
        $this->db->insert('80guploads', $data);
        //echo $this->db->last_query(); 
    }

    public function update_entry($data, $egithyg_id) {
        $this->db->where('id', $egithyg_id);
        $this->db->update('80guploads', $data);
        //echo $this->db->last_query(); 
    }

    public function get_entries($slug = FALSE) {
        $query = $this->db->get('80guploads');
        return $query->result_array();
    }

    public function get_details($egithyg_id) {
        $this->db->where('id', $egithyg_id);
        $query = $this->db->get('80guploads');
        $row = $query->row();
        return $row;
    }
}