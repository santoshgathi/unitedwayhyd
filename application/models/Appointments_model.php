<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class appointments_model extends CI_Model{

	public function insert_entry($data) {
        $this->db->insert('appointments', $data);
        //echo $this->db->last_query(); 
	}
	
	public function get_appointments($action = 'rows', $start, $limit, $role) {
        $this->db->select('appointments.*, users.username');
        $this->db->from('appointments');
        $this->db->join('users', 'users.id = appointments.applied_by');
        if($role == "employee") {
            $this->db->where('appointments.applied_by',$this->session->userdata("userId"));
        }
        $this->db->order_by('appointments.created_on', 'DESC');
        if($action == 'rows' || $action == 'export') {
            if($action !== 'export') {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();
            //echo $this->db->last_query(); 
            if($action == 'export') {
                return $query;
            } else {
                return $query->result_array();
            }
        } else if($action == 'count') {
            // $total_count = $this->db->count_all_results();
            // echo $this->db->last_query(); 
            // return $total_count;
            return $this->db->count_all_results();
        }
        return FALSE;        
    }

    public function limit_check($app_date) {
        $this->db->where('appointment_date',$app_date);
        $this->db->where_in('approval_status',array('pending', 'yes'));
		$this->db->from('appointments');
		$count = $this->db->count_all_results();
		return $count;
	}
	
	public function today_appointments() {  
		$this->db->select('appointments.*, users.username');
        $this->db->from('appointments');
        $this->db->join('users', 'users.id = appointments.applied_by'); 
		$this->db->where('appointments.appointment_date', date('Y-m-d'));  
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		return $query->result();
	}

	public function week_appointments() {
		$week_appointments = [];
		$app_date = date('Y-m-d');
		for ($i=0; $i <= 30; $i++) {
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

	public function get_details($id) {
		$this->db->select('appointments.*, users.username');
        $this->db->from('appointments');
        $this->db->join('users', 'users.id = appointments.applied_by');
        $this->db->where('appointments.appointment_id', $id);
        $query = $this->db->get();
        $row = $query->row();
        return $row;
	}	
    
	public function update_entry($data, $appointment_id) {	
        $this->db->where('appointment_id', $appointment_id);
        $this->db->update('appointments', $data);
        //echo $this->db->last_query(); 
	}
}
?>