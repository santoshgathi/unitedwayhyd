<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg_model extends CI_Model {
    
    public function insert_entry($data) {
        $this->db->insert('80guploads', $data);
        //echo $this->db->last_query(); 
    }

    public function get_entries($slug = FALSE) {
        $query = $this->db->get('80guploads');
        return $query->result_array();
    }

}

class Eightyg_model extends CI_Model {
	
    public function getAreas()
	{
		$this->load->database();
		$res = $this->db->query("SELECT * FROM  areas");
		return $res->result_array();
	}
	
	public function insertAreas()
	{
	
	}
}