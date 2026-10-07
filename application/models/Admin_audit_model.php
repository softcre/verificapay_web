<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_audit_model extends CI_Model
{
    public function record($admin_id, $action, $entity_type, $entity_id, $details = NULL)
    {
        return $this->db->insert('admin_audit_log', [
            'admin_user_id' => $admin_id ? (int) $admin_id : NULL,
            'action' => $action,
            'entity_type' => $entity_type,
            'entity_id' => (int) $entity_id,
            'details' => $details,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function get_for_entity($entity_type, $entity_id)
    {
        return $this->db
            ->select('l.*, u.nombre, u.apellido')
            ->from('admin_audit_log l')
            ->join('usuarios u', 'u.id_usuario = l.admin_user_id', 'left')
            ->where('l.entity_type', $entity_type)
            ->where('l.entity_id', (int) $entity_id)
            ->order_by('l.id_admin_audit_log', 'DESC')
            ->limit(100)
            ->get()
            ->result();
    }

    public function get_recent($limit = 100)
    {
        return $this->db
            ->select('l.*, u.nombre, u.apellido')
            ->from('admin_audit_log l')
            ->join('usuarios u', 'u.id_usuario = l.admin_user_id', 'left')
            ->order_by('l.id_admin_audit_log', 'DESC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }
}
