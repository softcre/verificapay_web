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
