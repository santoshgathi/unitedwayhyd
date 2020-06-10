<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class appointments_model extends CI_Model{

    public function add($tb,$values) {     
		$this->db->insert($tb,$values);
		$message='sucessfullr registered';
	    return $message;
	}

    public function return_users() {

		$query=$this->db->query("Select * from appointments");
		//print_r($query);
		// $query->result_array();
		// echo "<pre>";
		// print_r($query->result_array());
		// echo "</pre>";
		return $query->result_array();
		//return ["username"=>"Santosh","company"=>"Gathi"];
	}
	
	public function today_appointments() {   
		$this->db->where('appointment_date', date('Y-m-d'));  
		$query = $this->db->get('appointments');
		//echo $this->db->last_query(); 
		return $query->result();
	}

	public function week_appointments() {
		$week_appointments = [];
		$app_date = date('Y-m-d');
		for ($i=0; $i <= 6; $i++) {
			$this->db->where('appointment_date',$app_date); 
			$this->db->from('appointments'); 
			$count = $this->db->count_all_results();
			//echo $this->db->last_query();
			$this->db->flush_cache();
			//print_r($app_date);
			$week_appointments[$app_date] = $count;
			$next_date = strtotime("1 day", strtotime($app_date));
			$app_date = date("Y-m-d", $next_date);
		}
		return $week_appointments;
	}
}
?>