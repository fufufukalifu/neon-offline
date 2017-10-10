<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends MX_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = "SEMOET";
        $this->load->view("r_index_homepage", $data);
        }
    
    
    
}
