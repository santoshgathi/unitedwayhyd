<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg_model extends CI_Model {
    
    public function insert_entry($data) {
        $this->db->insert('80guploads', $data);
        //echo $this->db->last_query(); 
    }

    public function update_entry($data, $egithyg_id) {
        $this->db->where('id', $egithyg_id);
        $this->db->update('80guploads', $data);
        //echo $this->db->last_query(); 
    }

    public function get_entries($action = 'rows', $start, $limit) {
        $this->db->from('80guploads');
        if($action == 'rows' || $action == 'export') {
            if($action !== 'export') {
                $this->db->limit($limit, $start);
            }
            $query = $this->db->get();
            //echo $this->db->last_query(); 
            if($action == 'export') {
                return $query;
            } else {
                return $query->result();
            }
        } else if($action == 'count') {
            // $total_count = $this->db->count_all_results();
            // echo $this->db->last_query(); 
            // return $total_count;
            return $this->db->count_all_results();
        }
        return FALSE;        
    }

    public function get_details($egithyg_id) {
        $this->db->where('id', $egithyg_id);
        $query = $this->db->get('80guploads');
        $row = $query->row();
        return $row;
    }

    public function validate_entry($receipt_no) {
        $this->db->from('80guploads');
        $this->db->where('receipt_no', $receipt_no);
        return $this->db->count_all_results();;
    }
}