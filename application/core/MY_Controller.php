<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base controller for authenticated administration.
 *
 * @property CI_Session $session
 */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        /*
         * All controllers extending MY_Controller require
         * an authenticated session.
         * If not authenticated, return to the public landing page.
         */
        if ($this->session->userdata('login') !== TRUE) {
            redirect(base_url());
            exit;
        }

        $this->require_admin();
    }

    protected function require_admin()
    {
        $user_id = (int) $this->session->userdata('id');
        $account = $user_id > 0
            ? $this->db
                ->select('usuario_tipo_id, activo, deleted_at')
                ->where('id_usuario', $user_id)
                ->get('usuarios')
                ->row()
            : NULL;

        if (
            !$account ||
            (int) $account->usuario_tipo_id !== 1 ||
            (int) $account->activo !== 1 ||
            $account->deleted_at !== NULL
        ) {
            $this->session->sess_destroy();
            show_error('No tenés permisos para acceder a esta sección.', 403);
            exit;
        }
    }

    /**
     * Render an AdminLTE page.
     *
     * @param string $view
     * @param array  $data
     */
    protected function render_admin($view, $data = [])
    {
        $data['current_uri'] = $this->uri->uri_string();
        $data['current_user'] = $this->session->userdata('nombre');
        $data['is_admin'] = (int) $this->session->userdata('usuario_tipo_id') === 1;
        $data['content_view'] = $view;

        $this->load->view(
            'layouts/adminlte/header',
            $data
        );

        $this->load->view(
            'layouts/adminlte/navbar',
            $data
        );

        $this->load->view(
            'layouts/adminlte/sidebar',
            $data
        );

        $this->load->view(
            'layouts/adminlte/content',
            $data
        );

        $this->load->view(
            'layouts/adminlte/footer',
            $data
        );

        $this->load->view(
            'layouts/adminlte/scripts',
            $data
        );
    }
}