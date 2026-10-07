<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_queue_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Email_outbox_model', 'outbox');
        $this->load->model('Admin_audit_model', 'audit');
        $this->load->library('session');
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $status = trim((string) $this->input->get('status'));
        $page = max(1, (int) $this->input->get('page'));
        $per_page = 25;
        $this->render_admin('admin/email_queue/index', [
            'title' => 'Cola de correo - ' . APP_NAME,
            'page_title' => 'Cola de correo',
            'emails' => $this->outbox->get_admin_list($status, $per_page, ($page - 1) * $per_page),
            'selected_status' => $status,
            'page' => $page,
            'per_page' => $per_page,
            'total' => $this->outbox->count_admin_list($status),
            'flash_message' => $this->session->flashdata('admin_message'),
            'flash_type' => $this->session->flashdata('admin_message_type')
        ]);
    }

    public function retry($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->db->trans_begin();
        $retried = $this->outbox->retry_failed((int) $id);
        $audited = $retried && $this->audit->record(
            $this->session->userdata('id'),
            'email_retry_queued',
            'email_outbox',
            (int) $id
        );
        if (!$retried || !$audited || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Unable to retry outbox ID ' . (int) $id . ' or record the audit event.');
            $this->session->set_flashdata('admin_message', 'El correo no existe o no pudo agregarse a la cola.');
            $this->session->set_flashdata('admin_message_type', 'danger');
            redirect('admin/email-queue');
            return;
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('admin_message', 'Correo agregado nuevamente a la cola.');
        $this->session->set_flashdata('admin_message_type', 'success');

        redirect('admin/email-queue');
    }
}
