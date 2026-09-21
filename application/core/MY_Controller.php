<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
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