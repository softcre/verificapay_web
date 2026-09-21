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
    }

    /**
     * Render an AdminLTE page.
     *
     * @param string $view
     * @param array  $data
     */
    protected function render_admin($view, $data = [])
    {
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