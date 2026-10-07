<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads_controller extends MY_Controller
{
    private $statuses = [
        'new' => 'Nuevo',
        'contacted' => 'Contactado',
        'demo_scheduled' => 'Demostración agendada',
        'closed' => 'Cerrado'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Contact_requests_model', 'contacts');
        $this->load->model('Admin_audit_model', 'audit');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $status = trim((string) $this->input->get('status'));
        $search = trim((string) $this->input->get('q'));
        $page = max(1, (int) $this->input->get('page'));
        $per_page = 20;
        $total = $this->contacts->count_search($status, $search);

        $this->render_admin('admin/leads/index', [
            'title' => 'Solicitudes de contacto - ' . APP_NAME,
            'page_title' => 'Solicitudes de contacto',
            'leads' => $this->contacts->search($status, $search, $per_page, ($page - 1) * $per_page),
            'statuses' => $this->statuses,
            'selected_status' => $status,
            'search' => $search,
            'page' => $page,
            'per_page' => $per_page,
            'total' => $total,
            'flash_message' => $this->session->flashdata('admin_message'),
            'flash_type' => $this->session->flashdata('admin_message_type')
        ]);
    }

    public function detail($id)
    {
        $lead = $this->contacts->get((int) $id);
        if (!$lead) {
            show_404();
            return;
        }

        $this->render_admin('admin/leads/detail', [
            'title' => 'Solicitud #' . (int) $id . ' - ' . APP_NAME,
            'page_title' => 'Solicitud de contacto #' . (int) $id,
            'lead' => $lead,
            'statuses' => $this->statuses,
            'history' => $this->audit->get_for_entity('contact_request', (int) $id),
            'flash_message' => $this->session->flashdata('admin_message'),
            'flash_type' => $this->session->flashdata('admin_message_type')
        ]);
    }

    public function update($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $lead = $this->contacts->get((int) $id);
        if (!$lead) {
            show_404();
            return;
        }

        $status = (string) $this->input->post('status');
        $notes = trim((string) $this->input->post('notes', FALSE));
        $this->form_validation->set_rules('status', 'Estado', 'required|in_list[new,contacted,demo_scheduled,closed]');
        $this->form_validation->set_rules('notes', 'Notas internas', 'max_length[5000]');

        if (!$this->form_validation->run() || !isset($this->statuses[$status])) {
            $this->session->set_flashdata('admin_message', validation_errors() ?: 'Estado inválido.');
            $this->session->set_flashdata('admin_message_type', 'danger');
            redirect('admin/leads/' . (int) $id);
            return;
        }

        $details = 'status=' . $lead->status . '->' . $status;
        if ((string) $lead->notes !== $notes) {
            $details .= '; internal_notes_updated';
        }

        $this->db->trans_begin();
        $updated = $this->contacts->update_admin_fields((int) $id, $status, $notes);
        $audited = $updated && $this->audit->record(
            $this->session->userdata('id'),
            'lead_updated',
            'contact_request',
            (int) $id,
            $details
        );
        if (!$updated || !$audited || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Failed to update contact request ID ' . (int) $id . '.');
            $this->session->set_flashdata('admin_message', 'No se pudo guardar el cambio y su registro de auditoría.');
            $this->session->set_flashdata('admin_message_type', 'danger');
            redirect('admin/leads/' . (int) $id);
            return;
        }
        $this->db->trans_commit();

        $this->session->set_flashdata('admin_message', 'Solicitud actualizada correctamente.');
        $this->session->set_flashdata('admin_message_type', 'success');
        redirect('admin/leads/' . (int) $id);
    }
}
