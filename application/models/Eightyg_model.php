<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eightyg_model extends CI_Model {
    
    public function insert_entry($data) {
        $this->db->insert('80guploads', $data);
        //echo $this->db->last_query(); 
        //return $this->db->insert_id();
    }

    public function update_entry($data, $egithyg_id) {
        $this->db->where('id', $egithyg_id);
        $this->db->update('80guploads', $data);
        //echo $this->db->last_query(); 
        return $this->db->affected_rows();
    }

    public function delete_entry($egithyg_id) {
        $this->db->delete('80guploads', array('id' => $egithyg_id));
        return $this->db->affected_rows();
    }

    public function get_entries($action = 'rows', $start, $limit, $donor = "", $email="", $trns_date = "") {
        $this->db->from('80guploads');
        $this->db->order_by('created_on', 'DESC');
        if($donor != "") {
            $this->db->like('donor_name', $donor);
        }
        if($email != "") {
            $this->db->like('email', $email);
        }
        if($trns_date != "") {
            $this->db->like('trns_date', $trns_date);
        }
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

    public function validate_entry($receipt_no)
    {
        $this->db->from('80guploads');
        $this->db->where('receipt_no', $receipt_no);
        return $this->db->count_all_results();
    }

    public function update_80g_file_status ($egithyg_id, $file_80g) 
    {
        $this->db->where('id', $egithyg_id);
        $this->db->update('80guploads', array('pdf_80g' => $file_80g));
    }

    public function update_80g_email_status ($egithyg_id) 
    {
        $this->db->where('id', $egithyg_id);
        $this->db->update('80guploads', array('sent_email' => 'Yes'));
    }
}