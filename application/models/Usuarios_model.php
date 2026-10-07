<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuarios_model extends CI_Model
{
	private $table;
  private $tableUsuariosTipo;

  //--------------------------------------------------------------
  public function __construct()
  {
    parent::__construct();
    $this->load->database();


    $this->table = 'usuarios';
    $this->tableUsuariosTipo = 'usuarios_tipo';

  }

	//--------------------------------------------------------------
	public function get_all()
	{
		$this->db->from($this->table . ' u');
    $this->db->join($this->tableUsuariosTipo . ' ut', 'u.usuario_tipo_id = ut.id_tipo_usuario', 'left');
		$this->db->where('deleted_at', null);
		return $this->db->get()->result();
	}

    public function get_admin_list()
    {
        return $this->db
            ->select('u.id_usuario, u.usuario_tipo_id, u.nombre, u.apellido, u.email, u.activo, u.created_at, ut.tipo_usuario')
            ->from($this->table . ' u')
            ->join($this->tableUsuariosTipo . ' ut', 'u.usuario_tipo_id = ut.id_tipo_usuario', 'left')
            ->where('u.deleted_at', NULL)
            ->order_by('u.id_usuario', 'ASC')
            ->get()
            ->result();
    }

    public function get_active_admin_count()
    {
        return $this->db
            ->where('usuario_tipo_id', 1)
            ->where('activo', 1)
            ->where('deleted_at', NULL)
            ->count_all_results($this->table);
    }

    public function create_admin_user(array $user)
    {
        return $this->db->insert($this->table, $user) ? $this->db->insert_id() : FALSE;
    }

    public function update_admin_user($id, $role_id, $active)
    {
        return $this->db
            ->where('id_usuario', (int) $id)
            ->where('deleted_at', NULL)
            ->update($this->table, [
                'usuario_tipo_id' => (int) $role_id,
                'activo' => (int) $active,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

  
	//--------------------------------------------------------------
	public function get($id_usuario)
	{
        $this->db->select('u.*, ut.*');
        //$this->db->select('u.*, ut.tipo_usuario');
        $this->db->from($this->table . ' u');
        $this->db->join($this->tableUsuariosTipo . ' ut', 'u.usuario_tipo_id = ut.id_tipo_usuario', 'left');
        $this->db->where('u.id_usuario', $id_usuario);
		    return $this->db->get()->row();
	}
	//--------------------------------------------------------------
	public function get_user_correo($correo)
  {
      $this->db->where('email', $correo);
      $this->db->where('activo', 1);
      $this->db->where('deleted_at', null);

      return $this->db
          ->get($this->table)
          ->row();
  }
  //--------------------------------------------------------------
	public function get_user_correo_id($correo,$id_usuario)
	{
		$this->db->where('email', $correo);
		$this->db->where('id_usuario !=', $id_usuario);
		$this->db->where('deleted_at', null);
		return $this->db->get($this->table)->row();
	}
  //--------------------------------------------------------------
  // Create a new usuario (a probar)
  public function crear($usuario) {
      $this->db->insert($this->table, $usuario);
      return $this->db->insert_id();
  }
	//--------------------------------------------------------------
	public function actualizar($id_usuario, $usuario)
	{
		$this->db->where('id_usuario', $id_usuario);
		return $this->db->update($this->table, $usuario);
	}
  //--------------------------------------------------------------
  // Delete a usuario
  public function delete($id_usuario) {
      $this->db->where('id_usuario', $id_usuario);
      $this->db->delete($this->table);
      return $this->db->affected_rows();
  }
  //--------------------------------------------------------------
}
