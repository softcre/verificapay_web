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
        $this->require_admin();
        $this->load->model('Admin_dashboard_model', 'dashboard');
    }

    public function index()
    {
        $data = [
            'title'      => 'Dashboard - ' . APP_NAME,
            'page_title' => 'Dashboard',
            'summary' => $this->dashboard->get_summary(),
            'queue_summary' => $this->dashboard->get_queue_summary(),
            'recent_leads' => $this->dashboard->get_recent_leads()
        ];

        $this->render_admin(
            'admin/dashboard',
            $data
        );
    }
}