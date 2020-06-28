<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() { 
        parent::__construct();
        $this->load->model('user_model');
    }

	public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required'); 
        $this->form_validation->set_rules('password', 'password', 'required');        
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');    
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $result = $this->user_model->get_user($username, $password);
            //print_r($result);exit;
            if($result) {                
                $this->session->set_userdata('loggedin', TRUE); 
                $this->session->set_userdata('user_role', $result->user_role);
                $this->session->set_userdata('username', $result->username);
                $this->session->set_userdata('userId', $result->id);
                redirect('welcome');
            } else {
                $this->session->set_flashdata('error', 'Invalid Login');
                redirect('login');
            }
        }
    } 
    
    public function logout(){ 
        $this->session->unset_userdata('loggedin'); 
        $this->session->unset_userdata('userRole'); 
        $this->session->unset_userdata('userId'); 
        $this->session->sess_destroy(); 
        redirect('login'); 
    } 
    
}
