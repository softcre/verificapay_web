<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_controller extends MY_Controller
{
    public function index()
    {
        $data = [
            'title'      => 'Dashboard',
            'page_title' => 'Dashboard'
        ];

        $this->render_admin(
            'admin/dashboard',
            $data
        );
    }
}