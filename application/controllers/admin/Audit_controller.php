<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Admin_audit_model', 'audit');
    }

    public function index()
    {
        $this->render_admin('admin/audit/index', [
            'title' => 'Actividad administrativa - ' . APP_NAME,
            'page_title' => 'Actividad administrativa',
            'events' => $this->audit->get_recent(100)
        ]);
    }
}
