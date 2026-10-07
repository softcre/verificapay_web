<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->require_admin();
        $this->load->model('Usuarios_model', 'users');
        $this->load->model('Admin_audit_model', 'audit');
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['form', 'url']);
    }

    public function index()
    {
        $this->render_admin('admin/users/index', [
            'title' => 'Usuarios - ' . APP_NAME,
            'page_title' => 'Usuarios y accesos',
            'users' => $this->users->get_admin_list(),
            'flash_message' => $this->session->flashdata('admin_message'),
            'flash_type' => $this->session->flashdata('admin_message_type')
        ]);
    }

    public function create()
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('apellido', 'Apellido', 'trim|max_length[100]');
        $this->form_validation->set_rules('email', 'Correo', 'trim|required|valid_email|max_length[150]');
        $this->form_validation->set_rules('password', 'Contraseña', 'required|min_length[12]|max_length[72]');
        $this->form_validation->set_rules('usuario_tipo_id', 'Rol', 'required|in_list[1,2]');

        $email = strtolower(trim((string) $this->input->post('email')));
        if (!$this->form_validation->run()) {
            $this->set_error(validation_errors());
            redirect('admin/users');
            return;
        }

        if ($this->users->get_user_correo_id($email, 0)) {
            $this->set_error('Ya existe una cuenta con ese correo.');
            redirect('admin/users');
            return;
        }

        $this->db->trans_begin();
        $user_id = $this->users->create_admin_user([
            'usuario_tipo_id' => (int) $this->input->post('usuario_tipo_id'),
            'nombre' => trim((string) $this->input->post('nombre')),
            'apellido' => trim((string) $this->input->post('apellido')),
            'email' => $email,
            'password' => password_hash((string) $this->input->post('password'), PASSWORD_DEFAULT),
            'foto' => 'no-user.jpg',
            'activo' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$user_id || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Unable to create an admin-managed user account.');
            $this->set_error('No se pudo crear la cuenta. Verificá los datos e inténtalo nuevamente.');
            redirect('admin/users');
            return;
        }

        if (!$this->audit->record($this->session->userdata('id'), 'user_created', 'user', $user_id, 'role=' . (int) $this->input->post('usuario_tipo_id'))) {
            $this->db->trans_rollback();
            log_message('error', 'Failed to record audit entry for user ID ' . (int) $user_id . '.');
            $this->set_error('No se pudo guardar el registro de auditoría; la cuenta no fue creada.');
            redirect('admin/users');
            return;
        }
        $this->db->trans_commit();

        $this->set_message('Cuenta creada correctamente.', 'success');
        redirect('admin/users');
    }

    public function update($id)
    {
        if ($this->input->method(TRUE) !== 'POST') {
            show_404();
            return;
        }

        $id = (int) $id;
        $user = $this->users->get($id);
        if (!$user || $user->deleted_at !== NULL) {
            show_404();
            return;
        }

        $role_id = (int) $this->input->post('usuario_tipo_id');
        $active = $this->input->post('activo') === '1' ? 1 : 0;
        if (!in_array($role_id, [1, 2], TRUE)) {
            $this->set_error('Rol inválido.');
            redirect('admin/users');
            return;
        }

        if ($id === (int) $this->session->userdata('id') && ($role_id !== 1 || $active !== 1)) {
            $this->set_error('No podés quitarte el acceso de administrador ni desactivar tu propia cuenta.');
            redirect('admin/users');
            return;
        }

        $this->db->trans_begin();
        if ((int) $user->usuario_tipo_id === 1 && (int) $user->activo === 1 && ($role_id !== 1 || $active !== 1)) {
            $this->db->query(
                'SELECT id_usuario FROM usuarios WHERE usuario_tipo_id = 1 AND activo = 1 AND deleted_at IS NULL FOR UPDATE'
            );
            if ($this->users->get_active_admin_count() <= 1) {
                $this->db->trans_rollback();
                $this->set_error('Debe permanecer al menos un administrador activo.');
                redirect('admin/users');
                return;
            }
        }

        $updated = $this->users->update_admin_user($id, $role_id, $active);
        if (!$updated || $this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Unable to update user account ID ' . $id . '.');
            $this->set_error('No se pudo actualizar la cuenta.');
            redirect('admin/users');
            return;
        }
        $details = 'role=' . (int) $user->usuario_tipo_id . '->' . $role_id .
            '; active=' . (int) $user->activo . '->' . $active;
        if (!$this->audit->record($this->session->userdata('id'), 'user_updated', 'user', $id, $details)) {
            $this->db->trans_rollback();
            log_message('error', 'Failed to record audit entry for user ID ' . $id . '.');
            $this->set_error('No se pudo guardar el registro de auditoría; los cambios no se aplicaron.');
            redirect('admin/users');
            return;
        }
        $this->db->trans_commit();

        $this->set_message('Cuenta actualizada correctamente.', 'success');
        redirect('admin/users');
    }

    private function set_error($message)
    {
        $this->set_message(strip_tags($message), 'danger');
    }

    private function set_message($message, $type)
    {
        $this->session->set_flashdata('admin_message', $message);
        $this->session->set_flashdata('admin_message_type', $type);
    }
}
