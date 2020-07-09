<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenditures extends MY_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
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

		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'trim|required');
		$this->form_validation->set_rules('donor_name', 'donor name', 'trim|required');
		$this->form_validation->set_rules('area', 'area', 'trim|required');
		$this->form_validation->set_rules('nutrition_hygiene_kit', 'nutrition_hygiene_kit', 'trim|required');
		$this->form_validation->set_rules('meals', 'meals', 'trim|required');
		$this->form_validation->set_rules('medical_equipment', 'medical_equipment', 'trim|required');
		$this->form_validation->set_rules('sanitation_material', 'sanitation_material', 'trim|required');
		$this->form_validation->set_rules('ppe_kits', 'ppe_kits', 'trim|required');
		$this->form_validation->set_rules('amount_spent', 'amount_spent', 'trim|required');
		
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
			   'uwh_admin'=> $this->input->post('admin_cost'),
		   ];		   
		   $message=$this->expenditure_model->insert_entry($data);
		   $this->session->set_flashdata('success', 'Inserted Successfully');
		   redirect('expenditures');
   		}
	}
	
	public function update($expenditure_id) {		
		$this->headerData['page_title'] = 'Update expenditure';
		$this->viewData['donor_name']= $this->donor_model->return_donors();
		$this->viewData['area']=$this->areas_model->dropdown_areas();
		$this->viewData['exp_details'] = $this->expenditure_model->get_details_exp($expenditure_id);
		
		$this->form_validation->set_rules('expenditure_dt', 'Expenditure dt', 'trim|required');
		$this->form_validation->set_rules('donor_id', 'donor', 'trim|required');
		$this->form_validation->set_rules('area_id', 'area', 'trim|required');
		$this->form_validation->set_rules('nutrition_hygiene_kit', 'nutrition_hygiene_kit', 'trim|required');
		$this->form_validation->set_rules('meals', 'donor_id', 'trim|required');
		$this->form_validation->set_rules('medical_equipment', 'medical_equipment', 'trim|required');
		$this->form_validation->set_rules('sanitation_material', 'sanitation_material', 'trim|required');
		$this->form_validation->set_rules('ppe_kits', 'ppe_kits', 'trim|required');
		$this->form_validation->set_rules('amount_spent', 'amount_spent', 'trim|required');
	
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
				'amount_spent' => $this->input->post('amount_spent'),
				'uwh_admin'=> $this->input->post('admin_cost'),
			];
			$this->viewData['exp_details'] = $this->expenditure_model->update_entry($data,$expenditure_id);
			$this->session->set_flashdata('success', 'Updated Successfully');
            redirect('expenditures');
        }
	}

	public function delete($expenditure_id = NULL) {
		$this->headerData['page_title'] = 'Delete Expenditure';
		$this->viewData['exp_details'] = $this->expenditure_model->get_details_exp($expenditure_id);
        $this->form_validation->set_rules('confirm', 'confirm', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            if ('no' == $this->input->post('confirm')) {
                redirect('expenditures');
            }
			$result = $this->expenditure_model->delete_entry($expenditure_id);
			if ($result) {
                $this->session->set_flashdata('success', 'Deleted Successfully');
                redirect('expenditures');
            } else {
                $this->session->set_flashdata('error', 'Error while deleting entry. Try again!');
                redirect('expenditures/delete/'.$expenditure_id);
            }
        }
        // views - header, body, footer
        $this->load->view('header', $this->headerData);
        $this->load->view('expenditures/delete', $this->viewData);
        $this->load->view('footer');
	}
}
