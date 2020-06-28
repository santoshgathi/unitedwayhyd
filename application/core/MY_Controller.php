<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        // check login
        if (!$this->session->userdata('loggedin')) {
            redirect('login/logout');
        }
        // for ajox ignore authorization
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //ajax call
        } else {
            // This is not an ajax call 
            // check authorization
            if (!$this->check_access($this->router->fetch_class() . '/' . $this->router->fetch_method())) {
                //echo $this->check_access($this->router->fetch_class() . '/' . $this->router->fetch_method());
                redirect('login/logout');
                exit;
            }
        }
    }

    public function user_menu($role) {

        $menu = array(
            // menu for admin role          
            'admin' =>  array(
                'eightyg'=> '80G',
                'donors' => 'Donors',
                //'hyperledger_fabric/design' => 'Fabric Design',
                //'hyperledger_fabric/workflow' => 'Workflow',
                'areas' => 'Areas',
                'expenditures' => 'Expenditures',
                'appointments' => 'Appiontments',
                'users' => 'Users'
            ),
            // menu for student role
            'employee' => array(
                'appointments' => 'Appiontments',
                //'#' => 'Bitcoin',
                //'#' => 'Blockchain problem solving',
                //'#' => 'Use cases',
            )    
        );
        //return $menu[$role];
        return $this->build_menu($menu[$role]);
    }

    private function build_menu($menu_items) {
        $menu = "";
        $icon = ['eightyg' => 'copy', 'donors' => 'user-friends', 'areas' => 'map-marker-alt', 'expenditures' => 'money-bill-alt', 'appointments' => 'clock', 'users' => 'user'];
        foreach($menu_items as $k => $v) {
            $menu = $menu.'<li class="nav-item">';
            $menu = $menu.anchor($k, '<i class="nav-icon fas fa-'.$icon[$k].'"></i><p>'.$v.'</p>', 'class="nav-link"');
            $menu = $menu.'</li>';
        }
        return $menu;
    }

    private function check_access($resource) {
        $acl = array(
            'admin' => array(
                'welcome/index',
                'eightyg/index', 'eightyg/create', 'eightyg/update', 'eightyg/fileupload', 'eightyg/do_upload', 
                'donors/index', 'donors/create', 'donors/update', 
                'areas/index', 'areas/create', 'areas/update', 
                'expenditures/index', 'expenditures/create', 'expenditures/update', 
                'appointments/index', 'appointments/approve',
                'users/index', 'users/create', 'users/update',                
            ),
            'employee' => array(
                'welcome/index',
                'appointments/index', 'appointments/create', 'hyperledger_fabric/architecture', 
                'hyperledger_fabric/dlt', 'hyperledger_fabric/design', 'hyperledger_fabric/transactions_lifecycle',
                'hyperledger_fabric/getting_started', 
                'hyperledger_fabric/membership',
            ),
            'student' => array(
                'welcome/index',
                'myaccount/index', 'myaccount/password',
                'blockchain/index', 'blockchain/distributed_network', 'blockchain/introduction',
                'blockchain/how_works', 'blockchain/types','blockchain/risks',
                'blockchain/cryptography',
            ),
        );
        return in_array($resource, $acl[$this->session->userdata('user_role')]);
    }

    public function pagination_config_array($url, $per_page = 25) {
        return array('base_url' => base_url() . $url,
            'page_query_string' => TRUE,
            'reuse_query_string' => TRUE,
            //'use_page_numbers' => TRUE,
            'full_tag_open' => '<ul class="pagination justify-content-center animation">',
            'full_tag_close' => '</ul>',
            'first_tag_open' => '<li class="page-item rounded-2">',
            'first_tag_close' => '</li>',
            'last_tag_open' => '<li class="page-item rounded-2">',
            'last_tag_close' => '</li>',
            'next_tag_open' => '<li class="page-item rounded-2">',
            'next_tag_close' => '</li>',
            'prev_tag_open' => '<li class="page-item rounded-2">',
            'prev_tag_close' => '</li>',
            'cur_tag_open' => '<li  class="page-item rounded-2 active"><a href="#" class="page-link">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',
            'num_tag_close' => '</li>',
            'attributes' => array('class' => 'page-link'),
            'per_page' => $per_page);
    }

    public function pagination_summary($startRow, $perPage, $totalRows) {

        if ((int) ($totalRows) > 0) {
            $endRow = 0;
            if ((int) ($startRow + $perPage) > (int) $totalRows) {
                $endRow = $totalRows;
            } else {
                $endRow = $startRow + $perPage;
            }
            return 'Showing ' . ($startRow + 1) . ' to ' . $endRow . ' of ' . $totalRows . ' entries';
        } else {
            return 'No Records';
        }
    }
}