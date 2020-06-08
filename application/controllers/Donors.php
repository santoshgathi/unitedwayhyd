<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Donors extends CI_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();         
        // User login status 
		$isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
		if(!$isUserLoggedIn) { 
            redirect('login'); 
		} 
		$this->load->model('donor_model');
    } 
	
	public function index() {
		
		$this->viewData['view_data']=$this->donor_model->return_users();
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index', $this->viewData);
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create Donor';		
		$this->form_validation->set_rules('Donorname', 'Donorname', 'required|is_unique[donors.donor_name]'); 
        $this->form_validation->set_rules('Pho', 'Phone number', 'required');     
		if ($this->form_validation->run() === FALSE) {			
			$this->load->view('header', $this->headerData);
			$this->load->view('donors/create', $this->viewData);
			$this->load->view('footer');
        } else {
			
			$data=[
				'donor_name'=> $this->input->post('Donorname'),
				'donor_phone'=> $this->input->post('Pho'),
				'email' => $this->input->post('email'),
				'address' => $this->input->post('address')
			];			
			$message=$this->donor_model->add('donors',$data);
			redirect('donors');
		}
	}
	
	public function update($donor_id) {
		
		$this->headerData['page_title'] = 'Update Donors';
		$this->viewData['donor_details'] = $this->donor_model->get_details($donor_id);
		
		$this->form_validation->set_rules('donor_name', 'Donor_name', 'required');
		$this->form_validation->set_rules('phone_number', 'Phone_number', 'required');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('donors/update', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
		
			$data['donor_name'] = $this->input->post('donor_name');
			$data['donor_phone'] = $this->input->post('phone_number');
			$this->viewData['donor_details'] = $this->donor_model->update_entry($data,$donor_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('donors');
        }
	}


}
