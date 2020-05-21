<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditure_model extends CI_Model{

    public function return_expend(){
        $query = $this->db->get('expenditures');
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