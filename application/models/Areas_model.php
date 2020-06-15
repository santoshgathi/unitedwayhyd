<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_model extends CI_Model {

    public function getAreas()
	{
		$this->db->order_by('area_name', 'ASC');
		$query = $this->db->get('areas');
        $result = $query->result_array();
        return $result;
	}
	
	public function insertAreas($data) {
        $this->db->insert('areas', $data);
	}

	public function update_area($data, $area_id) {
        $this->db->where('area_id', $area_id);
        $this->db->update('areas', $data);
        //echo $this->db->last_query(); 
    }

	public function get_details($area_id) {
        $this->db->where('area_id', $area_id);
        $query = $this->db->get('areas');
        $row = $query->row();
        return $row;
	}
	
	public function dropdown_areas() {  
		$this->db->order_by('area_name', 'ASC');   
		$query = $this->db->get('areas');
		$result = $query->result_array();
		$areas = array();
		foreach($result as $v){
			$areas[$v['area_id']] = $v['area_name'];
		}
		return $areas;
	}

}