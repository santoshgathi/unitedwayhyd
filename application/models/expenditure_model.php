<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditure_model extends CI_Model{

    public function return_expend() {
        $this->db->select('expenditures.*, donors.donor_name, areas.area_name');
        $this->db->from('expenditures');
        $this->db->join('donors', 'donors.donor_id = expenditures.donor_id');
        $this->db->join('areas', 'areas.area_id = expenditures.area_id');
        $query = $this->db->get();
        return $query->result_array();
	}

    public function insert_entry($data) {
        $this->db->insert('expenditures', $data);
        //echo $this->db->last_query(); 
    }
    
	public function get_details_exp($exp_id) {
        $this->db->where('expenditure_id', $exp_id);
        $query = $this->db->get('expenditures');
        $row = $query->row();
        return $row;
	}
    
	public function update_entry($data, $exp_id) {	
        $this->db->where('expenditure_id', $exp_id);
        $this->db->update('expenditures', $data);
        //echo $this->db->last_query(); 
	} 
}