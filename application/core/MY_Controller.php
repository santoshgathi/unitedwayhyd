<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
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