<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_model extends CI_Model {

    public function getAreas()
	{
		$this->load->database();
		$res = $this->db->query("SELECT * FROM  areas");
		return $res->result_array();
	}
	
	public function insertAreas($data) {
        $this->db->insert('areas', $data);
	}
    public function get_areas($data) {
        $this->db->where($data, $data);
        $query = $this->db->get('areas');
        $row = $query->row();
        return $row;
	}
	public function update_area($area,$data) {
        $this->db->where($data, $data);
        $this->db->update('areas', $area);
	}

}