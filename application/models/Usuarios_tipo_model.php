<?php
class Usuarios_tipo_model extends CI_Model {
    private $table;

    public function __construct() {
        parent::__construct();
        $this->load->database();

        $this->table = 'usuarios_tipo';
    }
    //--------------------------------------------------------------
    public function get_all()
    {
      $this->db->from($this->table);
      $this->db->where('deleted_at', null);
      return $this->db->get()->result();
    }
    //----------------------------------------------------------
    // Read usuario_tipo by ID
    public function get($id_tipo_usuario) {
        $this->db->from($this->table);
        $this->db->where('id_tipo_usuario', $id_tipo_usuario);
        return $this->db->get()->row();
        //$query = $this->db->get($this->table);
        //return $query->row();
    }
    //----------------------------------------------------------
    // Create a new usuario_tipo
    public function crear($usuario_tipo) {
        return $this->db->insert($this->table, $usuario_tipo);
        //return $this->db->insert_id();
    }
    //----------------------------------------------------------
    // Update an existing usuario_tipo
    public function actualizar($id_tipo_usuario, $usuario_tipo) {
        $this->db->where('id_tipo_usuario', $id_tipo_usuario);
        return $this->db->update($this->table, $usuario_tipo);
        //return $this->db->affected_rows();
        
    }
    //----------------------------------------------------------
    // Delete a usuario_tipo
    public function delete($id_tipo_usuario) {
        $this->db->where('id_tipo_usuario', $id_tipo_usuario);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
      
    }
    //----------------------------------------------------------
    

  }
?>
