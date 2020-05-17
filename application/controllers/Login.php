<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() { 
        parent::__construct(); 
    }

	public function index() {
        $this->form_validation->set_rules('username', 'Username', 'required'); 
        $this->form_validation->set_rules('password', 'password', 'required');        
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('login');    
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if($username === "unitedadmin" && $password === "United@1234") {                
                $this->session->set_userdata('isUserLoggedIn', TRUE); 
                $this->session->set_userdata('userId', 'unitedadmin');
                redirect('welcome');
            } else {
                $this->session->set_flashdata('error', 'Invalid Login');
                redirect('login');
            }
        }
    } 
    
    public function logout(){ 
        $this->session->unset_userdata('isUserLoggedIn'); 
        $this->session->unset_userdata('userId'); 
        $this->session->sess_destroy(); 
        redirect('login'); 
    } 
    
}
