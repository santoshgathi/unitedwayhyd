<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donor_model extends CI_Model{

    public function add($tb,$values) {     
		$this->db->insert($tb,$values);
		$message='sucessfullr registered';
	    return $message;
	}

	public function get_donors() 
	{
		$this->db->order_by('donor_name', 'ASC');
		$query = $this->db->get('donors');
        $result = $query->result_array();
		return $result;
	}
	
	
    
	public function return_donors() {  
		$this->db->order_by('donor_name', 'ASC');   
		$query = $this->db->get('donors');
		$result = $query->result_array();
		$donors = array();
		foreach($result as $v){
			$donors[$v['donor_id']] = $v['donor_name'];
		}
		return $donors;
		
		// $data1=$this->db->query("Select donor_id,donor_name from donors")->result_array();
		// $x=array();
		// $x1=0;
		// foreach($data1 as $i){
		// 	$x[$i['donor_id']]=$i['donor_name'];
		// }
		// return $x;
	}
    
	public function return_expend() {        
		$query=$this->db->query("Select * from expenditures");		
		return $query->result_array();
	}

	public function get_details($donor_id) {
        $this->db->where('donor_id', $donor_id);
        $query = $this->db->get('donors');
        $row = $query->row();
        return $row;
	}
    
	public function update_entry($data, $donor_id) {
		
        $this->db->where('donor_id', $donor_id);
        $this->db->update('donors', $data);
        //echo $this->db->last_query(); 
	}
    
	public function get_details_exp($exp_id) {
        
        $this->db->where('expenditure_id', $exp_id);
        $query = $this->db->get('expenditures');
        $row = $query->row();
        return $row;
	}
    
	public function update_entry_exp($data, $exp_id) {
	
        $this->db->where('expenditure_id', $exp_id);
        $this->db->update('expenditures', $data);
        //echo $this->db->last_query(); 
	}

	public function total_donors () {
		$this->db->from('donors');
        return $this->db->count_all_results();
	}
}