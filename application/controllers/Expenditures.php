<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditures extends CI_Controller {

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
		$this->viewData['view_data']= $this->donordb->return_expend();
		$this->headerData['page_title'] = 'List Expenditures';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/index', $this->viewData);
		$this->load->view('footer');
	}

	public function create() {
		$this->load->model('donordb');
		$this->viewData['donor_name']= $this->donordb->return_donors();
		$this->viewData['area']=$this->donordb->return_area();

		$this->headerData['page_title'] = 'Create Expenditure';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/create', $this->viewData);
		$this->load->view('footer');
	}
	public function save(){

		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'required');
		$this->form_validation->set_rules('donor_id', 'donor_id', 'required');
		$this->form_validation->set_rules('area_id', 'area_id', 'required');
		$this->form_validation->set_rules('nutrition_hygiene_kit', 'nutrition_hygiene_kit', 'required');
		$this->form_validation->set_rules('meals', 'donor_id', 'required');
		$this->form_validation->set_rules('medical_equipment', 'medical_equipment', 'required');
		$this->form_validation->set_rules('sanitation_material', 'sanitation_material', 'required');
		$this->form_validation->set_rules('ppe_kits', 'ppe_kits', 'required');
		$this->form_validation->set_rules('amount_spent', 'amount_spent', 'required');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('expenditures/update', $this->viewData);
			$this->load->view('footer');
        } else {
		$date = $this->input->post('date');
		$donor = $this->input->post('donor_name');
		$area=$this->input->post('area');
		$nutriton=$this->input->post('nutrition');
		$meals=$this->input->post('meals');
		$medical=$this->input->post('medical_equipment');
		$amount_spent=$this->input->post('amount_spent');
		$sanitation_material=$this->input->post('sanitation_material');
		$ppe_kits=$this->input->post('ppe_kits');




		
		$data=[
			'donor_id'=>$donor,
			'expenditure_dt'=>$date,
			'area_id'=>$area,
			'nutrition_hygiene_kit'=>$nutriton,
			'meals'=>$meals,
			'medical_equipment'=>$medical,
			'sanitation_material'=>$sanitation_material,
			'ppe_kits'=>$ppe_kits,
			'amount_spent'=>$amount_spent,

		];
		
		$this->load->model('donordb');
		$message=$this->donordb->add('expenditures',$data);
		$this->load->model('donordb');
		$this->viewData['view_data']= $this->donordb->return_expend();



		$this->headerData['page_title'] = 'List Expenditures';
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/index',$this->viewData);

		$this->load->view('footer');
		
	
	
	}
}
	public function update($expenditure_id) {
		
		$this->headerData['page_title'] = 'Update expenditures';
		$this->load->model('donordb');
		$this->viewData['exp_details'] = $this->donordb->get_details_exp($expenditure_id);
		
		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'required');
		$this->form_validation->set_rules('donor_id', 'donor_id', 'required');
		$this->form_validation->set_rules('area_id', 'area_id', 'required');
		$this->form_validation->set_rules('nutrition_hygiene_kit', 'nutrition_hygiene_kit', 'required');
		$this->form_validation->set_rules('meals', 'donor_id', 'required');
		$this->form_validation->set_rules('medical_equipment', 'medical_equipment', 'required');
		$this->form_validation->set_rules('sanitation_material', 'sanitation_material', 'required');
		$this->form_validation->set_rules('ppe_kits', 'ppe_kits', 'required');
		$this->form_validation->set_rules('amount_spent', 'amount_spent', 'required');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('expenditures/update', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
		
			$date = $this->input->post('date');
			$donor = $this->input->post('donor_name');
			$area=$this->input->post('area');
			$nutriton=$this->input->post('nutrition');
			$meals=$this->input->post('meals');
			$medical=$this->input->post('medical_equipment');
			$amount_spent=$this->input->post('amount_spent');
			$sanitation_material=$this->input->post('sanitation_material');
			$ppe_kits=$this->input->post('ppe_kits');

			$data=[
				'donor_id'=>$donor,
				'expenditure_dt'=>$date,
				'area_id'=>$area,
				'nutrition_hygiene_kit'=>$nutriton,
				'meals'=>$meals,
				'medical_equipment'=>$medical,
				'sanitation_material'=>$sanitation_material,
				'ppe_kits'=>$ppe_kits,
				'amount_spent'=>$amount_spent,
	
			];


			$this->viewData['exp_details'] = $this->donordb->update_entry_exp($data,$expenditure_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('expenditures');
        }
	}
}
