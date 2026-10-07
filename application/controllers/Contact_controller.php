<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session
 * @property Contact_requests_model $contact_requests
 * @property CI_Config $config
 * @property CI_Loader $load
 */
class Contact_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Contact_requests_model', 'contact_requests');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Contactanos — VerificaPay',
            'meta_description' => 'Dejanos tus datos y nuestro equipo te contactará para contarte más sobre VerificaPay.',
            'meta_keywords' => 'contacto, VerificaPay, consulta',
            'is_contact_page' => TRUE,
            'form_errors' => $this->session->flashdata('form_errors'),
            'form_values' => $this->session->flashdata('form_values'),
            'form_success' => $this->session->flashdata('form_success'),
            'form_error' => $this->session->flashdata('form_error')
        ];

        $this->load->view('layouts/arsha/header', $data);
        $this->load->view('layouts/arsha/navbar', $data);
        $this->load->view('public/contact', $data);
        $this->load->view('layouts/arsha/footer', $data);
        $this->load->view('layouts/arsha/scripts', $data);
    }

    public function submit()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->form_validation->set_rules(
            'full_name',
            'Nombre y apellido',
            'trim|required|min_length[2]|max_length[160]'
        );
        $this->form_validation->set_rules(
            'business_name',
            'Nombre del negocio',
            'trim|required|min_length[2]|max_length[160]'
        );
        $this->form_validation->set_rules(
            'email',
            'Correo electrónico',
            'trim|required|valid_email|max_length[254]'
        );
        $this->form_validation->set_rules(
            'phone',
            'Celular o teléfono',
            'trim|required|min_length[6]|max_length[30]|regex_match[/^[0-9+(). -]+$/]'
        );
        $this->form_validation->set_message('required', 'El campo {field} es obligatorio.');
        $this->form_validation->set_message('min_length', 'El campo {field} debe tener al menos {param} caracteres.');
        $this->form_validation->set_message('max_length', 'El campo {field} no puede superar los {param} caracteres.');
        $this->form_validation->set_message('valid_email', 'Ingresá un correo electrónico válido.');
        $this->form_validation->set_message('regex_match', 'Ingresá un número de teléfono válido.');
        $this->form_validation->set_error_delimiters('', '');

        $fields = ['full_name', 'business_name', 'email', 'phone'];
        $values = [];

        foreach ($fields as $field) {
            $values[$field] = trim((string) $this->input->post($field, FALSE));
        }

        if (!$this->form_validation->run()) {
            $this->session->set_flashdata('form_errors', $this->form_validation->error_array());
            $this->session->set_flashdata('form_values', $values);
            redirect('contacto');
            return;
        }

        $values['email'] = strtolower($values['email']);

        $this->config->load('email', TRUE);
        $email_config = $this->config->item('email');
        $email_body = $this->load->view('emails/contact_request', $values, TRUE);
        $email_text = implode("\n", [
            'Nueva solicitud de contacto de VerificaPay',
            '',
            'Nombre y apellido: ' . $values['full_name'],
            'Negocio: ' . $values['business_name'],
            'Correo: ' . $values['email'],
            'Teléfono: ' . $values['phone']
        ]);

        $contact_request_id = $this->contact_requests->create($values, [
            'recipient' => $email_config['contact_email_to'],
            'subject' => 'Nueva solicitud de contacto - VerificaPay',
            'message' => $email_body,
            'alt_message' => $email_text
        ]);

        if (!$contact_request_id) {
            $database_error = $this->db->error();
            log_message(
                'error',
                'Unable to save and queue a VerificaPay contact request. Database error code: ' .
                (isset($database_error['code']) ? $database_error['code'] : 'unknown')
            );
            $this->session->set_flashdata(
                'form_error',
                'No pudimos guardar tu solicitud. Inténtalo nuevamente en unos minutos.'
            );
            $this->session->set_flashdata('form_values', $values);
            redirect('contacto');
            return;
        }

        $this->session->set_flashdata(
            'form_success',
            '¡Gracias por contactarnos! Recibimos tu solicitud y nuestro equipo se comunicará contigo.'
        );
        redirect('contacto');
    }
}
