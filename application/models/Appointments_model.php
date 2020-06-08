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
}
?>