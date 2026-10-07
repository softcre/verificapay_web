<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property Usuarios_model $usuarios
 * @property CI_Form_validation $form_validation
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Output $output
 */
class Index_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(
            USUARIOS_MODEL,
            'usuarios'
        );

        $this->load->library([
            'form_validation',
            'session'
        ]);

        $this->load->helper([
            'url',
            'form'
        ]);
    }

    /**
     * Login page
     */
    public function index()
    {
        // Si ya está autenticado, no tiene sentido mostrar
        // nuevamente el formulario de login.
        if ($this->session->userdata('login') === TRUE) {
            $destination = (int) $this->session->userdata('usuario_tipo_id') === 1
                ? DASHBOARD_PATH
                : base_url();
            redirect($destination);
            return;
        }

        $this->viewLogin();
    }

    /**
     * Authenticate user
     */
    public function login()
    {
        verificarConsulAjax();

        $email = trim($this->input->post('email'));
        $pass  = $this->input->post('pass');

        $this->form_validation->set_rules(
            'email',
            'E-mail',
            'required|valid_email'
        );

        $this->form_validation->set_rules(
            'pass',
            'Contraseña',
            'required'
        );

        if (!$this->form_validation->run()) {
            return $this->sendResponse([
                'status' => 'error',
                'title'  => 'Controle los datos',
                'errors' => $this->form_validation->error_array()
            ]);
        }

        $usuario = $this->usuarios->get_user_correo($email);

        if (!$usuario) {
            return $this->sendResponse([
                'status'  => 'error',
                'title'   => 'Error',
                'message' => 'E-mail y/o contraseña incorrectos.'
            ]);
        }

        /*
         * Verificamos la contraseña contra el hash almacenado.
         */
        if (!password_verify($pass, $usuario->password)) {
            return $this->sendResponse([
                'status'  => 'error',
                'title'   => 'Error',
                'message' => 'E-mail y/o contraseña incorrectos.'
            ]);
        }

        /*
         * Regeneramos el ID de sesión después de autenticarnos.
         */
        $this->session->sess_regenerate(TRUE);

        $dataUser = [
            'id'              => $usuario->id_usuario,
            'usuario_tipo_id' => $usuario->usuario_tipo_id,
            'nombre'          => $usuario->nombre,
            'apellido'        => $usuario->apellido,
            'email'           => $usuario->email,
            'foto'            => $usuario->foto,
            'login'           => TRUE
        ];

        $this->session->set_userdata($dataUser);

        return $this->sendResponse([
            'status'  => 'success',
            'title'   => 'Bienvenido',
            'message' => 'Bienvenido ' . $usuario->nombre . '!',
            'url'     => (int) $usuario->usuario_tipo_id === 1
                ? site_url(DASHBOARD_PATH)
                : base_url()
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        $this->session->sess_destroy();

        redirect(base_url());
    }

    /**
     * Login view
     */
    private function viewLogin()
    {
        $data = [
            'title' => 'Acceso - ' . APP_NAME,
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        ];

        $this->load->view(
            'auth/login',
            $data
        );
    }

    /**
     * JSON response
     */
    private function sendResponse($data)
    {
        return $this->output
            ->set_content_type('application/json')
            ->set_output(
                json_encode($data)
            );
    }
}