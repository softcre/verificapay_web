
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		if (is_cli()) {
			$this->run_migration();
			return;
		}

		$this->load->library(['session', 'form_validation']);
		$this->load->helper(['form', 'url']);

		if ($this->session->userdata('login') !== TRUE) {
			redirect(LOGIN_PATH);
			return;
		}

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
			show_error('No tenés permisos para ejecutar migraciones.', 403);
			return;
		}

		if ($this->input->method(TRUE) === 'POST') {
			$this->run_migration();
			return;
		}

		$this->load->view('admin/migrate', [
			'title' => 'Migraciones de base de datos - ' . APP_NAME
		]);
	}

	private function run_migration()
	{
		$this->load->library('migration');

		if ($this->migration->current() === FALSE) {
			show_error($this->migration->error_string());
			return;
		}

		echo 'Done';
	}
}
