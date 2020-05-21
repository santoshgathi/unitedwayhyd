<?php 
class Donordb extends CI_Model{
    public function add($tb,$values){
     
     
		$this->db->insert($tb,$values);
		$message='sucessfullr registered';
	return $message;

    }
    function return_users(){
		$this->load->database();

		$query=$this->db->query("Select * from donors");
		//print_r($query);
		// $query->result_array();
		// echo "<pre>";
		// print_r($query->result_array());
		// echo "</pre>";
		return $query->result_array();
		//return ["username"=>"Santosh","company"=>"Gathi"];
	}
	function return_donors(){
		$this->load->database();
		$data1=$this->db->query("Select donor_id,donor_name from donors")->result_array();
		$x=array();
		$x1=0;
		foreach($data1 as $i){
			$x[$i['donor_id']]=$i['donor_name'];
		}
		return $x;

	}
	function return_area(){
		$this->load->database();
		$data1=$this->db->query("Select area_id,area_name from areas")->result_array();
		$x=array();
		$x1=0;
		foreach($data1 as $i){
			$x[$i['area_id']]=$i['area_name'];
		}
		return $x;

	} 
	function return_expend(){

		$this->load->database();

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
}