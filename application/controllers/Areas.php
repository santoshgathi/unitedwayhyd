<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller {

	private $headerData = array('page_title'=>'');

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
		}
		$this->load->model('areas_model');
    } 
	
	public function index() {
		$data['areas'] = $this->areas_model->getAreas();
		$this->headerData['page_title'] = 'List Areas';
		$this->load->view('header', $this->headerData);
		$this->load->view('areas/index', $data);
		$this->load->view('footer');
	}

	public function create() {
		$this->headerData['page_title'] = 'Create Area';
		$this->form_validation->set_rules('newArea', 'Area Name', 'required');      
        
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $this->headerData);
			$this->load->view('areas/create');
			$this->load->view('footer');
        } else {
			$data['area_name'] = $this->input->post("newArea");
			$this->areas_model->insertAreas($data);
			$this->session->set_flashdata('success', 'Inserted Successfully');
            redirect('areas');
        }
	}
}
