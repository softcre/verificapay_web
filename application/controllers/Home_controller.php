<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_controller extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'VerificaPay — La certeza de un pago, en tiempo real',
            'meta_description' => 'VerificaPay ayuda a los negocios a consultar movimientos y comprobar transferencias con acceso de solo lectura.',
            'meta_keywords' => 'VerificaPay, verificación de pagos, transferencias, solo lectura',
            'page_title' => 'Inicio'
        ];

        $this->load->view('layouts/arsha/header', $data);
        $this->load->view('layouts/arsha/navbar', $data);
        $this->load->view('public/home', $data);
        $this->load->view('layouts/arsha/footer', $data);
        $this->load->view('layouts/arsha/scripts', $data);
    }
}