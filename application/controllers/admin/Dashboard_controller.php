<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Session $session
 */
class Dashboard_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [
            'title'      => 'Dashboard - ' . APP_NAME,
            'page_title' => 'Dashboard'
        ];

        $this->render_admin(
            'admin/dashboard',
            $data
        );
    }
}