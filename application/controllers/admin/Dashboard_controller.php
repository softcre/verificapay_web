<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_controller extends CI_Controller
{
    public function index()
    {
        $data = [
            'title'      => 'Admin Dashboard',
            'page_title' => 'Dashboard'
        ];

        $this->load->view('admin/dashboard', $data);
    }
}