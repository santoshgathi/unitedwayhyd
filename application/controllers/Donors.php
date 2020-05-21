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
    } 
	
	public function index() {
		
		$this->load->model('donordb');
		
		$this->viewData['view_data']=$this->donordb->return_users();
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index', $this->viewData);
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create Donor';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/create', $this->viewData);
		$this->load->view('footer');
	}
	public function save(){
		$this->form_validation->set_rules('Donorname', 'Donorname', 'required'); 
        $this->form_validation->set_rules('Pho', 'Phone number', 'required');        
        
        if ($this->form_validation->run() === FALSE) {
			$this->headerData['page_title'] = 'Create Donor';
			$this->load->view('header', $this->headerData);
			$this->load->view('donors/create',$this->viewData); 
			$this->load->view('footer');   
        } else {
		$donorname = $this->input->post('Donorname');
		$pho = $this->input->post('Pho');
		$ph1=$pho;

		$data=[
			'donor_name'=>$donorname,
			'donor_phone'=>$pho
		];
		
		$this->load->model('donordb');
		$message=$this->donordb->add('donors',$data);
		
		$this->viewData['view_data']=$this->donordb->return_users();
		
		
		$this->headerData['page_title'] = 'List Donors';
		$this->load->view('header', $this->headerData);
		$this->load->view('donors/index',$this->viewData);
		$this->load->view('footer');
		}
	}
	public function update($donor_id) {
		
		$this->headerData['page_title'] = 'Update Donors';
		$this->load->model('donordb');
		$this->viewData['donor_details'] = $this->donordb->get_details($donor_id);
		
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
			$this->viewData['donor_details'] = $this->donordb->update_entry($data,$donor_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('donors');
        }
	}


}
