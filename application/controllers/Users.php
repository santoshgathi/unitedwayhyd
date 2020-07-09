<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	private $headerData = array('page_title'=>'');
	private $viewData=array('view_data'=>'');

	function __construct() { 
        parent::__construct();
		$this->viewData['user_role'] = $this->session->userdata("user_role");
		$this->headerData['menus'] = $this->user_menu($this->viewData['user_role']);
		$this->load->model('user_model');
    } 
	
	public function index() {
		
		$this->viewData['view_data']=$this->user_model->get_users();
		$this->headerData['page_title'] = 'List Users';
		$this->load->view('header', $this->headerData);
		$this->load->view('users/index', $this->viewData);
		$this->load->view('footer');
    }
    
    public function create() {
		$this->headerData['page_title'] = 'Create User';		
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]|max_length[25]|is_unique[users.username]'); 
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]|max_length[50]');
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|is_unique[users.full_name]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		if ($this->form_validation->run() === FALSE) {			
			$this->load->view('header', $this->headerData);
			$this->load->view('users/create', $this->viewData);
			$this->load->view('footer');
        } else {			
			$data=[
				'username'=> $this->input->post('username'),
				'password'=> $this->input->post('password'),
				'full_name' => $this->input->post('full_name'),
				'email' => $this->input->post('email'),
				'user_role' => $this->input->post('user_role'),
				'status' => '1',
				'created_on' => date('Y-m-d H:i:s'),
			];			
			$this->user_model->insert_entry($data);
			redirect('users');
		}
	}
	
	public function update($user_id) {
		
		$this->headerData['page_title'] = 'Update User';
		$this->viewData['user_details'] = $this->user_model->get_details($user_id);		
		$this->form_validation->set_rules('full_name', 'Full Name', 'required|unique_exclude[users,full_name,id,'.$user_id.']');
		$this->form_validation->set_rules('status', 'Status', 'required');
	
		if ($this->form_validation->run() === FALSE) {
         	$this->load->view('header', $this->headerData);
			$this->load->view('users/update', $this->viewData);
			$this->load->view('footer');
        } else {
			// form submit
			// db save -- list page redirect 
			$data=[
				'full_name'=> $this->input->post('full_name'),
				'email' => $this->input->post('email'),
				'status'=> $this->input->post('status')
			];
            $result = $this->user_model->update_entry($data,$user_id);
            if ($result) {
                $this->session->set_flashdata('success', 'Updated Successfully');
                redirect('users');
            } else {
                $this->session->set_flashdata('error', 'Error while updating entry. Try again!');
                redirect('users/update/'.$user_id);
            }
        }
	}

	public function updateuserpwd($user_id = NULL) {
        $this->headerData['page_title'] = 'Update User Password';
        // $this->viewHeaderData['breadcrumbs'] = array(
        //     'admin' => array(anchor('user/subadmins', 'Sub Admins', ''), 'Update Password')
        // );
        $this->viewData['user_details'] = $this->user_model->get_details($user_id);
        $this->form_validation->set_rules('newpwd', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            
        } else {
            $data = array(
                'password' => $this->input->post("newpwd"),
            );
            $result = $this->user_model->update_entry($data,$user_id);
			if ($result) {
                $this->session->set_flashdata('success', 'Updated Successfully');
                redirect('users');
            } else {
                $this->session->set_flashdata('error', 'Error while updating entry. Try again!');
                redirect('users/updateuserpwd/'.$user_id);
            }
        }
        // views - header, body, footer
        $this->load->view('header', $this->headerData);
        $this->load->view('users/updateuserpwd', $this->viewData);
        $this->load->view('footer');
	}
	
	function updatemypwd() {
        // $this->_data['companyId'] = $companyId = decrypt($companyId);
        // $this->_breadcrumb['breadcrumb'] = array("adm/welcome" => "Home", "adm/company" => "Company", "adm/company/details/" . encrypt($companyId) => "Details", "#" => "Change Password");
        $this->headerData['page_title'] = 'Update My Password';
        $this->form_validation->set_rules('oldpassword', 'Current Password', 'trim|required|min_length[6]|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]|matches[confirmpassword]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|min_length[6]|max_length[50]');

        $footerData['jqueryJavaScript'] = '
                          $("#companyform").validate({
					rules: {
						password :{required:true,minlength:3,maxlength:30},
                                                confirmpassword :{required:true,minlength:3,maxlength:30},
					       },
					messages: {
						password  : {required:"Please enter Password",minlength:"Password should have minimum 3 characters",maxlength:"Password should have Maximum 30 characters"},
                                                confirmpassword  : {required:"Please enter Confirm Password",minlength:"Confirm Password should have minimum 3 characters",maxlength:"Confirm Password should have Maximum 30 characters"},
					}
					});
                            ';

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('header', $this->headerData);
            $this->load->view('users/updatemypwd', $this->viewData);
            $this->load->view('footer');
        } else {
            $oldpassword = $this->input->post("oldpassword");
            $password = $this->input->post("password");
            $result = $this->user_model->check_login($this->session->userdata("username"), $oldpassword);
            if($result) {
                $data = array(
                    'password' => $password,
                );
                $result = $this->user_model->update_entry($data, $this->session->userdata("userId"));
                if ($result) {
                    $this->session->set_flashdata('success', 'Updated Successfully');
                    redirect('users/updatemypwd');
                } else {
                    $this->session->set_flashdata('error', 'Error while updating entry. Try again!');
                    redirect('users/updatemypwd');
                }
            } else {
                $this->session->set_flashdata('error', 'Error - Wrong current password. Try again!');
                    redirect('users/updatemypwd');
            }
        }
    }

}
