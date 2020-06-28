<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
	public function get_user($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $row = $query->row();
        return $row;
    }        

	public function insert_entry($data) {
        $this->db->insert('users', $data);
        //echo $this->db->last_query(); 
    }

	public function get_users() 
	{
		$this->db->order_by('username', 'ASC');
		$query = $this->db->get('users');
        $result = $query->result_array();
		return $result;
	}

	public function get_details($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        $row = $query->row();
        return $row;
	}
    
	public function update_entry($data, $id) {		
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        //echo $this->db->last_query(); 
	}
    

}