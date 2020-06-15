<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditures extends MY_Controller {

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
		$this->load->model('expenditure_model');
		$this->load->model('areas_model');
    } 
	
	public function index() {
		$this->headerData['page_title'] = 'List Expenditures';
		$this->load->library('pagination');
		$this->viewData['size'] = $size = $this->input->get('size') ? $this->input->get('size') : 10;
		$page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;
		$config = $this->pagination_config_array('/index.php/expenditures/index/', $size);
		$config['total_rows'] = $this->expenditure_model->get_expenditures('count', 0, 0);
		$this->viewData['view_data']= $this->expenditure_model->get_expenditures('rows', $page, $config['per_page']);
		$this->pagination->initialize($config);
		$this->viewData['paginationSummary']  = $this->pagination_summary($page, $config['per_page'], $config['total_rows']);
		$this->load->view('header', $this->headerData);
		$this->load->view('expenditures/index', $this->viewData);
		$this->load->view('footer');
	}

	public function create() {
		$this->headerData['page_title'] = 'Create Expenditure';
		$this->viewData['donor_name']= $this->donor_model->return_donors();
		$this->viewData['area']=$this->areas_model->dropdown_areas();

		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'required');
		$this->form_validation->set_rules('donor_name', 'donor name', 'required');
		$this->form_validation->set_rules('area', 'area', 'required');
		$this->form_validation->set_rules('nutrition_hygiene_kit', 'nutrition_hygiene_kit', 'required');
		$this->form_validation->set_rules('meals', 'meals', 'required');
		$this->form_validation->set_rules('medical_equipment', 'medical_equipment', 'required');
		$this->form_validation->set_rules('sanitation_material', 'sanitation_material', 'required');
		$this->form_validation->set_rules('ppe_kits', 'ppe_kits', 'required');
		$this->form_validation->set_rules('amount_spent', 'amount_spent', 'required');
		
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('header', $this->headerData);
			$this->load->view('expenditures/create', $this->viewData);
			$this->load->view('footer');
	   } else {
		   $data=[
			   'donor_id' => $this->input->post('donor_name'),
			   'expenditure_dt' =>  $this->input->post('expenditure_dt'),
			   'area_id' => $this->input->post('area'),
			   'nutrition_hygiene_kit'=> $this->input->post('nutrition_hygiene_kit'),
			   'meals'=> $this->input->post('meals'),
			   'medical_equipment'=> $this->input->post('medical_equipment'),
			   'sanitation_material'=> $this->input->post('sanitation_material'),
			   'ppe_kits'=> $this->input->post('ppe_kits'),
			   'amount_spent'=> $this->input->post('amount_spent'),
		   ];		   
		   $message=$this->expenditure_model->insert_entry($data);
		   $this->session->set_flashdata('success', 'Inserted Successfully');
		   redirect('expenditures');
   		}
	}
	
	public function update($expenditure_id) {
		
		$this->headerData['page_title'] = 'Update expenditures';
		$this->viewData['donor_name']= $this->donor_model->return_donors();
		$this->viewData['area']=$this->areas_model->dropdown_areas();
		$this->viewData['exp_details'] = $this->expenditure_model->get_details_exp($expenditure_id);
		
		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'required');
		$this->form_validation->set_rules('donor_id', 'donor', 'required');
		$this->form_validation->set_rules('area_id', 'area', 'required');
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
			$data = [
				'donor_id' => $this->input->post('donor_id'),
				'expenditure_dt' => $this->input->post('expenditure_dt'),
				'area_id' => $this->input->post('area_id'),
				'nutrition_hygiene_kit ' => $this->input->post('nutrition_hygiene_kit'),
				'meals' => $this->input->post('meals'),
				'medical_equipment' => $this->input->post('medical_equipment'),
				'sanitation_material' => $this->input->post('sanitation_material'),
				'ppe_kits' => $this->input->post('ppe_kits'),
				'amount_spent' => $this->input->post('amount_spent')	
			];
			$this->viewData['exp_details'] = $this->expenditure_model->update_entry($data,$expenditure_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('expenditures');
        }
	}
}
